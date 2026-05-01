# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**e-DAFTAR Kedah** is a web and mobile-based QR attendance system for Kedah state government civil servants. The system digitizes course/meeting registration and attendance tracking, replacing manual paper-based sign-in sheets with QR code scanning.

**Current Status**: This repository currently contains only the Product Requirements Document (PRD). No code has been implemented yet.

**Primary Language**: The system will serve users in Bahasa Malaysia and English, with Malay being the primary language for UI and documentation.

## Key System Components (Planned)

Based on the PRD (`PRD_eDaftar_Kedah_3.md`), the system architecture will include:

### Core Modules
- **Authentication & User Management**: User registration via IC number (No. KP) and employee number, 2FA via OTP, role-based access control (RBAC)
- **Event Management**: Event registration, multi-day event support, hybrid (physical/online) events
- **QR Code Generation**: Static and dynamic QR codes (rotating every 30 seconds to prevent sharing)
- **Attendance Tracking**: QR scanning via mobile/web, geolocation verification, check-in/check-out logging
- **Participant Replacement**: Pre-event and walk-in participant substitution workflows with approval mechanisms
- **Notifications**: Email/SMS for invitations, H-1 and H-1hour reminders
- **Reporting & Dashboard**: Real-time attendance dashboards, PDF/Excel export, training hour tracking for LNPT (annual performance evaluation)
- **Certificate Generation**: Automated digital certificate generation with digital signatures

### Technical Requirements
- **Compliance**: Must comply with PDPA 2010 (Malaysia's Personal Data Protection Act) and MAMPU ICT security guidelines
- **Data Format**: CSV import/export must follow MAMPU standard format
- **Integration**: API endpoints for future integration with existing government systems (HRMIS integration planned for Phase 3)
- **Multi-tenant**: Support for multiple government departments under Kedah state

### User Roles (RBAC)
The system will implement hierarchical role-based access:
- **Super Admin**: Statewide system administrator (Pejabat SUK)
- **Admin Jabatan**: Department administrator
- **Penyelaras/Event Organizer**: Course/meeting coordinators
- **Pengarah/Director**: Department heads (view-only dashboards)
- **Peserta/Participant**: Civil servants attending events
- **Temporary Delegation**: Support for acting roles and temporary delegation

### Key Features
- **QR Types**:
  - Static QR: One QR for entire event
  - Dynamic QR: Rotating QR every 30 seconds (anti-sharing mechanism)
- **Event Types**:
  - Physical events: QR scan with geolocation radius verification
  - Online events: Unique attendance links or screen-displayed QR
  - Hybrid events: Both mechanisms running in parallel
- **Multi-day Events**: Per-session attendance tracking, partial attendance certificates, session-specific participant replacement
- **Training Hour Tracking**: Automatic accumulation toward 56-hour annual LNPT requirement, categorized by event type

## Important Domain Knowledge

### Terminology
- **LNPT**: Laporan Nilaian Prestasi Tahunan (Annual Performance Evaluation Report)
- **SUK**: Setiausaha Kerajaan Negeri (State Secretary Office)
- **No. KP**: Nombor Kad Pengenalan (IC Number - 12 digits, unique identifier)
- **No. Pekerja**: Employee Number
- **PTJ**: Pusat Tanggungjawab (Responsibility Center/Department Code)
- **Penjawat Awam**: Civil servant
- **Wakil**: Substitute/replacement participant
- **Gred**: Government grade (e.g., N32, N29)

### Business Rules
- **Attendance Threshold**: Minimum 80% attendance for full certificate, 50-80% for partial certificate, <50% no certificate
- **Training Hours**: 56 hours annual target for civil servants
- **Participant Replacement**:
  - Pre-event: Requires organizer approval
  - Walk-in: Real-time approval via mobile notification (5-minute SLA)
  - "Open replacement mode": Auto-approval for same department
- **Multi-day Attendance Calculation**: `(attended mandatory session hours ÷ total mandatory session hours) × 100%`

### Security Considerations
- **QR Anti-sharing**: Dynamic QR rotation prevents screenshot sharing
- **Geolocation**: Radius-based verification for physical events (radius configurable per event)
- **Audit Logging**: All participant replacements, role assignments, delegations must be logged
- **Data Protection**: Comply with PDPA 2010 - no sensitive data in logs, secure storage of IC numbers

## Development Guidelines (When Implementation Begins)

### Coding Standards
- Use Bahasa Malaysia for user-facing strings, with English translation support
- Follow MAMPU ICT security guidelines for government systems
- Implement comprehensive audit logging for all critical operations
- Design for multi-tenancy from the start (department isolation)

### Critical Business Rules to Remember

When implementing features, always refer to `RULES.md` for complete details. Here are the most critical rules:

**Authentication & Security**:
- **Dynamic QR rotation**: QR codes for `qr_mod = 'dinamik'` must rotate every 30 seconds
- **Token revocation**: When roles are revoked, invalidate session tokens within 60 seconds
- **No. KP uniqueness**: IC numbers must be unique across the system (12 digits exactly)

**Attendance & Calculation**:
- **Attendance formula**: `(sesi_wajib_dihadiri ÷ jumlah_sesi_wajib) × 100`
- **Certificate thresholds**: ≥80% = Full, 50-79% = Partial, <50% = None (configurable per event)
- **80% rule**: For check-in/check-out events, must attend ≥80% of session duration to receive credit
- **Optional sessions**: Don't count toward attendance %, but add to training hours

**Substitution**:
- **No chain substitution**: Substitute cannot be substituted again (prevent A→B→C)
- **Mutual exclusivity**: If substitute approved for session X, original participant CANNOT attend session X
- **Training hours**: Credited to substitute (person who actually attended), NOT original participant

**Geolocation**:
- **Radius validation**: Use `ST_Distance_Sphere` to calculate distance, verify ≤ `radius_geo_meter`
- **Default radius**: 100 meters (range: 50-1000m)
- **Online events**: Disable geolocation verification entirely

**RBAC**:
- **Permission union**: Multiple roles = union of all permissions (most permissive wins)
- **Auditor read-only**: Hard-coded restriction - even if accidentally granted write permission, deny it
- **Department scope**: Query scopes automatically filter by `skop_jabatan_id`

**Data Validation**:
- **Always validate at backend**: Never trust client-side validation alone
- **Email domain**: Must be `.gov.my` for civil servants
- **Date constraints**: `end_date >= start_date`, session dates within event period
- **IC format**: 12 digits, first 6 = valid date (YYMMDD), digits 7-8 = valid state code (01-16)

### Testing Requirements
- Test QR scanning on both Android and iOS devices
- Test geolocation accuracy across different GPS providers
- Test dynamic QR rotation timing and security
- Load testing for concurrent event check-ins (target: 500+ users scanning within 5 minutes)
- Test CSV import with MAMPU standard format

### Data Privacy
- Encrypt IC numbers (No. KP) at rest
- Implement proper access control - users can only see their own department data unless authorized
- Log access to personal data for audit purposes
- Implement data retention policies per PDPA requirements

### Mobile Considerations
- QR scanner must work in low-light conditions
- Offline mode for remote locations with poor connectivity (sync when online)
- Push notifications for event organizers (replacement approvals, low attendance alerts)

## Common Tasks (To Be Updated When Codebase Exists)

This section will be populated when the actual implementation begins. It will include:

### Development Setup
- How to set up the development environment
- How to run the application locally (Laravel + Vue/Inertia)
- Database migration commands: `php artisan migrate`
- Seed default data: `php artisan db:seed`

### Testing
- Run tests: `php artisan test`
- Run specific test suite: `php artisan test --testsuite=Feature`
- Test EPSM API integration: `php artisan epsm:health-check`

### EPSM API Operations
- Sync user with EPSM: `php artisan epsm:sync-user {no_kp}`
- Bulk sync all users: `php artisan epsm:sync-all` (scheduled daily)
- Clear EPSM cache: `php artisan cache:forget "epsm_staff_{NO_KP}"`
- Check API health: `php artisan epsm:health-check`

### QR Code Operations
- Generate QR codes for events
- Regenerate dynamic QR (rotates every 30 seconds)
- Test QR scanning endpoints

### Certificate Generation
- Generate certificates: `php artisan certificates:generate {event_id}`
- Regenerate certificate: `php artisan certificates:regenerate {certificate_id}`

### User & Role Management
- Import users via CSV: `php artisan users:import {file.csv}`
- Assign role: `php artisan user:assign-role {user_id} {role_name} --department={dept_id}`
- List users by role: `php artisan users:by-role {role_name}`

### Queue & Jobs
- Run queue worker: `php artisan queue:work`
- Monitor queues: `php artisan horizon` (if using Horizon)
- Process email notifications
- Process certificate generation jobs

### Deployment
- Build for production: `npm run build`
- Clear all caches: `php artisan optimize:clear`
- Run migrations: `php artisan migrate --force`

## External API Integration

### EPSM Staff Data API

The system integrates with the **Kedah State Government EPSM API** to auto-populate staff information during user registration.

**API Endpoint**: `https://epsm.kedah.gov.my/api_kuarters.php`

**Key Integration Points**:
1. **User Registration**: When a user enters their No. KP (IC Number), the system calls EPSM API to fetch staff data
2. **Auto-fill Profile**: If found in EPSM, auto-populate name, employee number, email, department, position, grade
3. **Manual Fallback**: If not found in EPSM, user fills information manually
4. **Profile Sync**: Existing users can sync their profile with EPSM data via "Sync with EPSM" button

**Implementation Details**:
- Service class: `app/Services/EpsmApiService.php`
- Caching: 60 minutes (configurable) to reduce API calls
- Rate limiting: 60 requests per minute max
- Error handling: Graceful fallback to manual entry on API failure
- Security: API secret key stored in `.env`, never in code
- Audit trail: Raw EPSM response stored in `users.epsm_raw_data` JSON field

**Configuration** (`.env`):
```ini
EPSM_API_URL=https://epsm.kedah.gov.my/api_kuarters.php
EPSM_API_SECRET_KEY=DigitalPKN2021
EPSM_API_TIMEOUT=10
EPSM_API_CACHE_MINUTES=60
```

**Database Fields** (added to `users` table):
- `epsm_verified` (BOOLEAN): Whether user data was verified with EPSM API
- `epsm_last_synced_at` (TIMESTAMP): Last successful sync timestamp
- `epsm_raw_data` (JSON): Raw EPSM API response for audit trail

**See**: `API_INTEGRATION.md` for complete integration specification, workflows, and troubleshooting guide.

## Reference Documents

- **Primary Requirements**: `PRD_eDaftar_Kedah_3.md` - Comprehensive PRD in Bahasa Malaysia (v1.4, dated May 1, 2026)
  - Contains detailed user flows (sections 8.1-8.11)
  - Contains functional requirements (section 9)
  - Contains non-functional requirements (section 10)
  - Contains UI/UX wireframes (section 11)
  - Contains deployment architecture (section 12)
  - Contains security requirements (section 13)
- **Database Schema**: `ERD.md` - Complete Entity Relationship Diagram with 18 tables
- **API Integration**: `API_INTEGRATION.md` - EPSM API integration specification
- **Business Rules**: `RULES.md` - Complete business rules, validation rules, calculation formulas, and compliance requirements (200+ rules across 15 categories)

## Future Phases (Out of Scope for v1.0)

- Financial management/allowance claims integration
- Learning Management System (LMS) features
- Performance evaluation (quizzes, tests)
- HRMIS integration (planned for Phase 3)
