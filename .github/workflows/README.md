# GitHub Actions Workflows

This directory contains automated CI/CD workflows for the e-DAFTAR Kedah project.

## Workflows

### 1. CI Pipeline (`ci.yml`)

**Triggers**: Push to `main`/`develop`, Pull Requests

**Jobs**:
- **Tests**: Runs PHPUnit tests with MySQL and Redis
  - Tests on PHP 8.3 and 8.4
  - Requires 80% code coverage
  - Uploads coverage to Codecov
- **Code Style**: Validates code formatting with Laravel Pint
- **Static Analysis**: Runs Larastan (PHPStan for Laravel)
- **Security**: Runs `composer audit` for dependency vulnerabilities

**Required Secrets**: None (uses GitHub Actions services)

### 2. Deploy to Staging (`deploy-staging.yml`)

**Triggers**: Push to `develop` branch, Manual dispatch

**Jobs**:
- Builds production assets
- Creates deployment archive
- Deploys to staging server via SSH
- Runs migrations and cache optimization
- Creates automatic backups before deployment

**Required Secrets**:
- `STAGING_HOST`: Staging server hostname/IP
- `STAGING_USER`: SSH username
- `STAGING_SSH_KEY`: Private SSH key for authentication
- `STAGING_PORT`: SSH port (default: 22)
- `STAGING_PATH`: Deployment path on server (e.g., `/var/www/edaftar-staging`)

**Setup**:
1. Go to Settings → Environments → Create environment "staging"
2. Add required secrets to the staging environment
3. Generate SSH key pair: `ssh-keygen -t ed25519 -C "github-actions"`
4. Add public key to staging server: `~/.ssh/authorized_keys`
5. Add private key to GitHub secrets as `STAGING_SSH_KEY`

### 3. Database Backup (`database-backup.yml`)

**Triggers**: Daily at 2:00 AM UTC (10:00 AM MYT), Manual dispatch

**Jobs**:
- Creates mysqldump of production database
- Compresses backup with gzip
- Uploads to AWS S3 with STANDARD_IA storage class
- Retains local backups for 7 days
- Retains S3 backups for 90 days
- Sends notifications on success/failure

**Required Secrets**:
- `PROD_DB_HOST`: Production database host
- `PROD_DB_USER`: Database username
- `PROD_DB_PASSWORD`: Database password
- `PROD_DB_NAME`: Database name (edaftar_kedah)
- `PROD_SSH_USER`: SSH username for database server
- `PROD_SSH_KEY`: SSH private key
- `PROD_SSH_PORT`: SSH port
- `AWS_ACCESS_KEY_ID`: AWS access key
- `AWS_SECRET_ACCESS_KEY`: AWS secret key
- `AWS_REGION`: AWS region (e.g., ap-southeast-1)
- `BACKUP_S3_BUCKET`: S3 bucket name for backups

**Setup**:
1. Create S3 bucket for backups with versioning enabled
2. Set up lifecycle policy to delete old backups after 90 days
3. Create IAM user with S3 write permissions
4. Add secrets to production environment in GitHub

## Branch Protection Rules

### Main Branch (`main`)
1. Go to Settings → Branches → Add rule
2. Branch name pattern: `main`
3. Enable:
   - ✅ Require a pull request before merging
   - ✅ Require approvals (1+)
   - ✅ Require status checks to pass before merging
     - Required checks: `Tests (PHP 8.4)`, `Code Style (Laravel Pint)`, `Static Analysis (Larastan)`, `Security Check`
   - ✅ Require conversation resolution before merging
   - ✅ Do not allow bypassing the above settings

### Develop Branch (`develop`)
1. Same rules as main but allow 0 approvals for faster iteration

## Local Testing

### Run tests locally:
```bash
php artisan test
```

### Check code style:
```bash
./vendor/bin/pint --test
```

### Fix code style:
```bash
./vendor/bin/pint
```

### Run static analysis:
```bash
./vendor/bin/phpstan analyse
```

### Security audit:
```bash
composer audit
```

## Manual Deployment

For emergency deployments or first-time setup, you can trigger workflows manually:

1. Go to Actions tab
2. Select workflow
3. Click "Run workflow"
4. Select branch
5. Click "Run workflow" button

## Troubleshooting

### CI tests failing on MySQL connection
- Ensure MySQL service is healthy before running tests
- Check `health-cmd` in workflow configuration

### Deployment fails on staging
- Verify SSH key has correct permissions on server
- Check server disk space: `df -h`
- Verify PHP/Composer versions match requirements
- Check server logs: `tail -f /var/log/nginx/error.log`

### Backup fails
- Verify mysqldump is installed on database server
- Check database credentials are correct
- Verify S3 bucket permissions
- Check disk space on server: `df -h ~/backups/database`

## Notifications

To add Slack notifications, add this step to any workflow:

```yaml
- name: Slack notification
  uses: 8398a7/action-slack@v3
  with:
    status: ${{ job.status }}
    text: 'Deployment to staging'
    webhook_url: ${{ secrets.SLACK_WEBHOOK }}
  if: always()
```
