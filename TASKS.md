# Project Implementation Tasks
# e-DAFTAR Kedah - QR Attendance System

## Document Overview

This document provides a complete task breakdown for implementing the e-DAFTAR Kedah system, organized by phases, modules, and priorities. Each task includes effort estimation, dependencies, and acceptance criteria.

**Version**: 1.0
**Last Updated**: 2026-05-01
**Project Duration**: Estimated 6-9 months for full implementation

---

## Table of Contents

1. [Project Phases Overview](#project-phases-overview)
2. [Phase 0: Project Setup & Infrastructure](#phase-0-project-setup--infrastructure)
3. [Phase 1: MVP (Core Features)](#phase-1-mvp-core-features)
4. [Phase 2: Advanced Features](#phase-2-advanced-features)
5. [Phase 3: Integration & Optimization](#phase-3-integration--optimization)
6. [Ongoing Tasks](#ongoing-tasks)
7. [Effort Estimation Guide](#effort-estimation-guide)
8. [Task Dependencies Matrix](#task-dependencies-matrix)
9. [Team Structure](#team-structure)

---

## Project Phases Overview

### Phase 0: Project Setup (2-3 weeks)
**Goal**: Set up development infrastructure, CI/CD, and basic project structure

**Key Deliverables**:
- Development environment ready
- Database schema implemented
- Basic authentication working
- CI/CD pipeline configured

### Phase 1: MVP - Core Features (10-12 weeks)
**Goal**: Deliver minimum viable product with essential attendance tracking

**Key Deliverables**:
- User registration with EPSM integration
- Single-day event creation & management
- QR code generation (static mode)
- Physical event attendance (with geolocation)
- Basic reporting
- Certificate generation

**Success Criteria**:
- 1 pilot department can conduct 1 single-day course with 50 participants
- QR scanning works on mobile browsers
- Certificates auto-generated

### Phase 2: Advanced Features (8-10 weeks)
**Goal**: Multi-day events, online/hybrid support, advanced attendance tracking

**Key Deliverables**:
- Multi-day events with sessions
- Dynamic QR codes (30s rotation)
- Online and hybrid event support
- Participant substitution workflows
- Advanced RBAC with delegation
- Training hours tracking
- Enhanced reporting & dashboards

**Success Criteria**:
- Support 5-day course with 200 participants
- Handle 10 concurrent events
- Real-time attendance dashboard

### Phase 3: Integration & Polish (6-8 weeks)
**Goal**: System integration, performance optimization, production readiness

**Key Deliverables**:
- Progressive Web App (PWA) for mobile
- Bulk operations & imports
- Advanced analytics
- API documentation
- Performance optimization
- Load testing & security audit

**Success Criteria**:
- Support 500 concurrent users
- Pass penetration testing
- 99.5% uptime SLA met
- Full documentation complete

---

## Phase 0: Project Setup & Infrastructure

### SETUP-001: Development Environment Setup
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: DevOps Lead + Backend Lead

**Tasks**:
- [x] Install Laravel 11 with PHP 8.2+
- [x] Set up MySQL 8.0 database
- [x] Install Redis for caching and queues
- [x] Configure MinIO/S3 for file storage
- [x] Set up local development with Docker Compose
- [x] Create `.env.example` with all required variables

**Dependencies**: None

**Acceptance Criteria**:
- `php artisan serve` runs successfully
- Database connection works
- Redis connection works
- All team members can run project locally

---

### SETUP-002: Version Control & CI/CD Setup
**Priority**: Must Have
**Effort**: 2 days
**Assigned To**: DevOps Lead

**Tasks**:
- [ ] Initialize Git repository
- [ ] Set up GitHub/GitLab repository
- [ ] Configure branch protection rules (main branch)
- [ ] Set up GitHub Actions / GitLab CI pipeline
  - [ ] Run tests on PR
  - [ ] Check code style (Laravel Pint)
  - [ ] Run static analysis (PHPStan/Larastan)
- [ ] Configure automatic deployment to staging
- [ ] Set up database backup automation

**Dependencies**: SETUP-001

**Acceptance Criteria**:
- PR to main triggers automated tests
- Failed tests block merge
- Deployment to staging is automated

---

### SETUP-003: Database Schema Implementation
**Priority**: Must Have
**Effort**: 5 days
**Assigned To**: Backend Lead

**Tasks**:
- [ ] Create migration for `jabatan` table
- [ ] Create migration for `users` table with EPSM fields
- [ ] Create migration for `acara` table
- [ ] Create migration for `sesi` table
- [ ] Create migration for `peserta_acara` table
- [ ] Create migration for `kehadiran_sesi` table
- [ ] Create migration for `kehadiran` table
- [ ] Create migration for `gantian` table
- [ ] Create migration for `pengesahan_berterusan` table
- [ ] Create migration for `sijil` table
- [ ] Create migration for `jam_latihan_tahunan` table
- [ ] Create RBAC migrations:
  - [ ] `peranan` table
  - [ ] `kebenaran` table
  - [ ] `peranan_kebenaran` pivot
  - [ ] `pengguna_peranan` table
  - [ ] `delegasi_peranan` table
  - [ ] `pemilikan_resource` table
- [ ] Create migration for `audit_log` table
- [ ] Add all indexes, foreign keys, and constraints
- [ ] Create database seeders for:
  - [ ] Default roles (9 roles)
  - [ ] Default permissions (~80 permissions)
  - [ ] Role-permission matrix
  - [ ] Sample departments (5-10)
  - [ ] Super admin user

**Dependencies**: SETUP-001

**Reference**: ERD.md sections 1-18

**Acceptance Criteria**:
- `php artisan migrate:fresh --seed` runs without errors
- All tables created with correct structure
- Foreign keys and constraints work
- Seeded data includes 9 roles, permissions, and 1 super admin

---

### SETUP-004: Eloquent Models & Relationships
**Priority**: Must Have
**Effort**: 4 days
**Assigned To**: Backend Developer 1

**Tasks**:
- [ ] Create `User` model with relationships
- [ ] Create `Jabatan` model
- [ ] Create `Acara` model with relationships
- [ ] Create `Sesi` model
- [ ] Create `PesertaAcara` model
- [ ] Create `KehadiranSesi` model
- [ ] Create `Kehadiran` model
- [ ] Create `Gantian` model
- [ ] Create `Sijil` model
- [ ] Create `JamLatihanTahunan` model
- [ ] Create RBAC models (Peranan, Kebenaran, etc.)
- [ ] Create `AuditLog` model
- [ ] Define all relationships (hasMany, belongsTo, belongsToMany)
- [ ] Set up model factories for testing
- [ ] Configure soft deletes where applicable

**Dependencies**: SETUP-003

**Acceptance Criteria**:
- All models created with proper namespaces
- Relationships work (can query related data)
- Factories can generate test data
- Mass assignment protection configured

---

### SETUP-005: Base Infrastructure Services
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: Backend Developer 2

**Tasks**:
- [ ] Set up Laravel Sanctum for API authentication
- [ ] Configure Laravel Horizon for queue management
- [ ] Set up Laravel Telescope for debugging (dev only)
- [ ] Configure file storage (MinIO/S3)
- [ ] Set up mail configuration (SMTP/SES)
- [ ] Install and configure Spatie Laravel Permission
- [ ] Set up logging channels (daily, epsm, audit)
- [ ] Configure session management

**Dependencies**: SETUP-001

**Acceptance Criteria**:
- Sanctum tokens can be generated
- Horizon dashboard accessible
- Files can be uploaded to storage
- Emails can be sent (test mode)

---

### SETUP-006: Frontend Setup (Vue.js + Inertia)
**Priority**: Must Have
**Effort**: 4 days
**Assigned To**: Frontend Lead

**Tasks**:
- [ ] Install and configure Laravel Breeze with Inertia.js
- [ ] Set up Vue 3 with TypeScript (optional)
- [ ] Install Tailwind CSS
- [ ] Install PrimeVue or shadcn-vue for UI components
- [ ] Set up Vite build configuration
- [ ] Create base layout components:
  - [ ] AppLayout (with sidebar)
  - [ ] AuthLayout (login/register)
  - [ ] GuestLayout (public pages)
- [ ] Set up Vue Router (handled by Inertia)
- [ ] Configure i18n for Malay/English (vue-i18n)
- [ ] Set up form validation (Vuelidate or VeeValidate)

**Dependencies**: SETUP-001

**Acceptance Criteria**:
- Inertia.js renders Vue components
- Tailwind CSS styles apply
- UI component library works
- Hot module replacement works (`npm run dev`)

---

### SETUP-007: Testing Framework Setup
**Priority**: Should Have
**Effort**: 2 days
**Assigned To**: Backend Lead

**Tasks**:
- [ ] Configure PHPUnit for Laravel
- [ ] Set up database for testing (SQLite in-memory)
- [ ] Create base test classes (TestCase, DatabaseTestCase)
- [ ] Install and configure Laravel Dusk (browser testing)
- [ ] Set up test coverage reporting (PHPUnit coverage)
- [ ] Create sample test cases for reference
- [ ] Document testing guidelines

**Dependencies**: SETUP-003, SETUP-004

**Acceptance Criteria**:
- `php artisan test` runs successfully
- Coverage report generated
- Sample tests pass

---

## Phase 1: MVP (Core Features)

### Module 1: Authentication & User Management

#### AUTH-001: User Registration (Manual Entry)
**Priority**: Must Have
**Effort**: 5 days
**Assigned To**: Backend Dev 1 + Frontend Dev 1

**Tasks**:
- [ ] **Backend**:
  - [ ] Create `RegisterController` with validation
  - [ ] Implement user registration endpoint `POST /api/auth/register`
  - [ ] Validate No. KP format (RULE-USER-002: 12 digits)
  - [ ] Validate email domain (.gov.my) (RULE-USER-003)
  - [ ] Hash password with bcrypt (RULE-AUTH-002)
  - [ ] Auto-assign `peserta` role (RULE-USER-005)
  - [ ] Create audit log entry
  - [ ] Send verification email (optional for MVP)
- [ ] **Frontend**:
  - [ ] Create registration form component
  - [ ] Implement client-side validation
  - [ ] Show success/error messages
  - [ ] Redirect to login on success
- [ ] **Testing**:
  - [ ] Unit tests for validation rules
  - [ ] Integration test for full registration flow
  - [ ] Test duplicate No. KP handling

**Dependencies**: SETUP-003, SETUP-004, SETUP-005

**Reference**: RULES.md RULE-USER-001 to RULE-USER-006

**Acceptance Criteria**:
- User can register with valid No. KP and email
- Duplicate No. KP rejected
- Invalid email domain rejected
- User assigned `peserta` role automatically
- Audit log records registration

---

#### AUTH-002: EPSM API Integration
**Priority**: Must Have
**Effort**: 5 days
**Assigned To**: Backend Dev 2

**Tasks**:
- [ ] Create `EpsmApiService` class
- [ ] Implement `getStaffByNoKp()` method
- [ ] Add caching layer (60 minutes for found, 5 for not-found)
- [ ] Implement rate limiting (60 req/min)
- [ ] Create configuration in `config/services.php`
- [ ] Add EPSM credentials to `.env`
- [ ] Create `checkNoKp` endpoint for frontend
- [ ] Handle API timeouts and errors gracefully
- [ ] Store raw EPSM response in `users.epsm_raw_data`
- [ ] Create artisan command: `php artisan epsm:sync-user {no_kp}`
- [ ] Write comprehensive tests (mocked API responses)

**Dependencies**: AUTH-001

**Reference**: API_INTEGRATION.md section 3

**Acceptance Criteria**:
- API call returns staff data for valid No. KP
- Returns null for not-found No. KP
- Caching reduces duplicate API calls
- Graceful fallback on API timeout
- Tests cover success, not-found, and error cases

---

#### AUTH-003: User Registration with EPSM Auto-fill
**Priority**: Must Have
**Effort**: 4 days
**Assigned To**: Frontend Dev 1 + Backend Dev 1

**Tasks**:
- [ ] **Frontend**:
  - [ ] Create 2-step registration wizard
  - [ ] Step 1: Enter No. KP → Call `checkNoKp` API
  - [ ] Step 2: Show auto-filled form or manual form
  - [ ] Display EPSM found/not-found message
  - [ ] Allow editing of auto-filled fields
- [ ] **Backend**:
  - [ ] Update registration to accept `epsm_verified` flag
  - [ ] Map EPSM `kod_jabatan` to `jabatan_id`
  - [ ] Handle missing department codes gracefully
- [ ] **Testing**:
  - [ ] Test with EPSM found
  - [ ] Test with EPSM not found
  - [ ] Test with invalid department code

**Dependencies**: AUTH-001, AUTH-002

**Reference**: API_INTEGRATION.md section 2.1

**Acceptance Criteria**:
- User enters No. KP, system calls EPSM API
- If found: Form auto-fills name, email, dept, etc.
- If not found: User fills manually
- `epsm_verified` flag set correctly
- Department mapping works

---

#### AUTH-004: User Login
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: Backend Dev 1 + Frontend Dev 1

**Tasks**:
- [ ] **Backend**:
  - [ ] Create `LoginController`
  - [ ] Implement login endpoint `POST /api/auth/login`
  - [ ] Validate credentials (No. KP or Email + Password)
  - [ ] Generate Sanctum token
  - [ ] Return user data with roles/permissions
  - [ ] Create audit log entry (successful/failed login)
  - [ ] Implement rate limiting (5 attempts per minute)
- [ ] **Frontend**:
  - [ ] Create login form
  - [ ] Store token in localStorage/cookie
  - [ ] Redirect to dashboard on success
  - [ ] Show error for invalid credentials
- [ ] **Testing**:
  - [ ] Test valid login
  - [ ] Test invalid credentials
  - [ ] Test rate limiting

**Dependencies**: AUTH-001

**Reference**: RULES.md RULE-AUTH-004, RULE-AUTH-005

**Acceptance Criteria**:
- User can login with No. KP and password
- Invalid credentials rejected
- Token returned and stored
- Rate limiting prevents brute force
- Audit log records login attempts

---

#### AUTH-005: User Profile Management
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: Backend Dev 2 + Frontend Dev 2

**Tasks**:
- [ ] **Backend**:
  - [ ] Create `ProfileController`
  - [ ] Implement `GET /api/profile` (view own profile)
  - [ ] Implement `PUT /api/profile` (update own profile)
  - [ ] Restrict No. KP and Jabatan updates (RULE-USER-007)
  - [ ] Implement profile sync with EPSM endpoint
  - [ ] Validate editable fields
- [ ] **Frontend**:
  - [ ] Create profile view page
  - [ ] Create profile edit form
  - [ ] Add "Sync with EPSM" button
  - [ ] Show comparison table (current vs EPSM data)
- [ ] **Testing**:
  - [ ] Test profile update
  - [ ] Test restricted field rejection
  - [ ] Test EPSM sync

**Dependencies**: AUTH-002, AUTH-004

**Reference**: RULES.md RULE-USER-007, RULE-USER-008

**Acceptance Criteria**:
- User can view and edit their profile
- No. KP and Jabatan cannot be self-updated
- EPSM sync shows comparison and updates data
- Audit log records profile changes

---

### Module 2: Department Management

#### DEPT-001: Department CRUD
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: Backend Dev 1 + Frontend Dev 1

**Tasks**:
- [ ] **Backend**:
  - [ ] Create `JabatanController`
  - [ ] Implement CRUD endpoints
  - [ ] Restrict to Admin Jabatan and above
  - [ ] Support hierarchical departments (`ptj_induk`)
- [ ] **Frontend**:
  - [ ] Create department list page
  - [ ] Create department form (create/edit)
  - [ ] Support logo upload
- [ ] **Testing**:
  - [ ] Test CRUD operations
  - [ ] Test permissions

**Dependencies**: SETUP-003, AUTH-004

**Acceptance Criteria**:
- Admin can create, view, update, delete departments
- Regular users can only view departments
- Logo upload works

---

### Module 3: Event Management (Single-Day Events)

#### EVENT-001: Event Creation (Single-Day, Physical)
**Priority**: Must Have
**Effort**: 6 days
**Assigned To**: Backend Dev 1 + Frontend Dev 1

**Tasks**:
- [ ] **Backend**:
  - [ ] Create `AcaraController`
  - [ ] Implement `POST /api/events` endpoint
  - [ ] Generate event reference number (RULE-EVENT-001)
  - [ ] Validate date range (RULE-EVENT-002)
  - [ ] Require geolocation for physical events (RULE-EVENT-008)
  - [ ] Set creator as owner in `pemilikan_resource`
  - [ ] Default `adalah_berbilang_hari = false`
  - [ ] Create audit log entry
- [ ] **Frontend**:
  - [ ] Create event creation form
  - [ ] Add map picker for location (Google Maps / Leaflet)
  - [ ] Validate required fields
  - [ ] Show success message with event reference
- [ ] **Testing**:
  - [ ] Test event creation
  - [ ] Test validation rules
  - [ ] Test reference number generation
  - [ ] Test ownership assignment

**Dependencies**: DEPT-001, AUTH-004

**Reference**: RULES.md RULE-EVENT-001 to RULE-EVENT-010

**Acceptance Criteria**:
- Penyelaras can create single-day physical event
- Reference number auto-generated (KEDAH-2026-LATIH-0001)
- Geolocation coordinates required and saved
- Event belongs to creator's department
- Creator gets resource-level ownership

---

#### EVENT-002: Event Listing & Filtering
**Priority**: Must Have
**Effort**: 4 days
**Assigned To**: Backend Dev 2 + Frontend Dev 2

**Tasks**:
- [ ] **Backend**:
  - [ ] Implement `GET /api/events` with filters
  - [ ] Filter by: department, status, category, date range
  - [ ] Paginate results (25 per page)
  - [ ] Apply department scope (RULE-EVENT-004)
  - [ ] Include participant count
- [ ] **Frontend**:
  - [ ] Create event list page with table
  - [ ] Add filter dropdowns and date pickers
  - [ ] Add pagination controls
  - [ ] Show event status badges
  - [ ] Add "Create Event" button (if allowed)
- [ ] **Testing**:
  - [ ] Test filtering
  - [ ] Test pagination
  - [ ] Test department scope

**Dependencies**: EVENT-001

**Acceptance Criteria**:
- User sees events from their department (or all if admin)
- Filters work correctly
- Pagination works
- Performance acceptable for 1000+ events

---

#### EVENT-003: Participant Management (Invite & List)
**Priority**: Must Have
**Effort**: 5 days
**Assigned To**: Backend Dev 1 + Frontend Dev 1

**Tasks**:
- [ ] **Backend**:
  - [ ] Create `PesertaAcaraController`
  - [ ] Implement `POST /api/events/{id}/participants` (add participants)
  - [ ] Support adding by: individual (No. KP), department, grade
  - [ ] Check quota limit (RULE-EVENT-006)
  - [ ] Set `status_jemputan = 'dijemput'`
  - [ ] Generate unique token for online events (future use)
  - [ ] Implement `GET /api/events/{id}/participants` (list)
  - [ ] Implement `DELETE /api/events/{id}/participants/{userId}` (remove)
- [ ] **Frontend**:
  - [ ] Create participant management page
  - [ ] Add participant search (by name, No. KP, dept)
  - [ ] Show participant list with status
  - [ ] Add/remove participant actions
  - [ ] Show quota indicator (X/Y participants)
- [ ] **Testing**:
  - [ ] Test adding participants
  - [ ] Test quota enforcement
  - [ ] Test removing participants

**Dependencies**: EVENT-001

**Reference**: RULES.md RULE-EVENT-006, RULE-EVENT-007

**Acceptance Criteria**:
- Organizer can add participants individually or by department
- Quota enforced (cannot exceed limit)
- Participant list displays correctly
- Can remove participants before event starts

---

#### EVENT-004: Send Event Invitations
**Priority**: Must Have
**Effort**: 4 days
**Assigned To**: Backend Dev 2

**Tasks**:
- [ ] Create `NotificationService`
- [ ] Create email template for event invitation (Blade + Malay)
- [ ] Implement queue job `SendEventInvitationJob`
- [ ] Include event details, QR code, calendar file (.ics)
- [ ] Implement `POST /api/events/{id}/send-invitations` endpoint
- [ ] Send within 5 minutes (RULE-NOTIF-001)
- [ ] Create audit log entry
- [ ] Handle email failures gracefully

**Dependencies**: EVENT-003, SETUP-005

**Reference**: RULES.md RULE-NOTIF-001

**Acceptance Criteria**:
- Invitations sent to all `dijemput` participants
- Email contains event details and QR code
- Sent within 5 minutes via queue
- Failed emails logged for retry

---

### Module 4: QR Code Generation & Scanning

#### QR-001: Static QR Code Generation
**Priority**: Must Have
**Effort**: 4 days
**Assigned To**: Backend Dev 1

**Tasks**:
- [ ] Install QR code library (`simplesoftwareio/simple-qrcode`)
- [ ] Install JWT library (`tymon/jwt-auth` or use Laravel Sanctum)
- [ ] Create `QrCodeService`
- [ ] Implement `generateEventQrToken()` method
- [ ] Generate JWT with payload (RULE-QR-001)
- [ ] Set expiry based on event end time + 2 hours (RULE-QR-002)
- [ ] Generate QR code image (PNG/SVG)
- [ ] Store QR token in `acara.qr_token`
- [ ] Create endpoint `GET /api/events/{id}/qr-code` (returns image)
- [ ] Create endpoint `GET /qr/{token}` (QR landing page)

**Dependencies**: EVENT-001

**Reference**: RULES.md RULE-QR-001 to RULE-QR-007

**Acceptance Criteria**:
- QR code generated for event
- QR contains JWT token
- Scanning QR redirects to attendance check-in page
- Token can be verified

---

#### QR-002: QR Code Display for Organizer
**Priority**: Must Have
**Effort**: 2 days
**Assigned To**: Frontend Dev 1

**Tasks**:
- [ ] Create event detail page
- [ ] Display QR code prominently
- [ ] Add download QR button (PNG, SVG, PDF)
- [ ] Show QR validity period
- [ ] Add "Print QR" button (for physical display)
- [ ] Show event details alongside QR

**Dependencies**: QR-001

**Acceptance Criteria**:
- Organizer can view QR code on event detail page
- QR downloadable in multiple formats
- Print-friendly layout

---

#### QR-003: QR Scanning & Attendance Check-In (Physical Event)
**Priority**: Must Have
**Effort**: 6 days
**Assigned To**: Backend Dev 2 + Frontend Dev 2

**Tasks**:
- [ ] **Backend**:
  - [ ] Create `AttendanceController`
  - [ ] Implement `POST /api/attendance/check-in` endpoint
  - [ ] Verify JWT token validity
  - [ ] Extract event_id from token
  - [ ] Check if user is invited (RULE-ATTEND-001)
  - [ ] Verify QR scan window (RULE-QR-005)
  - [ ] Verify geolocation radius (RULE-GEO-002)
  - [ ] Prevent duplicate check-in (RULE-QR-007)
  - [ ] Record in `kehadiran_sesi` (for single-day, link to implicit session)
  - [ ] Record device info, IP, GPS coordinates
  - [ ] Create audit log
  - [ ] Return success/error message
- [ ] **Frontend**:
  - [ ] Create QR scan page `GET /scan/{token}`
  - [ ] Request geolocation permission
  - [ ] Display event details
  - [ ] Show "Check In" button
  - [ ] Call check-in API with GPS coordinates
  - [ ] Show success/error message
  - [ ] Handle edge cases (not invited, outside radius, etc.)
- [ ] **Testing**:
  - [ ] Test valid check-in
  - [ ] Test duplicate prevention
  - [ ] Test geolocation validation
  - [ ] Test expired QR

**Dependencies**: QR-001, EVENT-003

**Reference**: RULES.md RULE-ATTEND-001 to RULE-ATTEND-004, RULE-GEO-001 to RULE-GEO-004

**Acceptance Criteria**:
- User can scan QR code and check-in
- Geolocation verified within radius
- Duplicate check-in prevented
- Attendance recorded with timestamp and GPS
- Clear error messages for invalid scans

---

#### QR-004: Mobile Browser QR Scanner (Camera)
**Priority**: Should Have
**Effort**: 3 days
**Assigned To**: Frontend Dev 2

**Tasks**:
- [ ] Install QR scanner library (e.g., `html5-qrcode`)
- [ ] Create camera-based QR scanner component
- [ ] Request camera permission
- [ ] Detect QR code from camera stream
- [ ] Extract URL and redirect to check-in page
- [ ] Handle errors (no camera, permission denied)
- [ ] Add manual token entry fallback

**Dependencies**: QR-003

**Acceptance Criteria**:
- User can open camera and scan QR code
- Detected QR redirects to check-in page
- Works on iOS Safari and Android Chrome
- Fallback to manual entry available

---

### Module 5: Attendance Reporting (Basic)

#### REPORT-001: Event Attendance List
**Priority**: Must Have
**Effort**: 4 days
**Assigned To**: Backend Dev 1 + Frontend Dev 1

**Tasks**:
- [ ] **Backend**:
  - [ ] Implement `GET /api/events/{id}/attendance-report`
  - [ ] Return list of all participants with:
    - Name, No. KP, Department, Position
    - Invitation status
    - Check-in time (if attended)
    - Check-in location (GPS coordinates)
  - [ ] Calculate attendance rate: (attended / invited) × 100
  - [ ] Apply RBAC (organizer, admin only)
- [ ] **Frontend**:
  - [ ] Create attendance report page
  - [ ] Show summary stats (invited, attended, absent, rate)
  - [ ] Display participant table
  - [ ] Add export to Excel button (phase 2)
  - [ ] Add export to PDF button (phase 2)
- [ ] **Testing**:
  - [ ] Test report generation
  - [ ] Test permissions

**Dependencies**: QR-003

**Reference**: PRD section 9.5 (FR-5.1 to FR-5.4)

**Acceptance Criteria**:
- Organizer can view real-time attendance list
- Summary statistics displayed
- Attendance rate calculated correctly
- Only authorized users can access

---

#### REPORT-002: Real-Time Attendance Dashboard
**Priority**: Should Have
**Effort**: 5 days
**Assigned To**: Backend Dev 2 + Frontend Dev 2

**Tasks**:
- [ ] **Backend**:
  - [ ] Set up Laravel Reverb (WebSocket server)
  - [ ] Create attendance event broadcasting
  - [ ] Broadcast on each check-in: `AttendanceRecorded` event
  - [ ] Create endpoint for dashboard stats
- [ ] **Frontend**:
  - [ ] Create dashboard page with live stats
  - [ ] Listen to WebSocket events (Laravel Echo)
  - [ ] Update stats in real-time (no page refresh)
  - [ ] Show animated counters
  - [ ] Display charts (attendance over time)
- [ ] **Testing**:
  - [ ] Test WebSocket connection
  - [ ] Test real-time updates

**Dependencies**: QR-003, SETUP-005

**Reference**: RULES.md RULE-EVENT-012

**Acceptance Criteria**:
- Dashboard shows live attendance count
- Updates without page refresh when someone checks in
- Visible to organizer during event

---

### Module 6: Certificate Generation (Basic)

#### CERT-001: Certificate Template Design
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: Frontend Dev 1 + Designer

**Tasks**:
- [ ] Design certificate template (Bahasa Malaysia)
- [ ] Include: Event name, participant name, date, hours
- [ ] Add department logo placeholder
- [ ] Add verification QR code area
- [ ] Create Blade template for PDF generation
- [ ] Support A4 landscape orientation
- [ ] Test print quality

**Dependencies**: None

**Acceptance Criteria**:
- Template looks professional
- All required fields included
- Print-ready PDF quality

---

#### CERT-002: Certificate PDF Generation
**Priority**: Must Have
**Effort**: 5 days
**Assigned To**: Backend Dev 1

**Tasks**:
- [ ] Install PDF library (`barryvdh/laravel-dompdf` or `spatie/browsershot`)
- [ ] Create `CertificateService`
- [ ] Implement `generateCertificate()` method
- [ ] Generate verification code (12-char alphanumeric)
- [ ] Generate verification QR code
- [ ] Populate template with event + participant data
- [ ] Generate PDF and save to storage (MinIO/S3)
- [ ] Save record in `sijil` table
- [ ] Create endpoint `GET /api/certificates/{id}/download`
- [ ] Create queue job `GenerateCertificateJob`

**Dependencies**: CERT-001, SETUP-005

**Reference**: RULES.md RULE-CERT-001 to RULE-CERT-012

**Acceptance Criteria**:
- Certificate PDF generated with correct data
- Verification QR code included
- PDF saved to storage
- User can download their certificate

---

#### CERT-003: Auto-Generate Certificates on Event Complete
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: Backend Dev 2

**Tasks**:
- [ ] Create event observer `AcaraObserver`
- [ ] Detect when `status` changes to `selesai`
- [ ] Dispatch `GenerateEventCertificatesJob`
- [ ] Job iterates all participants who attended
- [ ] Generate certificate for each (single-day = 100% if attended)
- [ ] Send email with certificate download link
- [ ] Create audit log entries

**Dependencies**: CERT-002, REPORT-001

**Reference**: RULES.md RULE-CERT-001

**Acceptance Criteria**:
- Certificates auto-generated when event marked complete
- All attendees receive certificates
- Email sent with download link
- Non-attendees don't receive certificates

---

#### CERT-004: Certificate Verification Page
**Priority**: Must Have
**Effort**: 2 days
**Assigned To**: Backend Dev 1 + Frontend Dev 1

**Tasks**:
- [ ] Create `GET /verify/{kod_pengesahan}` route
- [ ] Look up certificate by verification code
- [ ] Return certificate details (public view)
- [ ] **Frontend**: Display verification page showing:
  - Participant name, event name, date
  - "AUTHENTIC" or "INVALID" badge
  - Option to download PDF (if authentic)

**Dependencies**: CERT-002

**Acceptance Criteria**:
- Public can verify certificate with QR code
- Shows authentic/invalid status
- No authentication required

---

### Module 7: RBAC Implementation

#### RBAC-001: Permission Middleware
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: Backend Lead

**Tasks**:
- [ ] Create `PermissionMiddleware`
- [ ] Check user permissions via Spatie Permission
- [ ] Apply department scope filtering
- [ ] Create helper methods: `can()`, `hasRole()`
- [ ] Document permission naming convention
- [ ] Apply middleware to all protected routes
- [ ] Test with different roles

**Dependencies**: SETUP-005, AUTH-004

**Reference**: RULES.md RULE-RBAC-001 to RULE-RBAC-013

**Acceptance Criteria**:
- Routes protected by permissions
- Department scope applied automatically
- Super admin bypasses all checks
- Tests cover all roles

---

#### RBAC-002: Role Management UI (Admin)
**Priority**: Should Have
**Effort**: 4 days
**Assigned To**: Backend Dev 1 + Frontend Dev 1

**Tasks**:
- [ ] **Backend**:
  - [ ] Create `RoleController`
  - [ ] Implement role CRUD endpoints
  - [ ] Restrict to Super Admin
  - [ ] Prevent deletion of default roles
- [ ] **Frontend**:
  - [ ] Create role management page
  - [ ] List all roles with hierarchy
  - [ ] Create/edit custom roles
  - [ ] Assign permissions to roles (checkboxes)
- [ ] **Testing**:
  - [ ] Test role creation
  - [ ] Test permission assignment

**Dependencies**: RBAC-001

**Acceptance Criteria**:
- Super Admin can create custom roles
- Default roles cannot be deleted
- Permissions can be assigned/revoked

---

#### RBAC-003: User Role Assignment UI
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: Backend Dev 2 + Frontend Dev 2

**Tasks**:
- [ ] **Backend**:
  - [ ] Create `UserRoleController`
  - [ ] Implement assign/revoke role endpoints
  - [ ] Support department scope selection
  - [ ] Support start/end dates
  - [ ] Check assignment authority (RULE-RBAC-004)
- [ ] **Frontend**:
  - [ ] Add role management to user detail page
  - [ ] Show current roles with scope and expiry
  - [ ] Add "Assign Role" button
  - [ ] Modal with role dropdown, department, dates
- [ ] **Testing**:
  - [ ] Test role assignment
  - [ ] Test scope restrictions
  - [ ] Test expiry

**Dependencies**: RBAC-001, AUTH-005

**Reference**: RULES.md RULE-RBAC-004 to RULE-RBAC-010

**Acceptance Criteria**:
- Admin Jabatan can assign roles to department users
- Role scope and expiry configurable
- Expired roles auto-revoked

---

### Module 8: Audit Logging

#### AUDIT-001: Audit Logging Service
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: Backend Dev 1

**Tasks**:
- [ ] Install Spatie Activity Log or create custom service
- [ ] Create `AuditLogService`
- [ ] Define events to log (RULE-AUDIT-001)
- [ ] Create Eloquent observers for auto-logging
- [ ] Store IP address, user agent, timestamp
- [ ] Store before/after values in `butiran_json`
- [ ] Create endpoint `GET /api/audit-logs` (Admin only)

**Dependencies**: SETUP-003

**Reference**: RULES.md RULE-AUDIT-001 to RULE-AUDIT-005

**Acceptance Criteria**:
- All critical actions logged
- Logs include user, action, object, details, IP, timestamp
- Logs queryable by Admin and Auditor

---

#### AUDIT-002: Audit Log Viewer UI
**Priority**: Should Have
**Effort**: 3 days
**Assigned To**: Frontend Dev 1

**Tasks**:
- [ ] Create audit log list page
- [ ] Add filters: user, action, date range, object type
- [ ] Display in chronological order (newest first)
- [ ] Show expandable details (JSON diff)
- [ ] Pagination
- [ ] Export to CSV (for compliance)

**Dependencies**: AUDIT-001

**Acceptance Criteria**:
- Admin/Auditor can view all audit logs
- Filters work correctly
- Details show before/after values

---

### Module 9: Testing & QA

#### TEST-001: Write Unit Tests (Phase 1 Features)
**Priority**: Must Have
**Effort**: 10 days
**Assigned To**: All Developers

**Tasks**:
- [ ] Write tests for all validation rules (RULES.md)
- [ ] Write tests for authentication flows
- [ ] Write tests for event creation/management
- [ ] Write tests for QR code generation/validation
- [ ] Write tests for attendance check-in
- [ ] Write tests for certificate generation
- [ ] Write tests for RBAC permissions
- [ ] Achieve minimum 70% code coverage

**Dependencies**: All Phase 1 modules

**Acceptance Criteria**:
- All critical paths tested
- Tests pass consistently
- 70% code coverage

---

#### TEST-002: Integration Testing
**Priority**: Should Have
**Effort**: 5 days
**Assigned To**: QA Engineer

**Tasks**:
- [ ] Test end-to-end user registration flow
- [ ] Test end-to-end event creation to attendance flow
- [ ] Test end-to-end certificate generation flow
- [ ] Test with different user roles
- [ ] Test edge cases and error handling

**Dependencies**: TEST-001

**Acceptance Criteria**:
- All critical user journeys tested
- No major bugs in happy paths

---

#### TEST-003: User Acceptance Testing (UAT) with Pilot Department
**Priority**: Must Have
**Effort**: 10 days (including fixes)
**Assigned To**: Project Manager + 1 Pilot Department

**Tasks**:
- [ ] Select 1 pilot department
- [ ] Conduct training session (2 hours)
- [ ] Run 1 real course with 50 participants
- [ ] Collect feedback
- [ ] Document issues and feature requests
- [ ] Fix critical bugs
- [ ] Iterate based on feedback

**Dependencies**: All Phase 1 modules, TEST-002

**Acceptance Criteria**:
- Pilot department successfully conducts 1 course
- Feedback collected and documented
- Critical bugs fixed

---

## Phase 2: Advanced Features

### Module 10: Multi-Day Events & Sessions

#### SESSION-001: Session Management (Multi-Day Events)
**Priority**: Must Have
**Effort**: 6 days
**Assigned To**: Backend Dev 1 + Frontend Dev 1

**Tasks**:
- [ ] **Backend**:
  - [ ] Create `SesiController`
  - [ ] Implement session CRUD endpoints
  - [ ] Validate session dates within event period (RULE-SESI-004)
  - [ ] Calculate training hours (RULE-SESI-005)
  - [ ] Support mandatory/optional flag
  - [ ] Generate per-session QR codes
- [ ] **Frontend**:
  - [ ] Create session management page (within event)
  - [ ] List all sessions with edit/delete
  - [ ] Add "Create Session" form
  - [ ] Auto-calculate hours from time range
  - [ ] Toggle mandatory/optional
- [ ] **Testing**:
  - [ ] Test session CRUD
  - [ ] Test validation rules
  - [ ] Test training hours calculation

**Dependencies**: EVENT-001

**Reference**: RULES.md RULE-SESI-001 to RULE-SESI-008, ERD.md table `sesi`

**Acceptance Criteria**:
- Organizer can add multiple sessions to event
- Sessions validated against event dates
- Training hours auto-calculated
- Each session has unique QR code

---

#### SESSION-002: Auto-Generate Sessions (Wizard)
**Priority**: Should Have
**Effort**: 4 days
**Assigned To**: Backend Dev 2 + Frontend Dev 1

**Tasks**:
- [ ] **Backend**:
  - [ ] Create `POST /api/events/{id}/sessions/auto-generate` endpoint
  - [ ] Accept: start date, end date, daily pattern (time ranges)
  - [ ] Generate sessions automatically
  - [ ] Return generated sessions for preview
- [ ] **Frontend**:
  - [ ] Create "Auto-Generate Sessions" wizard
  - [ ] Input: date range, session times per day
  - [ ] Preview generated sessions
  - [ ] Confirm and save

**Dependencies**: SESSION-001

**Reference**: PRD section 8.8 (Auto-Jana Sesi)

**Acceptance Criteria**:
- Organizer can auto-generate 5-day course sessions in < 1 minute
- Preview before saving
- Can edit generated sessions

---

#### SESSION-003: Per-Session Attendance Check-In
**Priority**: Must Have
**Effort**: 5 days
**Assigned To**: Backend Dev 2 + Frontend Dev 2

**Tasks**:
- [ ] **Backend**:
  - [ ] Update `AttendanceController` to handle session QR
  - [ ] Verify session-specific QR token
  - [ ] Check session scan validity window (RULE-QR-006)
  - [ ] Record in `kehadiran_sesi` with `sesi_id`
  - [ ] Prevent duplicate per session (RULE-QR-007)
- [ ] **Frontend**:
  - [ ] Update QR scan page to show session info
  - [ ] Display session name, time, location
- [ ] **Testing**:
  - [ ] Test session-specific check-in
  - [ ] Test scan window validation

**Dependencies**: SESSION-001, QR-003

**Reference**: RULES.md RULE-QR-006, RULE-QR-007

**Acceptance Criteria**:
- Each session has unique QR code
- Participant can check-in to specific session only
- Duplicate check-in per session prevented

---

#### SESSION-004: Multi-Day Attendance Calculation
**Priority**: Must Have
**Effort**: 5 days
**Assigned To**: Backend Dev 1

**Tasks**:
- [ ] Create attendance calculation service
- [ ] Implement formula (RULE-CALC-002):
  - Count mandatory sessions attended
  - Calculate percentage: (attended ÷ total mandatory) × 100
  - Exclude optional sessions from percentage
  - Add optional session hours to total hours
- [ ] Determine certificate eligibility (RULE-CALC-004)
- [ ] Create/update `kehadiran` record after each session
- [ ] Trigger final calculation on event completion
- [ ] Create endpoint `POST /api/events/{id}/calculate-attendance`

**Dependencies**: SESSION-003

**Reference**: RULES.md RULE-CALC-002 to RULE-CALC-005

**Acceptance Criteria**:
- Attendance percentage calculated correctly
- Optional sessions excluded from percentage
- Certificate eligibility determined (Full/Partial/None)
- Final calculation triggered on event end

---

#### SESSION-005: Multi-Day Certificate Generation
**Priority**: Must Have
**Effort**: 4 days
**Assigned To**: Backend Dev 2

**Tasks**:
- [ ] Update `CertificateService` for multi-day events
- [ ] Support three certificate types (RULE-CERT-002):
  - Full: Show total hours
  - Partial: List attended sessions in JSON
  - Substitute: Indicate substitute status
- [ ] Update certificate template to display session list
- [ ] Generate based on `status_kelayakan_sijil`
- [ ] Test with various attendance scenarios

**Dependencies**: SESSION-004, CERT-002

**Reference**: RULES.md RULE-CERT-002, RULE-CERT-006

**Acceptance Criteria**:
- Full certificate for ≥80% attendance
- Partial certificate lists attended sessions (50-79%)
- No certificate for <50% attendance
- Certificate shows correct training hours

---

### Module 11: Dynamic QR Codes

#### DQR-001: Dynamic QR Code Generation (30s Rotation)
**Priority**: Should Have
**Effort**: 5 days
**Assigned To**: Backend Dev 2

**Tasks**:
- [ ] Update `QrCodeService` to support dynamic mode
- [ ] Generate short-lived JWT (30s expiry) (RULE-QR-003)
- [ ] Create endpoint `GET /api/events/{id}/qr-code/dynamic` (SSE/polling)
- [ ] Implement token rotation every 30 seconds
- [ ] Store current token in Redis (cache)
- [ ] Return new QR image every 30s

**Dependencies**: QR-001

**Reference**: RULES.md RULE-QR-003

**Acceptance Criteria**:
- QR code regenerates every 30 seconds
- Old tokens expire and become invalid
- Prevents screenshot sharing

---

#### DQR-002: Dynamic QR Code Display (Auto-Refresh)
**Priority**: Should Have
**Effort**: 3 days
**Assigned To**: Frontend Dev 2

**Tasks**:
- [ ] Update event detail page for dynamic QR
- [ ] Poll backend every 30s for new QR image
- [ ] Auto-refresh QR display without page reload
- [ ] Show countdown timer (30s)
- [ ] Indicate "QR Rotating..." status

**Dependencies**: DQR-001

**Acceptance Criteria**:
- QR image updates automatically every 30s
- Visual indicator shows rotation
- No page refresh required

---

### Module 12: Online & Hybrid Events

#### ONLINE-001: Online Event Creation
**Priority**: Should Have
**Effort**: 3 days
**Assigned To**: Backend Dev 1 + Frontend Dev 1

**Tasks**:
- [ ] Update event form to support `jenis_acara = 'dalam_talian'`
- [ ] Require `pautan_meeting_url` for online events (RULE-EVENT-010)
- [ ] Validate meeting URL (Zoom, Teams, Google Meet)
- [ ] Disable geolocation requirement (RULE-EVENT-009)
- [ ] **Frontend**: Add meeting URL field conditionally

**Dependencies**: EVENT-001

**Reference**: RULES.md RULE-EVENT-009, RULE-EVENT-010

**Acceptance Criteria**:
- Organizer can create online event
- Meeting URL required and validated
- Geolocation not required

---

#### ONLINE-002: Unique Attendance Links for Online Events
**Priority**: Should Have
**Effort**: 4 days
**Assigned To**: Backend Dev 2

**Tasks**:
- [ ] Generate unique token for each participant
- [ ] Store in `peserta_acara.token_pautan_unik`
- [ ] Set expiry: 30min before to 60min after event (RULE-VALID-008)
- [ ] Create endpoint `GET /attend/{token}` (one-click attendance)
- [ ] Verify token, check expiry, check No. KP match
- [ ] Record attendance on link click
- [ ] Prevent token sharing (tie to session)

**Dependencies**: ONLINE-001, EVENT-003

**Reference**: RULES.md section 6 (Attendance), PRD section 8.6

**Acceptance Criteria**:
- Each participant gets unique attendance link
- Link expires based on event time
- Token cannot be shared (session-locked)
- Attendance recorded on click

---

#### ONLINE-003: Continuous Verification for Long Online Sessions
**Priority**: Could Have
**Effort**: 6 days
**Assigned To**: Backend Dev 1 + Frontend Dev 2

**Tasks**:
- [ ] **Backend**:
  - [ ] Create continuous verification service
  - [ ] Schedule 2-3 random prompts based on session duration (RULE-CALC-008)
  - [ ] Create endpoint `POST /api/sessions/{id}/verify` (participant responds)
  - [ ] Record prompts in `pengesahan_berterusan` table
  - [ ] Calculate verification percentage (RULE-CALC-006)
  - [ ] Update `kehadiran_sesi.peratus_pengesahan`
- [ ] **Frontend**:
  - [ ] Display verification prompt (modal/notification)
  - [ ] Show countdown (3 minutes to respond)
  - [ ] Call verify endpoint on button click
- [ ] **Testing**:
  - [ ] Test prompt scheduling
  - [ ] Test response recording
  - [ ] Test percentage calculation

**Dependencies**: ONLINE-002, SESSION-003

**Reference**: RULES.md RULE-CALC-006 to RULE-CALC-009

**Acceptance Criteria**:
- 2-3 prompts scheduled randomly during session
- Participant sees prompt and can respond
- Partial attendance calculated if < 75% prompts answered
- Training hours prorated based on verification percentage

---

#### HYBRID-001: Hybrid Event Support
**Priority**: Should Have
**Effort**: 4 days
**Assigned To**: Backend Dev 2 + Frontend Dev 1

**Tasks**:
- [ ] Update event creation to support `jenis_acara = 'hibrid'`
- [ ] Require both geolocation AND meeting URL (RULE-EVENT-010)
- [ ] Add `kategori_kehadiran` to participant invitation (fizikal/dalam_talian)
- [ ] Update check-in logic:
  - If kategori = 'fizikal': Apply geolocation check
  - If kategori = 'dalam_talian': Skip geolocation, use unique link
- [ ] Update reporting to show breakdown (RULE-GEO-006)

**Dependencies**: ONLINE-001, ONLINE-002

**Reference**: RULES.md RULE-EVENT-010, RULE-GEO-006

**Acceptance Criteria**:
- Organizer can create hybrid event
- Physical participants verified with geolocation
- Online participants use unique links
- Report shows breakdown of physical vs online attendance

---

### Module 13: Participant Substitution

#### SUB-001: Pre-Event Substitution Request
**Priority**: Must Have
**Effort**: 5 days
**Assigned To**: Backend Dev 1 + Frontend Dev 1

**Tasks**:
- [ ] **Backend**:
  - [ ] Create `GantianController`
  - [ ] Implement `POST /api/events/{id}/substitutions` (request)
  - [ ] Validate: same department (RULE-SUB-002)
  - [ ] Validate: substitute not already invited (RULE-SUB-003)
  - [ ] Validate: request before event starts (RULE-SUB-001)
  - [ ] Create `gantian` record with status `menunggu`
  - [ ] Send notification to organizer
- [ ] **Frontend**:
  - [ ] Add "Request Substitution" button on event detail
  - [ ] Form: select substitute, enter reason
  - [ ] Show substitute search (same department)
  - [ ] Display substitution status
- [ ] **Testing**:
  - [ ] Test request creation
  - [ ] Test validation rules

**Dependencies**: EVENT-003

**Reference**: RULES.md RULE-SUB-001 to RULE-SUB-006, ERD.md table `gantian`

**Acceptance Criteria**:
- Participant can request substitution before event
- Same department enforced
- Organizer notified
- Status shows "Pending"

---

#### SUB-002: Substitution Approval/Rejection (Organizer)
**Priority**: Must Have
**Effort**: 4 days
**Assigned To**: Backend Dev 2 + Frontend Dev 2

**Tasks**:
- [ ] **Backend**:
  - [ ] Implement `PUT /api/substitutions/{id}/approve`
  - [ ] Implement `PUT /api/substitutions/{id}/reject`
  - [ ] On approval:
    - Update original participant status to `gantian`
    - Add substitute to `peserta_acara` with status `sah`
    - Update `gantian.status = 'diluluskan'`
    - Send notification to both participants
  - [ ] On rejection:
    - Update `gantian.status = 'ditolak'`
    - Send notification to original participant
- [ ] **Frontend**:
  - [ ] Create substitution request list (for organizer)
  - [ ] Show pending requests with approve/reject buttons
  - [ ] Add optional comment field
- [ ] **Testing**:
  - [ ] Test approval flow
  - [ ] Test rejection flow

**Dependencies**: SUB-001

**Reference**: RULES.md RULE-SUB-004, RULE-SUB-005

**Acceptance Criteria**:
- Organizer can approve/reject substitution
- On approval: Substitute added, original removed
- Notifications sent to both parties
- Audit log records decision

---

#### SUB-003: Walk-In Substitution (On-Site)
**Priority**: Should Have
**Effort**: 5 days
**Assigned To**: Backend Dev 1 + Frontend Dev 2

**Tasks**:
- [ ] **Backend**:
  - [ ] Update QR scan logic to detect non-invited users
  - [ ] Show substitution request form
  - [ ] Create walk-in substitution with `jenis_gantian = 'walk_in'`
  - [ ] Send urgent notification (push/SMS) to organizer (RULE-SUB-008)
  - [ ] For open mode: Auto-approve (RULE-SUB-009)
- [ ] **Frontend**:
  - [ ] Show "You're not invited" message on QR scan
  - [ ] Display substitution request form
  - [ ] Select original participant from dropdown
  - [ ] Enter reason (dropdown: sick leave, other meeting, etc.)
  - [ ] Submit and show "Waiting for approval" status
- [ ] **Testing**:
  - [ ] Test walk-in request
  - [ ] Test 5-minute approval SLA

**Dependencies**: QR-003, SUB-002

**Reference**: RULES.md RULE-SUB-007 to RULE-SUB-009, PRD section 8.5

**Acceptance Criteria**:
- Non-invited user can request walk-in substitution
- Organizer receives urgent notification (5min SLA)
- Open mode auto-approves same department
- Substitute waits for approval before check-in completes

---

#### SUB-004: Per-Session Substitution (Multi-Day)
**Priority**: Should Have
**Effort**: 4 days
**Assigned To**: Backend Dev 2

**Tasks**:
- [ ] Update substitution request to support `sesi_id`
- [ ] Allow selection of specific sessions
- [ ] Update check-in logic for session mutual exclusivity (RULE-SUB-012)
  - If substitute approved for session X:
    - Substitute can scan session X QR
    - Original participant CANNOT scan session X QR
- [ ] Calculate separate attendance for original and substitute
- [ ] Generate separate certificates (RULE-SUB-015)

**Dependencies**: SESSION-001, SUB-002

**Reference**: RULES.md RULE-SUB-010 to RULE-SUB-015, PRD section 8.9

**Acceptance Criteria**:
- Participant can request substitution for specific sessions (e.g., Day 2 and 4)
- Session mutual exclusivity enforced
- Both get separate attendance records and certificates

---

#### SUB-005: Chain Substitution Prevention
**Priority**: Must Have
**Effort**: 2 days
**Assigned To**: Backend Dev 1

**Tasks**:
- [ ] Add validation in substitution request
- [ ] Check if substitute is already a `wakil_id` in `gantian` table for this event
- [ ] Reject with error: "Wakil gantian tidak boleh digantikan" (RULE-SUB-013)
- [ ] Write test cases

**Dependencies**: SUB-001

**Reference**: RULES.md RULE-SUB-013

**Acceptance Criteria**:
- Substitute cannot be substituted again (no A→B→C)
- Clear error message shown

---

### Module 14: Training Hours Tracking

#### HOURS-001: Training Hours Accumulation Service
**Priority**: Must Have
**Effort**: 4 days
**Assigned To**: Backend Dev 1

**Tasks**:
- [ ] Create `TrainingHoursService`
- [ ] Listen to `kehadiran_sesi` creation event
- [ ] Extract `jam_latihan_dikreditkan` and `acara.kategori_jam_latihan`
- [ ] Update or create `jam_latihan_tahunan` record for user + year
- [ ] Increment appropriate category (RULE-HOURS-002)
- [ ] Update `jumlah_jam`
- [ ] Calculate `peratus_pencapaian` (RULE-HOURS-005)
- [ ] Handle year rollover (RULE-HOURS-003)

**Dependencies**: SESSION-003

**Reference**: RULES.md RULE-HOURS-001 to RULE-HOURS-005

**Acceptance Criteria**:
- Training hours automatically accumulated after check-in
- Categorized correctly (mandatory, voluntary, meeting, etc.)
- Annual total calculated
- Achievement percentage updated

---

#### HOURS-002: Training Hours Dashboard (User)
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: Frontend Dev 1

**Tasks**:
- [ ] Create training hours dashboard page
- [ ] Display for current year:
  - Total hours (with progress bar)
  - Target (56 hours default)
  - Achievement percentage
  - Breakdown by category (pie chart)
  - List of attended events with hours
- [ ] Color-coded progress (Red <50%, Yellow 50-79%, Green 80-99%, Blue ≥100%)
- [ ] Export to PDF (LNPT format)

**Dependencies**: HOURS-001

**Reference**: RULES.md RULE-HOURS-004, RULE-HOURS-005

**Acceptance Criteria**:
- User can view their annual training hours
- Progress visualized clearly
- Breakdown by category shown
- Export to PDF for LNPT

---

#### HOURS-003: Training Hours Reporting (Admin/Evaluator)
**Priority**: Should Have
**Effort**: 4 days
**Assigned To**: Backend Dev 2 + Frontend Dev 2

**Tasks**:
- [ ] **Backend**:
  - [ ] Create endpoint `GET /api/training-hours/department/{id}`
  - [ ] Return all users in department with their hours
  - [ ] Calculate department average
  - [ ] Filter users below target
- [ ] **Frontend**:
  - [ ] Create department training hours report page
  - [ ] Table: User, Total Hours, Target, Achievement %, Status
  - [ ] Filter: Below 50%, Below 75%, All
  - [ ] Export to Excel
- [ ] **Testing**:
  - [ ] Test report generation
  - [ ] Test permissions (Ketua Jabatan, Pegawai Penilai)

**Dependencies**: HOURS-001

**Reference**: RULES.md section 11.3

**Acceptance Criteria**:
- Department head can view all staff training hours
- Identify staff below target
- Export to Excel for analysis

---

#### HOURS-004: Mid-Year Notification Scheduler
**Priority**: Should Have
**Effort**: 2 days
**Assigned To**: Backend Dev 1

**Tasks**:
- [ ] Create scheduled command `app:send-training-hours-reminders`
- [ ] Run quarterly (Q2, Q3, Q4)
- [ ] Check users below threshold (RULE-HOURS-009)
- [ ] Send email notification
- [ ] Schedule in Laravel scheduler

**Dependencies**: HOURS-001

**Reference**: RULES.md RULE-HOURS-009

**Acceptance Criteria**:
- Automated reminders sent quarterly
- Only to users below target
- Email content actionable

---

### Module 15: Enhanced Reporting & Export

#### EXPORT-001: Export Attendance Report to Excel
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: Backend Dev 1

**Tasks**:
- [ ] Install `maatwebsite/excel` package
- [ ] Create export class `AttendanceExport`
- [ ] Implement export logic for event attendance
- [ ] Include: Participant details, check-in time, GPS, status
- [ ] Create endpoint `GET /api/events/{id}/export/excel`
- [ ] Add button on frontend report page

**Dependencies**: REPORT-001

**Reference**: PRD FR-5.2

**Acceptance Criteria**:
- Organizer can export attendance to Excel
- File downloads correctly
- All data included

---

#### EXPORT-002: Export Attendance Report to PDF
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: Backend Dev 2

**Tasks**:
- [ ] Create PDF template for attendance report
- [ ] Include event details and participant table
- [ ] Add summary statistics
- [ ] Create endpoint `GET /api/events/{id}/export/pdf`
- [ ] Add button on frontend

**Dependencies**: REPORT-001, CERT-001

**Acceptance Criteria**:
- Report exported as professional PDF
- Printable format
- Includes all necessary data

---

#### REPORT-003: Advanced Filtering & Search
**Priority**: Should Have
**Effort**: 3 days
**Assigned To**: Backend Dev 1 + Frontend Dev 1

**Tasks**:
- [ ] Add advanced filters to event list:
  - Date range (custom picker)
  - Department (multi-select)
  - Category (multi-select)
  - Status (multi-select)
  - Organizer (search)
- [ ] Add search by event name/reference
- [ ] Save filter presets (optional)
- [ ] **Backend**: Support complex query building

**Dependencies**: EVENT-002

**Acceptance Criteria**:
- Users can filter events with multiple criteria
- Search works quickly (< 1s for 10,000 events)
- Results paginated

---

### Module 16: Additional Features

#### NOTIF-001: Automated Event Reminders
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: Backend Dev 2

**Tasks**:
- [ ] Create scheduled command `app:send-event-reminders`
- [ ] Run hourly
- [ ] Find events starting in: 7 days, 1 day, 1 hour
- [ ] Send email reminders to participants (RULE-NOTIF-002)
- [ ] Track sent reminders (prevent duplicates)
- [ ] Schedule in Laravel scheduler

**Dependencies**: EVENT-003, SETUP-005

**Reference**: RULES.md RULE-NOTIF-002

**Acceptance Criteria**:
- Reminders sent at H-7, H-1, H-1hour
- Only to confirmed participants
- No duplicate emails

---

#### BULK-001: Bulk User Import via CSV
**Priority**: Should Have
**Effort**: 4 days
**Assigned To**: Backend Dev 1 + Frontend Dev 1

**Tasks**:
- [ ] **Backend**:
  - [ ] Create endpoint `POST /api/users/import` (CSV file upload)
  - [ ] Validate CSV format (columns: no_kp, nama, email, etc.)
  - [ ] For each row: Call EPSM API for No. KP
  - [ ] Return preview: found/not-found/already-exists
  - [ ] Create endpoint `POST /api/users/import/confirm` (bulk insert)
  - [ ] Generate temporary passwords
  - [ ] Send welcome emails
- [ ] **Frontend**:
  - [ ] Create bulk import page
  - [ ] Upload CSV file
  - [ ] Display preview table with status
  - [ ] Show statistics: X found, Y not found, Z errors
  - [ ] Confirm import button
  - [ ] Download failed records CSV

**Dependencies**: AUTH-002

**Reference**: API_INTEGRATION.md section 2.3, PRD FR-1.5

**Acceptance Criteria**:
- Admin can upload CSV with 100+ users
- EPSM API called for each user
- Preview shows results before import
- Users created with temporary passwords
- Welcome emails sent

---

#### BULK-002: Bulk Participant Import for Event
**Priority**: Should Have
**Effort**: 3 days
**Assigned To**: Backend Dev 2 + Frontend Dev 1

**Tasks**:
- [ ] Create endpoint `POST /api/events/{id}/participants/import` (CSV)
- [ ] CSV format: no_kp (required)
- [ ] Look up users by No. KP
- [ ] Add to `peserta_acara` in bulk
- [ ] Check quota limit
- [ ] Return success/failed list
- [ ] **Frontend**: Upload CSV and display results

**Dependencies**: EVENT-003, BULK-001

**Acceptance Criteria**:
- Organizer can add 200+ participants via CSV
- Quota enforced
- Failed additions reported

---

## Phase 3: Integration & Polish

### Module 17: Progressive Web App (PWA)

#### PWA-001: PWA Configuration
**Priority**: Should Have
**Effort**: 3 days
**Assigned To**: Frontend Lead

**Tasks**:
- [ ] Create `manifest.json` (app name, icons, colors)
- [ ] Create service worker for offline support
- [ ] Cache critical assets (CSS, JS, fonts)
- [ ] Cache static pages (login, events list)
- [ ] Configure push notification support
- [ ] Test install prompt on mobile (iOS/Android)

**Dependencies**: All frontend modules

**Acceptance Criteria**:
- App installable on mobile home screen
- Works offline (cached pages)
- Push notifications enabled
- PWA passes Lighthouse audit (>90 score)

---

#### PWA-002: Offline QR Scanner
**Priority**: Could Have
**Effort**: 4 days
**Assigned To**: Frontend Dev 2

**Tasks**:
- [ ] Cache QR code scan page
- [ ] Store event data in IndexedDB
- [ ] Allow QR scan offline
- [ ] Queue attendance records locally
- [ ] Sync to server when online
- [ ] Show sync status indicator

**Dependencies**: PWA-001, QR-004

**Acceptance Criteria**:
- QR can be scanned without internet
- Attendance synced when connection restored
- User notified of offline mode

---

### Module 18: Performance Optimization

#### PERF-001: Database Query Optimization
**Priority**: Must Have
**Effort**: 4 days
**Assigned To**: Backend Lead

**Tasks**:
- [ ] Analyze slow queries with Laravel Telescope
- [ ] Add missing indexes (consult ERD.md)
- [ ] Optimize N+1 queries (use eager loading)
- [ ] Add database query caching (Redis)
- [ ] Implement pagination for all large datasets
- [ ] Test with 50,000 users and 10,000 events

**Dependencies**: All backend modules

**Acceptance Criteria**:
- No query > 500ms
- Event list loads in < 1s with 10,000 events
- Dashboard loads in < 2s

---

#### PERF-002: API Response Caching
**Priority**: Should Have
**Effort**: 2 days
**Assigned To**: Backend Dev 1

**Tasks**:
- [ ] Implement Redis caching for:
  - Department list (TTL: 1 hour)
  - User roles/permissions (TTL: 5 minutes)
  - Event list (TTL: 1 minute)
  - Training hours summary (TTL: 15 minutes)
- [ ] Invalidate cache on updates
- [ ] Add cache-control headers

**Dependencies**: PERF-001

**Acceptance Criteria**:
- Repeated API calls served from cache
- Cache invalidated on data changes
- Response time < 100ms for cached requests

---

#### PERF-003: Frontend Bundle Optimization
**Priority**: Should Have
**Effort**: 2 days
**Assigned To**: Frontend Lead

**Tasks**:
- [ ] Enable code splitting (lazy load routes)
- [ ] Minify and compress JS/CSS
- [ ] Optimize images (WebP format)
- [ ] Enable Vite build optimizations
- [ ] Add CDN for static assets
- [ ] Run Lighthouse audit

**Dependencies**: All frontend modules

**Acceptance Criteria**:
- Initial bundle size < 200KB gzipped
- Lighthouse performance score > 90
- First contentful paint < 1.5s

---

### Module 19: Security & Compliance

#### SEC-001: Security Audit & Penetration Testing
**Priority**: Must Have
**Effort**: 10 days (external vendor)
**Assigned To**: External Security Firm

**Tasks**:
- [ ] Conduct penetration testing
- [ ] Test for OWASP Top 10 vulnerabilities
- [ ] Test SQL injection, XSS, CSRF
- [ ] Test authentication bypass
- [ ] Test authorization flaws
- [ ] Test QR code tampering
- [ ] Document findings
- [ ] Fix critical/high vulnerabilities

**Dependencies**: All modules complete

**Acceptance Criteria**:
- No critical vulnerabilities
- High vulnerabilities fixed
- Security audit report signed off

---

#### SEC-002: Data Encryption Implementation
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: Backend Lead

**Tasks**:
- [ ] Enable database encryption at rest (MySQL encryption)
- [ ] Encrypt sensitive fields: `no_kp`, `epsm_raw_data`
- [ ] Use Laravel encryption (`Crypt::encrypt()`)
- [ ] Secure APP_KEY in production (AWS Secrets Manager)
- [ ] Enable HTTPS only (redirect HTTP → HTTPS)
- [ ] Set secure cookie flags

**Dependencies**: All backend modules

**Reference**: RULES.md RULE-AUDIT-004

**Acceptance Criteria**:
- Sensitive data encrypted at rest
- HTTPS enforced
- APP_KEY securely managed

---

#### SEC-003: PDPA Compliance Implementation
**Priority**: Must Have
**Effort**: 4 days
**Assigned To**: Backend Dev 1 + Frontend Dev 1

**Tasks**:
- [ ] Add consent checkbox during registration
- [ ] Store consent with timestamp
- [ ] Create privacy policy page
- [ ] Create terms of service page
- [ ] Implement data export (user can download their data)
- [ ] Implement data deletion request (with approval workflow)
- [ ] Document PDPA compliance measures

**Dependencies**: AUTH-001

**Reference**: RULES.md RULE-AUDIT-003

**Acceptance Criteria**:
- User consents to data processing during registration
- Privacy policy and ToS accessible
- User can request data export/deletion
- Compliance documented

---

### Module 20: Documentation & Training

#### DOC-001: API Documentation
**Priority**: Must Have
**Effort**: 5 days
**Assigned To**: Backend Lead + Technical Writer

**Tasks**:
- [ ] Install Scribe or L5-Swagger
- [ ] Document all API endpoints
- [ ] Include request/response examples
- [ ] Document authentication
- [ ] Document error codes
- [ ] Publish at `/docs/api`
- [ ] Generate Postman collection

**Dependencies**: All backend modules

**Acceptance Criteria**:
- All endpoints documented
- Examples provided
- API docs accessible and searchable

---

#### DOC-002: User Manual (Bahasa Malaysia)
**Priority**: Must Have
**Effort**: 10 days
**Assigned To**: Technical Writer + Subject Matter Expert

**Tasks**:
- [ ] Write user manual for each role:
  - Participant (peserta)
  - Organizer (penyelaras)
  - Admin Jabatan
  - Super Admin
- [ ] Include screenshots and step-by-step guides
- [ ] Cover common tasks and troubleshooting
- [ ] Create video tutorials (5-10 minutes each)
- [ ] Publish in PDF and online

**Dependencies**: All features complete

**Acceptance Criteria**:
- User manual covers all features
- In Bahasa Malaysia
- Screenshots up-to-date
- Videos published

---

#### TRAIN-001: Organizer Training Program
**Priority**: Must Have
**Effort**: 5 days (per batch)
**Assigned To**: Trainer + Project Manager

**Tasks**:
- [ ] Develop training curriculum (2-hour session)
- [ ] Create training slides
- [ ] Conduct training for 20-30 organizers per batch
- [ ] Hands-on practice: Create event, add participants, generate QR
- [ ] Q&A session
- [ ] Distribute user manual
- [ ] Collect feedback

**Dependencies**: DOC-002, UAT complete

**Acceptance Criteria**:
- 100+ organizers trained across departments
- >80% satisfaction rating
- All organizers can create and manage events independently

---

### Module 21: Deployment & DevOps

#### DEPLOY-001: Staging Environment Setup
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: DevOps Lead

**Tasks**:
- [ ] Provision staging server (Ubuntu 22.04)
- [ ] Install PHP 8.2, MySQL 8, Redis, Nginx
- [ ] Configure domain: `staging.daftar.kedah.gov.my`
- [ ] SSL certificate (Let's Encrypt)
- [ ] Configure CI/CD auto-deployment
- [ ] Database backups (daily)
- [ ] Monitoring (Uptime, errors)

**Dependencies**: SETUP-002

**Acceptance Criteria**:
- Staging accessible at subdomain
- HTTPS enabled
- Auto-deploys on `main` branch push
- Monitoring active

---

#### DEPLOY-002: Production Environment Setup
**Priority**: Must Have
**Effort**: 5 days
**Assigned To**: DevOps Lead

**Tasks**:
- [ ] Provision production servers (load balanced)
- [ ] Set up database replication (master-slave)
- [ ] Configure Redis cluster
- [ ] Configure MinIO/S3 for file storage
- [ ] Set up CDN (CloudFlare or local)
- [ ] Configure domain: `daftar.kedah.gov.my`
- [ ] SSL certificate
- [ ] Set up monitoring (Grafana + Prometheus)
- [ ] Configure automated backups (hourly DB, daily files)
- [ ] Set up disaster recovery plan

**Dependencies**: DEPLOY-001, All modules tested

**Acceptance Criteria**:
- Production servers ready for 500+ concurrent users
- 99.5% uptime SLA
- Database replicated
- Backups automated
- Monitoring dashboards functional

---

#### DEPLOY-003: Load Testing
**Priority**: Must Have
**Effort**: 3 days
**Assigned To**: DevOps Lead + Backend Lead

**Tasks**:
- [ ] Set up load testing tool (Apache JMeter or k6)
- [ ] Create test scenarios:
  - 500 concurrent QR scans
  - 1000 concurrent event list loads
  - 200 concurrent certificate generations
- [ ] Run tests on staging
- [ ] Identify bottlenecks
- [ ] Optimize (database, caching, server config)
- [ ] Re-test until targets met

**Dependencies**: DEPLOY-001, PERF-001, PERF-002

**Acceptance Criteria**:
- System handles 500 concurrent users
- Response times acceptable under load
- No crashes or errors during peak load

---

#### DEPLOY-004: Production Deployment & Go-Live
**Priority**: Must Have
**Effort**: 2 days
**Assigned To**: DevOps Lead + Project Manager

**Tasks**:
- [ ] Final smoke tests on production
- [ ] Migrate production database
- [ ] Import initial data (departments, roles, admin users)
- [ ] Switch DNS to production
- [ ] Monitor for 24 hours
- [ ] Fix any issues immediately
- [ ] Communicate go-live to all departments

**Dependencies**: DEPLOY-002, DEPLOY-003, All testing complete

**Acceptance Criteria**:
- Production live and accessible
- No critical issues in first 24 hours
- All departments notified

---

## Ongoing Tasks

### SUPPORT-001: Bug Fixes & Maintenance
**Priority**: Must Have
**Ongoing**: Throughout project and post-launch
**Assigned To**: Development Team (rotating)

**Tasks**:
- [ ] Monitor error logs daily
- [ ] Triage and prioritize bug reports
- [ ] Fix critical bugs within 24 hours
- [ ] Fix high priority bugs within 1 week
- [ ] Regular security patches

---

### SUPPORT-002: User Support & Helpdesk
**Priority**: Must Have
**Ongoing**: Post-launch
**Assigned To**: Support Team

**Tasks**:
- [ ] Set up helpdesk email/ticketing system
- [ ] Respond to user queries within 24 hours
- [ ] Escalate technical issues to dev team
- [ ] Maintain FAQ and knowledge base
- [ ] Conduct additional training sessions as needed

---

### ANALYTICS-001: Usage Analytics & Reporting
**Priority**: Should Have
**Ongoing**: Post-launch
**Assigned To**: Backend Dev + Data Analyst

**Tasks**:
- [ ] Track key metrics:
  - Monthly active users
  - Events created per month
  - QR scans per day
  - Certificate generations
  - System uptime
- [ ] Create executive dashboard
- [ ] Monthly reports to stakeholders
- [ ] Identify improvement opportunities

---

## Effort Estimation Guide

### Effort Scale
- **1 day**: Simple task, clear requirements, minimal complexity
- **2-3 days**: Moderate task, some complexity, well-understood
- **4-6 days**: Complex task, multiple components, requires design
- **7-10 days**: Large feature, high complexity, needs architecture
- **10+ days**: Major module or external dependency (UAT, security audit)

### Task Duration Factors
Estimates assume:
- Developer is familiar with Laravel/Vue.js
- Clear requirements documented
- No major blockers
- Normal working hours (8 hours/day)

Multiply estimates by 1.5x for:
- Junior developers
- Unclear requirements
- New technology stack
- High complexity/risk tasks

---

## Task Dependencies Matrix

### Critical Path (Must Complete in Order)

```
SETUP-001 (Dev Environment)
    ↓
SETUP-003 (Database Schema)
    ↓
SETUP-004 (Eloquent Models)
    ↓
AUTH-001 (Registration)
    ↓
AUTH-004 (Login)
    ↓
EVENT-001 (Event Creation)
    ↓
QR-001 (QR Generation)
    ↓
QR-003 (QR Scanning & Attendance)
    ↓
CERT-002 (Certificate Generation)
    ↓
TEST-003 (UAT)
    ↓
DEPLOY-004 (Go-Live)
```

### Parallel Tracks (Can Work Simultaneously)

**Track 1: Core Backend**
- AUTH-*, EVENT-*, QR-*, CERT-*

**Track 2: Frontend**
- SETUP-006, UI components, dashboards

**Track 3: Advanced Features (Phase 2)**
- SESSION-*, ONLINE-*, SUB-*, HOURS-*

**Track 4: DevOps**
- SETUP-002, DEPLOY-*, PERF-*, SEC-*

**Track 5: Documentation**
- DOC-*, TRAIN-*

---

## Team Structure

### Recommended Team Composition

| Role | Count | Responsibilities |
|------|-------|------------------|
| **Project Manager** | 1 | Overall coordination, stakeholder management, timeline tracking |
| **Backend Lead** | 1 | Architecture, code review, complex features |
| **Backend Developers** | 2-3 | API development, business logic, database |
| **Frontend Lead** | 1 | UI/UX architecture, code review |
| **Frontend Developers** | 2 | Vue.js components, Inertia pages |
| **DevOps Lead** | 1 | Infrastructure, deployment, monitoring |
| **QA Engineer** | 1 | Testing, bug tracking, UAT coordination |
| **Technical Writer** | 1 | Documentation, user manuals |
| **Designer** | 1 (part-time) | UI/UX design, certificate templates |
| **Data Analyst** | 1 (part-time) | Analytics, reporting |

**Total Team Size**: 10-12 people

---

## Phase Summary

### Phase 0 (Weeks 1-3)
**Team**: Full team
**Output**: Working dev environment, database schema, CI/CD

### Phase 1 (Weeks 4-15)
**Team**: Full team
**Output**: MVP with single-day events, QR scanning, certificates
**Milestone**: Pilot with 1 department

### Phase 2 (Weeks 16-25)
**Team**: Full team
**Output**: Multi-day events, online/hybrid, substitution, training hours
**Milestone**: 10 departments using system

### Phase 3 (Weeks 26-33)
**Team**: Reduced (6-8 people)
**Output**: PWA, performance, security, documentation
**Milestone**: Production launch for all departments

### Post-Launch (Ongoing)
**Team**: Support team (3-4 people)
**Output**: Bug fixes, support, analytics, enhancements

---

## Success Metrics

### Phase 1 (MVP) Success Criteria
- ✅ 1 pilot department conducts 1 course with 50 participants
- ✅ 100% QR scans successful
- ✅ 100% certificates auto-generated
- ✅ <5 critical bugs reported
- ✅ Pilot department satisfaction >80%

### Phase 2 Success Criteria
- ✅ 10 departments actively using system
- ✅ 100+ events conducted
- ✅ 5,000+ participants checked in via QR
- ✅ Multi-day events work smoothly
- ✅ <10 support tickets per week

### Phase 3 (Production) Success Criteria
- ✅ All 30+ departments onboarded
- ✅ 500+ concurrent users supported
- ✅ 99.5% uptime achieved
- ✅ <20 support tickets per week
- ✅ Security audit passed
- ✅ User satisfaction >85%

---

**End of Task Breakdown Document**

**Version**: 1.0
**Last Updated**: 2026-05-01
**Total Estimated Effort**: ~450 developer-days (~6-9 months with team of 10)
**Author**: Claude Code
