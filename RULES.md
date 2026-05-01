# Business Rules & Validation Rules
# e-DAFTAR Kedah - QR Attendance System

## Document Overview

This document defines all business rules, validation rules, calculation formulas, and operational constraints for the e-DAFTAR Kedah system. These rules must be enforced at both the application layer and database layer where applicable.

**Version**: 1.0
**Last Updated**: 2026-05-01
**Status**: Reference Document for Development

---

## Table of Contents

1. [User Management Rules](#1-user-management-rules)
2. [Authentication & Security Rules](#2-authentication--security-rules)
3. [Event Management Rules](#3-event-management-rules)
4. [Session Management Rules](#4-session-management-rules)
5. [QR Code Generation Rules](#5-qr-code-generation-rules)
6. [Attendance Recording Rules](#6-attendance-recording-rules)
7. [Geolocation Verification Rules](#7-geolocation-verification-rules)
8. [Participant Substitution Rules](#8-participant-substitution-rules)
9. [Attendance Calculation Rules](#9-attendance-calculation-rules)
10. [Certificate Generation Rules](#10-certificate-generation-rules)
11. [Training Hours Calculation Rules](#11-training-hours-calculation-rules)
12. [RBAC & Permission Rules](#12-rbac--permission-rules)
13. [Notification Rules](#13-notification-rules)
14. [Data Validation Rules](#14-data-validation-rules)
15. [Audit & Compliance Rules](#15-audit--compliance-rules)

---

## 1. User Management Rules

### 1.1 User Registration Rules

**RULE-USER-001**: No. KP (IC Number) Uniqueness
- **Rule**: Each No. KP must be unique in the system
- **Validation**: `UNIQUE` constraint on `users.no_kp`
- **Error**: "Akaun dengan No. KP ini telah wujud. Sila log masuk."
- **Exception**: None

**RULE-USER-002**: No. KP Format
- **Rule**: No. KP must be exactly 12 digits
- **Validation**: Regex `/^\d{12}$/`
- **Error**: "No. KP mesti 12 digit"
- **Example**: `900101015678` (valid), `12345` (invalid)

**RULE-USER-003**: Official Email Domain
- **Rule**: Email must end with `.gov.my` or approved government domains
- **Validation**: Regex `/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.gov\.my$/`
- **Error**: "E-mel mesti menggunakan domain rasmi kerajaan (.gov.my)"
- **Exception**: Super Admin can override for external consultants

**RULE-USER-004**: No. Pekerja (Employee Number) Uniqueness
- **Rule**: Employee number must be unique if provided
- **Validation**: `UNIQUE` constraint on `users.no_pekerja` (nullable)
- **Error**: "No. Pekerja ini telah didaftarkan"

**RULE-USER-005**: Default Role Assignment
- **Rule**: All new users automatically assigned `peserta` (participant) role
- **Logic**: On user creation, execute `user.assignRole('peserta')`
- **Exception**: Admins can assign additional roles immediately after creation

**RULE-USER-006**: EPSM Verification Priority
- **Rule**: If user data found in EPSM API, prioritize EPSM data over manual entry
- **Logic**:
  - Call EPSM API on No. KP entry
  - If `status = 'success'`, auto-fill fields and set `epsm_verified = true`
  - If `status = 'not_found'`, allow manual entry and set `epsm_verified = false`
- **Note**: User can still edit EPSM-populated fields before submission

### 1.2 User Profile Update Rules

**RULE-USER-007**: Critical Field Restrictions
- **Rule**: No. KP and Jabatan (Department) cannot be self-updated by regular users
- **Who Can Update**: Only Admin Jabatan or Super Admin
- **Reason**: Prevent fraud and maintain data integrity
- **Audit**: All critical field updates logged in `audit_log`

**RULE-USER-008**: Profile Sync Frequency
- **Rule**: Users can sync with EPSM API once every 24 hours
- **Logic**: Check `epsm_last_synced_at`, reject if `< 24 hours ago`
- **Error**: "Profil telah disegerakkan baru-baru ini. Sila cuba lagi selepas {time}"
- **Exception**: Admin can force sync anytime

---

## 2. Authentication & Security Rules

### 2.1 Password Rules

**RULE-AUTH-001**: Password Strength
- **Rule**: Minimum 8 characters, must contain:
  - At least 1 uppercase letter
  - At least 1 lowercase letter
  - At least 1 number
  - At least 1 special character (optional but recommended)
- **Validation**: Laravel validation rule `required|string|min:8|confirmed`
- **Error**: "Kata laluan mesti sekurang-kurangnya 8 aksara"

**RULE-AUTH-002**: Password Hash Algorithm
- **Rule**: Use `bcrypt` with cost factor 12
- **Implementation**: `Hash::make($password)` (Laravel default)
- **Storage**: `users.kata_laluan_hash`

**RULE-AUTH-003**: 2FA Requirement
- **Rule**: 2FA (OTP via email/SMS) mandatory for:
  - Super Admin
  - Admin Negeri
  - Admin Jabatan
- **Rule**: 2FA optional for other roles
- **OTP Expiry**: 5 minutes
- **OTP Length**: 6 digits

### 2.2 Session Rules

**RULE-AUTH-004**: Session Timeout
- **Rule**: Inactive session expires after 30 minutes
- **Implementation**: `config('session.lifetime')` = 30
- **Behavior**: User must re-login after timeout

**RULE-AUTH-005**: Concurrent Session Limit
- **Rule**: One active session per user at a time (for Admins)
- **Rule**: Multiple sessions allowed for `peserta` role (mobile + web)
- **Logic**: On new login, invalidate previous session token for admin roles

**RULE-AUTH-006**: Token Revocation on Role Change
- **Rule**: When critical role is revoked, session token must be invalidated within 60 seconds
- **Implementation**: Check role validity on every API request via middleware
- **Reason**: Security - prevent access with old privileges

---

## 3. Event Management Rules

### 3.1 Event Creation Rules

**RULE-EVENT-001**: Event Reference Number Format
- **Rule**: Auto-generate unique reference number in format: `KEDAH-{YEAR}-{CATEGORY}-{SEQUENCE}`
- **Example**: `KEDAH-2026-LATIH-0142`
- **Categories**:
  - `LATIH` = Latihan (Training)
  - `KURSUS` = Kursus (Course)
  - `MESYUARAT` = Mesyuarat (Meeting)
  - `BENGKEL` = Bengkel (Workshop)
  - `SEMINAR` = Seminar
- **Sequence**: 4-digit zero-padded, auto-increment per year per category

**RULE-EVENT-002**: Event Date Validation
- **Rule**: `tarikh_tamat >= tarikh_mula`
- **Validation**: Database `CHECK` constraint + application validation
- **Error**: "Tarikh tamat mesti sama atau selepas tarikh mula"

**RULE-EVENT-003**: Event Creator Ownership
- **Rule**: User who creates event (`dicipta_oleh`) automatically gets resource-level ownership
- **Logic**: Insert into `pemilikan_resource` with `jenis_pemilikan = 'pencipta'`
- **Permissions**: Creator has full CRUD access to their event

**RULE-EVENT-004**: Department Scope
- **Rule**: Events belong to one department (`jabatan_id`)
- **Access**: Only users with permissions scoped to that department can manage the event
- **Exception**: Super Admin and Admin Negeri can access all departments

**RULE-EVENT-005**: Event Status Transitions
- **Valid Transitions**:
  - `draf` → `aktif`
  - `aktif` → `selesai`
  - `draf` → `dibatalkan`
  - `aktif` → `dibatalkan`
- **Invalid**: Cannot move from `selesai` or `dibatalkan` to any other status
- **Validation**: Enforce via state machine or validation rules

### 3.2 Event Capacity Rules

**RULE-EVENT-006**: Participant Quota
- **Rule**: If `kuota` is set (not NULL), number of `peserta_acara` with status `sah` cannot exceed quota
- **Validation**: Before adding participant, check:
  ```sql
  SELECT COUNT(*) FROM peserta_acara
  WHERE acara_id = {event_id} AND status_jemputan = 'sah'
  ```
- **Error**: "Kuota peserta penuh ({kuota} orang). Hubungi penyelaras."

**RULE-EVENT-007**: Minimum Participants
- **Rule**: Event must have at least 1 confirmed participant (`status_jemputan = 'sah'`) before it can be activated
- **Validation**: Before changing status from `draf` to `aktif`
- **Error**: "Acara mesti mempunyai sekurang-kurangnya 1 peserta sebelum diaktifkan"

### 3.3 Event Type Rules

**RULE-EVENT-008**: Geolocation for Physical Events
- **Rule**: For `jenis_acara = 'fizikal'`:
  - `koordinat_lat` and `koordinat_lng` must be provided
  - `radius_geo_meter` must be > 0 (default 100m)
- **Validation**: Required fields validation
- **Error**: "Acara fizikal mesti mempunyai koordinat lokasi"

**RULE-EVENT-009**: Geolocation Disabled for Online Events
- **Rule**: For `jenis_acara = 'dalam_talian'`:
  - Geolocation verification automatically disabled
  - `koordinat_lat`, `koordinat_lng`, `radius_geo_meter` can be NULL
- **Logic**: Skip geolocation check in attendance validation

**RULE-EVENT-010**: Hybrid Event Requirements
- **Rule**: For `jenis_acara = 'hibrid'`:
  - Must have both physical location (koordinat) AND online meeting URL
  - `pautan_meeting_url` must be valid URL
  - Each participant categorized as `kategori_kehadiran` = 'fizikal' OR 'dalam_talian'
- **Validation**: `pautan_meeting_url` required if `jenis_acara = 'hibrid'`

### 3.4 Multi-Day Event Rules

**RULE-EVENT-011**: Multi-Day Event Flag
- **Rule**: If `adalah_berbilang_hari = true`, event must have at least 1 session in `sesi` table
- **Validation**: Before activating event, check:
  ```sql
  SELECT COUNT(*) FROM sesi WHERE acara_id = {event_id}
  ```
- **Error**: "Acara berbilang hari mesti mempunyai sekurang-kurangnya 1 sesi"

**RULE-EVENT-012**: Single-Day Event Restriction
- **Rule**: If `adalah_berbilang_hari = false`, event cannot have sessions
- **Logic**: Use event-level QR code only, no `sesi` records
- **Attendance**: Recorded directly in `kehadiran` (not `kehadiran_sesi`)

**RULE-EVENT-013**: Series Event Linking
- **Rule**: For recurring events (`adalah_siri = true`):
  - First event in series: `id_acara_induk_siri = NULL`
  - Subsequent events: `id_acara_induk_siri` points to first event
- **Logic**: When creating from template, copy all settings except dates and participants

---

## 4. Session Management Rules

### 4.1 Session Creation Rules

**RULE-SESI-001**: Session Belongs to Multi-Day Event
- **Rule**: Sessions can only be created for events where `acara.adalah_berbilang_hari = true`
- **Validation**: Foreign key constraint + application check
- **Error**: "Sesi hanya boleh dicipta untuk acara berbilang hari"

**RULE-SESI-002**: Session Sequence Uniqueness
- **Rule**: Within an event, `urutan_sesi` must be unique and sequential (1, 2, 3, ...)
- **Validation**: `UNIQUE(acara_id, urutan_sesi)`
- **Logic**: Auto-increment based on existing sessions

**RULE-SESI-003**: Session Time Validation
- **Rule**: `masa_tamat > masa_mula`
- **Validation**: `CHECK` constraint + application validation
- **Error**: "Masa tamat sesi mesti selepas masa mula"

**RULE-SESI-004**: Session Date Within Event Period
- **Rule**: `sesi.tarikh` must be between `acara.tarikh_mula` and `acara.tarikh_tamat`
- **Validation**: Application-level check
- **Error**: "Tarikh sesi mesti dalam tempoh acara ({tarikh_mula} hingga {tarikh_tamat})"

### 4.2 Session Training Hours Calculation

**RULE-SESI-005**: Training Hours Formula
- **Rule**: `jam_latihan_dikira = TIMESTAMPDIFF(HOUR, masa_mula, masa_tamat)`
- **Rounding**: Round to 1 decimal place (e.g., 3.5 hours)
- **Example**:
  - 9:00 AM - 12:30 PM = 3.5 hours
  - 2:00 PM - 5:00 PM = 3.0 hours
- **Calculation**: Performed on session creation/update

**RULE-SESI-006**: Maximum Session Duration
- **Rule**: Single session cannot exceed 8 hours
- **Reason**: Realistic training session length
- **Validation**: `jam_latihan_dikira <= 8.0`
- **Error**: "Tempoh sesi tidak boleh melebihi 8 jam"

### 4.3 Mandatory vs Optional Sessions

**RULE-SESI-007**: Mandatory Session Flag
- **Rule**: Each session marked as `adalah_wajib = true` (default) or `false`
- **Impact**: Only mandatory sessions count toward attendance percentage
- **Optional Session Behavior**: Attended optional sessions add to total training hours but don't affect certificate eligibility

**RULE-SESI-008**: Minimum Mandatory Sessions
- **Rule**: Multi-day event must have at least 50% of sessions as mandatory
- **Validation**:
  ```sql
  COUNT(CASE WHEN adalah_wajib = true) >= COUNT(*) * 0.5
  ```
- **Error**: "Sekurang-kurangnya separuh daripada sesi mesti ditetapkan sebagai wajib"

---

## 5. QR Code Generation Rules

### 5.1 QR Token Generation

**RULE-QR-001**: JWT Token Structure
- **Rule**: QR code contains JWT token with payload:
  ```json
  {
    "event_id": "uuid",
    "session_id": "uuid|null",
    "qr_type": "event|session",
    "issued_at": "timestamp",
    "expires_at": "timestamp",
    "signature": "hash"
  }
  ```
- **Signing Algorithm**: HS256 (HMAC-SHA256)
- **Secret Key**: `APP_KEY` from environment

**RULE-QR-002**: Static QR Token Expiry
- **Rule**: For `qr_mod = 'statik'`:
  - Token valid for entire event duration
  - `expires_at` = `acara.tarikh_tamat + 2 hours`
- **Reason**: Allow late check-ins/outs

**RULE-QR-003**: Dynamic QR Token Rotation
- **Rule**: For `qr_mod = 'dinamik'`:
  - Token rotates every 30 seconds
  - `expires_at` = `issued_at + 30 seconds`
  - New token generated every 30 seconds during active session
- **Implementation**: Backend job generates new token, frontend polls every 30s
- **Anti-Sharing**: Screenshot of QR becomes invalid after 30 seconds

**RULE-QR-004**: QR URL Format
- **Rule**: QR code encodes URL: `https://daftar.kedah.gov.my/scan/{jwt_token}`
- **Behavior**: Clicking QR redirects to attendance check-in page
- **Validation**: Token verified before allowing check-in

### 5.2 QR Scan Validity Window

**RULE-QR-005**: Event-Level QR Validity (Single-Day)
- **Rule**: For single-day events:
  - Valid from: `tarikh_mula - 30 minutes`
  - Valid until: `tarikh_mula + 30 minutes`
- **Example**: Event at 9:00 AM, QR valid 8:30 AM - 9:30 AM
- **Error**: "QR Code hanya sah pada hari acara"

**RULE-QR-006**: Session-Level QR Validity (Multi-Day)
- **Rule**: For multi-day events (per session):
  - Valid from: `masa_mula - tempoh_sah_imbas_sebelum_minit` (default 30 min)
  - Valid until: `masa_mula + tempoh_sah_imbas_selepas_minit` (default 30 min)
- **Configurable**: Organizer can set `tempoh_sah_imbas_sebelum_minit` and `tempoh_sah_imbas_selepas_minit` per session
- **Error**: "QR Code sesi ini telah tamat tempoh"

**RULE-QR-007**: QR Scan Once Per Session
- **Rule**: Each participant can scan QR only ONCE per session
- **Validation**: Check for existing `kehadiran_sesi` record:
  ```sql
  SELECT * FROM kehadiran_sesi
  WHERE sesi_id = {session_id} AND pengguna_id = {user_id}
  ```
- **Error**: "Anda telah mendaftar kehadiran untuk sesi ini"
- **Exception**: Admin can manually mark attendance (override)

---

## 6. Attendance Recording Rules

### 6.1 Check-In Rules

**RULE-ATTEND-001**: Participant Must Be Invited
- **Rule**: User can only check-in if they exist in `peserta_acara` with `status_jemputan IN ('dijemput', 'sah')`
- **Validation**: Before allowing QR scan
- **Error**: "Anda tidak dijemput ke acara ini"

**RULE-ATTEND-002**: Walk-In Substitution Exception
- **Rule**: If user not in `peserta_acara` but scans QR:
  - Show message: "Anda bukan dalam senarai peserta. Adakah anda mewakili sesiapa?"
  - Allow substitution request (see Substitution Rules)

**RULE-ATTEND-003**: Attendance Timestamp
- **Rule**: `kehadiran_sesi.masa_daftar_masuk` = server timestamp (not client time)
- **Reason**: Prevent time manipulation
- **Timezone**: Malaysia Time (UTC+8)

**RULE-ATTEND-004**: Device & Location Recording
- **Rule**: On QR scan, record:
  - `alat_imbas` = User-Agent string
  - `ip_imbas` = Client IP address
  - `koordinat_imbas` = GPS coordinates (if geolocation enabled)
- **Purpose**: Audit trail and fraud prevention

### 6.2 Check-Out Rules (Optional)

**RULE-ATTEND-005**: Check-Out Requirement
- **Rule**: Check-out (`masa_daftar_keluar`) is OPTIONAL
- **When Required**:
  - Organizer enables check-out for accurate duration tracking
  - Events with strict audit requirements
- **When Not Required**: System uses session end time as default

**RULE-ATTEND-006**: Check-Out Validation
- **Rule**: If check-out enabled:
  - `masa_daftar_keluar > masa_daftar_masuk`
  - Check-out must be on same day as check-in (for single-day events)
- **Error**: "Masa daftar keluar tidak sah"

**RULE-ATTEND-007**: Training Hours Credit (With Check-Out)
- **Rule**: If both check-in and check-out recorded:
  ```
  jam_latihan_dikreditkan = TIMESTAMPDIFF(HOUR, masa_daftar_masuk, masa_daftar_keluar)
  ```
- **Minimum Attendance**: Must attend at least 80% of session duration to receive credit
  ```
  IF jam_latihan_dikreditkan >= (sesi.jam_latihan_dikira * 0.8) THEN
    Credit full session hours
  ELSE
    Credit 0 hours (did not meet minimum)
  END IF
  ```

**RULE-ATTEND-008**: Training Hours Credit (Without Check-Out)
- **Rule**: If only check-in recorded:
  - `jam_latihan_dikreditkan = sesi.jam_latihan_dikira`
  - Credit full session hours (benefit of doubt)

---

## 7. Geolocation Verification Rules

### 7.1 GPS Validation Rules

**RULE-GEO-001**: Geolocation Required for Physical Events
- **Rule**: For `jenis_acara = 'fizikal'`, GPS coordinates must be provided during QR scan
- **Client**: Request geolocation permission from user's browser/app
- **Error**: "Sila benarkan capaian lokasi untuk mendaftar kehadiran"

**RULE-GEO-002**: Radius Verification Formula
- **Rule**: Calculate distance between scan location and event location:
  ```sql
  SELECT ST_Distance_Sphere(
    POINT(acara.koordinat_lng, acara.koordinat_lat),
    POINT(user_lng, user_lat)
  ) AS distance_meters
  ```
- **Validation**: `distance_meters <= acara.radius_geo_meter`
- **Error**: "Anda berada terlalu jauh dari lokasi acara ({distance}m, had {radius}m)"

**RULE-GEO-003**: Default Geolocation Radius
- **Rule**: Default radius = 100 meters
- **Configurable**: Organizer can set per event (range: 50m - 1000m)
- **Reason**: 100m allows flexibility for large buildings

**RULE-GEO-004**: Geolocation Accuracy Threshold
- **Rule**: GPS accuracy must be ≤ 50 meters
- **Client**: Check `coordinates.accuracy` property
- **Behavior**: If accuracy > 50m, warn user: "Isyarat GPS lemah. Sila cuba lagi di lokasi terbuka."
- **Override**: Admin can disable accuracy check for indoor venues

**RULE-GEO-005**: Geolocation Disabled for Online Events
- **Rule**: For `jenis_acara = 'dalam_talian'`, skip geolocation verification entirely
- **Logic**: No GPS check in attendance validation

**RULE-GEO-006**: Hybrid Event Geolocation
- **Rule**: For `jenis_acara = 'hibrid'`:
  - If `peserta_acara.kategori_kehadiran = 'fizikal'`: Apply geolocation check
  - If `peserta_acara.kategori_kehadiran = 'dalam_talian'`: Skip geolocation check

---

## 8. Participant Substitution Rules

### 8.1 Pre-Event Substitution Rules

**RULE-SUB-001**: Substitution Request Window
- **Rule**: Pre-event substitution can be requested up to 1 hour before event starts
- **Validation**:
  ```sql
  acara.tarikh_mula - NOW() >= INTERVAL 1 HOUR
  ```
- **Error**: "Permohonan gantian pra-acara telah ditutup. Sila hubungi penyelaras secara langsung."

**RULE-SUB-002**: Same Department Requirement
- **Rule**: Substitute (`wakil`) must be from same department as original participant
- **Validation**:
  ```sql
  wakil.jabatan_id = peserta_asal.jabatan_id
  ```
- **Error**: "Wakil mesti dari jabatan yang sama dengan peserta asal"
- **Override**: Super Admin can allow cross-department substitution

**RULE-SUB-003**: Substitute Not Already Participant
- **Rule**: Substitute cannot already be invited to the same event
- **Validation**: Check if `wakil_id` exists in `peserta_acara` for same `acara_id`
- **Error**: "Wakil sudah dijemput ke acara ini sebagai peserta utama"

**RULE-SUB-004**: Pre-Event Substitution Approval Required
- **Rule**: For `mod_gantian = 'dengan_kelulusan'`:
  - Status starts as `menunggu`
  - Requires organizer approval before taking effect
- **SLA**: Organizer should approve/reject within 24 hours (for pre-event requests)

**RULE-SUB-005**: Open Substitution Mode
- **Rule**: For `mod_gantian = 'terbuka'`:
  - Auto-approve substitutions from same department
  - Status immediately set to `diluluskan`
  - No organizer action required

**RULE-SUB-006**: Substitution Not Allowed
- **Rule**: For `mod_gantian = 'tidak_dibenarkan'`:
  - Reject all substitution requests
  - Error: "Gantian tidak dibenarkan untuk acara ini"

### 8.2 Walk-In Substitution Rules

**RULE-SUB-007**: Walk-In Substitution Window
- **Rule**: Walk-in substitution can be requested from event start time until 30 minutes after start
- **Validation**:
  ```sql
  NOW() BETWEEN acara.tarikh_mula AND (acara.tarikh_mula + INTERVAL 30 MINUTE)
  ```
- **Reason**: Allow latecomers but prevent abuse

**RULE-SUB-008**: Walk-In Approval SLA
- **Rule**: Organizer must approve/reject walk-in substitution within 5 minutes
- **Notification**: Send push notification + SMS to organizer immediately
- **Behavior**: Substitute waits at registration counter until approved

**RULE-SUB-009**: Walk-In Auto-Approval (Open Mode)
- **Rule**: For `mod_gantian = 'terbuka'`:
  - Walk-in from same department auto-approved
  - Attendance recorded immediately
  - Tag with `adalah_wakil_gantian = true`

### 8.3 Per-Session Substitution Rules (Multi-Day Events)

**RULE-SUB-010**: Per-Session Substitution Scope
- **Rule**: For multi-day events, substitution can be for:
  - Entire event (`sesi_id = NULL`)
  - Specific session(s) (`sesi_id` specified)
- **Effect**:
  - Entire event: Original participant removed, substitute added to all sessions
  - Per-session: Original participant remains for other sessions, substitute for specified session(s) only

**RULE-SUB-011**: Multiple Session Selection
- **Rule**: Participant can request substitution for multiple non-consecutive sessions
- **Example**: Substitute for Day 2 and Day 4, but attend Day 1, 3, 5 themselves
- **Implementation**: Create multiple `gantian` records with different `sesi_id`

**RULE-SUB-012**: Session Substitution Mutual Exclusivity
- **Rule**: For a given session, only ONE person can attend:
  - If substitute approved for session X, original participant CANNOT scan QR for session X
  - System rejects original participant's scan with message: "Anda telah digantikan oleh {wakil_nama} untuk sesi ini"

**RULE-SUB-013**: Chain Substitution Prohibited
- **Rule**: Substitute CANNOT be substituted by another person (no chain: A → B → C)
- **Validation**: If user is already `wakil_id` in `gantian` table for this event, they cannot request another substitution
- **Error**: "Wakil gantian tidak boleh digantikan oleh orang lain"

---

## 9. Attendance Calculation Rules

### 9.1 Single-Day Event Attendance

**RULE-CALC-001**: Single-Day Attendance Status
- **Rule**: For single-day events (`adalah_berbilang_hari = false`):
  - If `kehadiran_sesi` record exists: `peratus_kehadiran_dikira = 100%`
  - If no record: `peratus_kehadiran_dikira = 0%`
- **Binary**: Either attended (100%) or didn't attend (0%)

### 9.2 Multi-Day Event Attendance Calculation

**RULE-CALC-002**: Attendance Percentage Formula
- **Rule**: For multi-day events:
  ```
  peratus_kehadiran_dikira = (sesi_wajib_dihadiri ÷ jumlah_sesi_wajib) × 100
  ```
- **Example**:
  - Total mandatory sessions: 10
  - Attended: 8
  - Percentage: (8 ÷ 10) × 100 = 80%

**RULE-CALC-003**: Optional Sessions Exclusion
- **Rule**: Optional sessions (`adalah_wajib = false`):
  - NOT counted in attendance percentage calculation
  - BUT attendance adds to `jumlah_jam_latihan_acara`
- **Example**:
  - 8 mandatory sessions (attended 7)
  - 2 optional sessions (attended 1)
  - Percentage: (7 ÷ 8) × 100 = 87.5%
  - Training hours: (7 × 3) + (1 × 2) = 23 hours

**RULE-CALC-004**: Certificate Eligibility Thresholds
- **Rule**: Based on `acara.ambang_sijil_peratus` (default 80%):
  - `peratus_kehadiran >= ambang_sijil_peratus`: `status_kelayakan_sijil = 'penuh'`
  - `50% <= peratus_kehadiran < ambang_sijil_peratus`: `status_kelayakan_sijil = 'sebahagian'`
  - `peratus_kehadiran < 50%`: `status_kelayakan_sijil = 'tidak_layak'`

**RULE-CALC-005**: Calculation Trigger
- **Rule**: `kehadiran` record calculated:
  - After each session attendance recorded (incremental update)
  - Final calculation when event status changes to `selesai`
- **Performance**: Use database triggers or Laravel observers

### 9.3 Continuous Verification (Online Events)

**RULE-CALC-006**: Continuous Verification Percentage
- **Rule**: For online events with `pengesahan_berterusan_aktif = true`:
  ```
  peratus_pengesahan = (prompts answered ÷ total prompts) × 100
  ```
- **Example**: 3 prompts scheduled, user answered 2
  - `peratus_pengesahan = (2 ÷ 3) × 100 = 66.67%`

**RULE-CALC-007**: Continuous Verification Impact
- **Rule**: `peratus_pengesahan` stored in `kehadiran_sesi.peratus_pengesahan`
- **Impact**:
  - If `peratus_pengesahan < 75%` (default threshold): Mark as "Hadir Sebahagian"
  - Credit partial training hours: `jam_latihan_dikreditkan = sesi.jam_latihan_dikira × (peratus_pengesahan ÷ 100)`

**RULE-CALC-008**: Prompt Scheduling Algorithm
- **Rule**: For session duration `D` minutes, schedule `N` prompts:
  - `N = 2` if `D <= 120 minutes`
  - `N = 3` if `D > 120 minutes`
  - Prompts at random intervals: minimum 30 minutes apart
- **Example**: 180-minute session → 3 prompts at minutes 45, 95, 145

**RULE-CALC-009**: Missed Prompt Tolerance
- **Rule**: Allow 1 missed prompt (tolerance for technical issues)
  - If `(total_prompts - missed_prompts) ÷ total_prompts >= 0.67`: Still credit attendance
  - Else: Mark as absent
- **Example**: 3 prompts, missed 1 → (3-1)÷3 = 67% ✓ Still counts as attended

---

## 10. Certificate Generation Rules

### 10.1 Certificate Eligibility

**RULE-CERT-001**: Certificate Generation Trigger
- **Rule**: Certificate auto-generated when:
  - Event status changes to `selesai`
  - Participant's `status_kelayakan_sijil IN ('penuh', 'sebahagian')`
- **No Certificate**: If `status_kelayakan_sijil = 'tidak_layak'`

**RULE-CERT-002**: Certificate Types
- **Rule**: Three certificate types based on attendance:
  1. **`peserta_penuh`**: `peratus_kehadiran >= ambang_sijil_peratus` (default 80%)
     - Full certificate with all event details
  2. **`peserta_sebahagian`**: `50% <= peratus_kehadiran < ambang_sijil_peratus`
     - Partial certificate listing only attended sessions
     - JSON field `senarai_sesi_dihadiri_json` contains session list
  3. **`wakil_gantian`**: Substitute participant
     - Special certificate indicating substitute status
     - Lists only sessions attended as substitute

**RULE-CERT-003**: Verification QR Code
- **Rule**: Each certificate includes QR code for authenticity verification
- **QR Contains**: `https://daftar.kedah.gov.my/verify/{kod_pengesahan}`
- **Verification Page**: Shows certificate details and confirms authenticity
- **Kod Pengesahan**: 12-character alphanumeric (e.g., `CERT2026A1B2`)

**RULE-CERT-004**: Digital Signature
- **Rule**: Certificate PDF includes digital signature (optional feature for Phase 2)
- **Signer**: Department head or system (auto-sign)
- **Standard**: PDF/A-3 with embedded signature

### 10.2 Certificate Content Rules

**RULE-CERT-005**: Certificate Language
- **Rule**: Certificate generated in Bahasa Malaysia (primary)
- **Optional**: Bilingual (Malay + English) based on department preference
- **Template**: Customizable per department

**RULE-CERT-006**: Training Hours Display
- **Rule**: Certificate shows:
  - Total training hours: `kehadiran.jumlah_jam_latihan_acara`
  - Attendance percentage: `kehadiran.peratus_kehadiran_dikira`
  - Sessions attended: List from `senarai_sesi_dihadiri_json` (for partial certificates)

**RULE-CERT-007**: Certificate Issuer
- **Rule**: Certificate issued by:
  - Department name: `jabatan.nama_jabatan`
  - Department logo: `jabatan.logo_url`
  - Issued date: Event end date (`acara.tarikh_tamat`)

**RULE-CERT-008**: Certificate for Substitutes
- **Rule**: For substitutes (`adalah_wakil_gantian = true`):
  - Certificate name: Substitute's name (NOT original participant)
  - Annotation: "Mewakili {peserta_asal_nama}"
  - Training hours credited to substitute
  - Separate certificate type: `jenis_sijil = 'wakil_gantian'`

### 10.3 Certificate Storage & Access

**RULE-CERT-009**: PDF Storage Location
- **Rule**: Store certificate PDFs in:
  - MinIO/S3: `certificates/{year}/{month}/{certificate_id}.pdf`
  - URL saved in `sijil.url_pdf`
- **Retention**: Permanent (no auto-deletion)

**RULE-CERT-010**: Access Control
- **Rule**: Certificate accessible by:
  - Participant (owner) - can download anytime
  - Organizer (event creator) - can view/download all participants' certificates
  - Admin Jabatan - can access department certificates
  - Super Admin - full access
- **Link Sharing**: Public verification link allowed, but download link requires authentication

**RULE-CERT-011**: Certificate Regeneration
- **Rule**: Organizer/Admin can regenerate certificate if:
  - Attendance data corrected after event
  - Template updated
  - Error in certificate content
- **Logic**: Increment version number, keep old certificate archived

**RULE-CERT-012**: Certificate Revocation
- **Rule**: Admin can revoke certificate if:
  - Attendance found to be fraudulent
  - Duplicate certificate issued by mistake
- **Effect**: Mark as `revoked` in database, verification page shows "DIBATALKAN"

---

## 11. Training Hours Calculation Rules

### 11.1 Annual Training Hours Accumulation

**RULE-HOURS-001**: Accumulation Trigger
- **Rule**: Training hours added to `jam_latihan_tahunan` when:
  - Session attendance confirmed (`kehadiran_sesi.status_sah = true`)
  - Hours credited: `kehadiran_sesi.jam_latihan_dikreditkan`
- **Timing**: Accumulated immediately after check-in/check-out

**RULE-HOURS-002**: Category Breakdown
- **Rule**: Hours categorized by `acara.kategori_jam_latihan`:
  - `kursus_wajib` → `jam_kursus_wajib`
  - `kursus_sukarela` → `jam_kursus_sukarela`
  - `mesyuarat` → `jam_mesyuarat`
  - `bengkel` → `jam_bengkel`
  - `seminar` → `jam_seminar`
  - `latihan_khusus` → `jam_latihan_khusus`
- **Total**: `jumlah_jam = SUM(all categories)`

**RULE-HOURS-003**: Annual Reset
- **Rule**: Training hours reset on January 1st each year
- **Logic**: New record in `jam_latihan_tahunan` for new year
- **Historical Data**: Previous years' records retained permanently

**RULE-HOURS-004**: Annual Target
- **Rule**: Default target = 56 hours per year
- **Configurable**: Can be set per department or per grade
  - Example: N32-N44 = 56 hours, N48+ = 42 hours
- **Stored**: `jam_latihan_tahunan.sasaran_jam`

**RULE-HOURS-005**: Achievement Percentage
- **Rule**:
  ```
  peratus_pencapaian = (jumlah_jam ÷ sasaran_jam) × 100
  ```
- **Display**: Color-coded progress bar
  - Red: < 50%
  - Yellow: 50-79%
  - Green: 80-99%
  - Blue: >= 100%

### 11.2 Training Hours for Substitutes

**RULE-HOURS-006**: Credit to Substitute, Not Original
- **Rule**: For substitute attendance:
  - Training hours credited to `wakil_id` (substitute)
  - Original participant (`peserta_asal_id`) receives 0 hours
- **Rationale**: Only the person who actually attended should receive credit

**RULE-HOURS-007**: Per-Session Substitution Hours
- **Rule**: For per-session substitution:
  - Original participant: Credit hours for sessions they attended
  - Substitute: Credit hours for sessions they attended
  - Each person has separate `jam_latihan_tahunan` entry

### 11.3 LNPT Export

**RULE-HOURS-008**: LNPT Report Format
- **Rule**: "Penyata Jam Latihan Tahunan" exported in PDF/Excel with:
  - Header: Name, IC No., Employee No., Department, Year
  - Table: Event name, Date, Category, Hours, Certificate status
  - Footer: Total hours, Achievement percentage, Digital signature QR
- **Standard**: Format compliant with LNPT requirements (standardized across departments)

**RULE-HOURS-009**: Mid-Year Notification
- **Rule**: Automated notifications sent to staff:
  - Q2 (June 30): If < 25% of target → Warning
  - Q3 (Sep 30): If < 50% of target → Alert
  - Q4 (Nov 30): If < 75% of target → Urgent reminder
- **Notification**: Via email + in-app notification

---

## 12. RBAC & Permission Rules

### 12.1 Role Assignment Rules

**RULE-RBAC-001**: Default Role
- **Rule**: All new users assigned `peserta` role automatically
- **Logic**: On user creation in `pengguna_peranan` table with:
  - `peranan_id` = 9 (peserta)
  - `skop_jenis` = 'sendiri'
  - `status` = 'aktif'

**RULE-RBAC-002**: Multiple Roles
- **Rule**: Users can have multiple roles simultaneously
- **Permission Calculation**: UNION of all roles' permissions (most permissive wins)
- **Example**: User is both `penyelaras` and `auditor` → can create events AND view all data

**RULE-RBAC-003**: Role Hierarchy
- **Rule**: Roles ordered by `tahap_hierarki` (1 = highest):
  1. `super_admin` (1)
  2. `admin_negeri` (2)
  3. `admin_jabatan` (3)
  4. `penyelaras` (4)
  5. `pengerusi_acara` (5)
  6. `ketua_jabatan` (6)
  7. `pegawai_penilai` (7)
  8. `auditor` (8)
  9. `peserta` (9)
- **Usage**: Higher roles can manage lower roles

**RULE-RBAC-004**: Role Assignment Authority
- **Rule**: Who can assign roles:
  - `super_admin`: Can assign ANY role to anyone
  - `admin_negeri`: Can assign roles 3-9 (not super_admin or admin_negeri)
  - `admin_jabatan`: Can assign roles 4-9 within their department only
- **Validation**: Check assigner's `tahap_hierarki` < assignee's role `tahap_hierarki`

### 12.2 Scope Rules

**RULE-RBAC-005**: Department Scope
- **Rule**: For roles scoped to department (`skop_jenis = 'jabatan_tertentu'`):
  - User can only access resources where `jabatan_id = pengguna_peranan.skop_jabatan_id`
  - Applied via Laravel global query scopes
- **Example**: Admin Jabatan A cannot view events from Jabatan B

**RULE-RBAC-006**: State-Wide Scope
- **Rule**: For `skop_jenis = 'semua_negeri'`:
  - User can access ALL departments
  - Typically for `super_admin` and `admin_negeri`

**RULE-RBAC-007**: Self Scope
- **Rule**: For `skop_jenis = 'sendiri'`:
  - User can only access their own data
  - Default for `peserta` role

### 12.3 Temporal Role Rules

**RULE-RBAC-008**: Role Expiry
- **Rule**: If `tarikh_tamat` is set and `tarikh_tamat < NOW()`:
  - Automatically update `status = 'tamat_tempoh'`
  - Revoke permissions within 60 seconds (invalidate session)
- **Check Frequency**: On every API request via middleware

**RULE-RBAC-009**: Acting Role Duration
- **Rule**: For acting roles (`adalah_pemangku = true`):
  - Must have `tarikh_tamat` (cannot be permanent)
  - Must have `rujukan_surat_pelantikan` (official letter reference)
  - Maximum duration: 1 year (can be extended)

**RULE-RBAC-010**: Delegation Duration
- **Rule**: For delegations in `delegasi_peranan`:
  - `tarikh_tamat` is REQUIRED
  - Maximum delegation period: 90 days
  - Can be renewed before expiry

### 12.4 Permission Enforcement

**RULE-RBAC-011**: Permission Check Order
- **Rule**: Check permissions in this order:
  1. Resource-level ownership (`pemilikan_resource`)
  2. Role-based permissions (`peranan_kebenaran`)
  3. Deny by default (if no match, deny access)

**RULE-RBAC-012**: Auditor Read-Only Rule
- **Rule**: `auditor` role:
  - Has all `view_*` permissions
  - DENIED all `create`, `update`, `delete` permissions (hard-coded constraint)
  - Even if accidentally granted write permission, middleware blocks it

**RULE-RBAC-013**: Super Admin Bypass
- **Rule**: `super_admin` role bypasses ALL permission checks
- **Implementation**: `if (user.hasRole('super_admin')) { allow(); }`
- **Audit**: All super_admin actions logged in `audit_log`

### 12.5 Delegation Rules

**RULE-RBAC-014**: Delegation Approval
- **Rule**: Delegations require approval:
  - Low-level delegations (penyelaras → penyelaras): Same-level approval
  - High-level delegations: Requires Admin Jabatan approval
- **Status Flow**: `menunggu` → (approval) → `diluluskan` → `aktif`

**RULE-RBAC-015**: Partial Permission Delegation
- **Rule**: Delegator can delegate subset of their permissions:
  - `kebenaran_terpilih_json` = array of permission codes
  - If NULL, entire role is delegated
- **Example**: Delegate only `event.create` and `event.view_jabatan`, not full `penyelaras` role

---

## 13. Notification Rules

### 13.1 Email Notification Rules

**RULE-NOTIF-001**: Event Invitation Email
- **Rule**: Send invitation email within 5 minutes of adding participant
- **To**: `peserta_acara.pengguna.emel`
- **Content**:
  - Event details (name, date, time, location)
  - QR code image (for quick access)
  - Add to calendar link (.ics file)
- **Queue**: Use Laravel queue for bulk invitations

**RULE-NOTIF-002**: Reminder Schedule
- **Rule**: Automated reminders sent:
  - H-7 days: 9:00 AM (if event > 7 days away)
  - H-1 day: 9:00 AM
  - H-1 hour: 1 hour before `tarikh_mula`
- **Condition**: Only to participants with `status_jemputan = 'sah'`

**RULE-NOTIF-003**: Substitution Approval Email
- **Rule**: When substitution approved:
  - Email to substitute: "Anda telah diluluskan mewakili {peserta_asal} untuk {event}"
  - Email to original participant: "Permohonan gantian anda telah diluluskan"
- **Timing**: Immediate (within 1 minute)

**RULE-NOTIF-004**: Certificate Ready Email
- **Rule**: When certificate generated:
  - Email to participant with download link
  - Subject: "Sijil Kehadiran Anda Tersedia - {event_name}"
  - Link valid for 30 days (then requires login)

### 13.2 SMS Notification Rules (Optional)

**RULE-NOTIF-005**: SMS for Critical Actions
- **Rule**: Send SMS for:
  - Walk-in substitution request (to organizer) - urgent
  - H-1 hour reminder (to participants who haven't checked in)
- **Rate Limit**: Max 3 SMS per user per day (prevent spam)
- **Provider**: Macrokiosk or approved government SMS gateway

### 13.3 Push Notification Rules (Mobile App - Phase 2)

**RULE-NOTIF-006**: Push for Real-Time Events
- **Rule**: Push notifications for:
  - Substitution approval/rejection (immediate)
  - Continuous verification prompts (online events)
  - Low attendance alerts (to organizer during event)
- **Implementation**: Firebase Cloud Messaging (FCM)

---

## 14. Data Validation Rules

### 14.1 Input Validation

**RULE-VALID-001**: Malaysian IC Number Validation
- **Rule**: No. KP must:
  - Be exactly 12 digits
  - Match regex: `/^[0-9]{12}$/`
  - First 6 digits = valid date (YYMMDD format)
  - Digits 7-8 = valid state code (01-16)
- **Algorithm**: Validate date and state code
- **Example**: `900101-01-5678` → Valid (Born Jan 1, 1990, State 01)

**RULE-VALID-002**: Malaysian Phone Number Validation
- **Rule**: Phone number format:
  - Starts with `01` (mobile) or `0` + area code (landline)
  - 10-11 digits total
  - Regex: `/^01[0-9]{8,9}$/` (mobile) or `/^0[0-9]{8,9}$/` (landline)
- **Example**: `0123456789` (valid), `+60123456789` (convert to local format)

**RULE-VALID-003**: Email Validation
- **Rule**: Valid email format + government domain check
- **Regex**: `/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/`
- **Domain**: Must end with `.gov.my` for civil servants
- **Exception**: External consultants may use other domains with admin approval

**RULE-VALID-004**: Government Grade Validation
- **Rule**: `gred` must match valid government grade patterns:
  - N-series: N17, N22, N26, N29, N32, N36, N41, N44, N48, N52, N54
  - DG-series: DG41, DG44, DG48, DG52, DG54
  - Other: M, UD, S, C, etc.
- **Implementation**: Validate against reference table or enum

**RULE-VALID-005**: URL Validation (Meeting Links)
- **Rule**: `pautan_meeting_url` must be valid HTTPS URL
- **Allowed Domains**: `zoom.us`, `teams.microsoft.com`, `meet.google.com`
- **Regex**: `/^https:\/\/(zoom\.us|teams\.microsoft\.com|meet\.google\.com)\/.+$/`

### 14.2 Business Logic Validation

**RULE-VALID-006**: Date Range Validation
- **Rule**: Throughout system:
  - `end_date >= start_date`
  - Event dates must be in future (when creating)
  - Session dates within event date range
- **Error**: "Tarikh tamat mesti selepas atau sama dengan tarikh mula"

**RULE-VALID-007**: Numeric Range Validation
- **Rule**:
  - `radius_geo_meter`: 50 - 1000 meters
  - `ambang_sijil_peratus`: 50 - 100%
  - `jam_latihan_dikira`: 0.1 - 8.0 hours per session
  - `bilangan_check_in_rawak`: 2 - 5 prompts

**RULE-VALID-008**: Required Fields by Event Type
- **Rule**: Conditional required fields:
  - Physical event: `koordinat_lat`, `koordinat_lng`, `radius_geo_meter` required
  - Online event: `pautan_meeting_url` required
  - Hybrid event: ALL above fields required
  - Multi-day event: At least 1 session required

---

## 15. Audit & Compliance Rules

### 15.1 Audit Logging Rules

**RULE-AUDIT-001**: Critical Actions to Log
- **Rule**: Log ALL actions in `audit_log` for:
  - User CRUD (create, update, delete)
  - Role assignment/revocation
  - Event creation/cancellation
  - Attendance check-in/check-out
  - Substitution approval/rejection
  - Certificate generation/revocation
  - Permission changes
- **Fields**: `pengguna_id`, `tindakan`, `jenis_objek`, `id_objek`, `butiran_json`, `ip`, `masa`

**RULE-AUDIT-002**: Audit Log Retention
- **Rule**: Retain audit logs for minimum 7 years (government compliance)
- **Storage**: Archive logs older than 2 years to separate table/storage
- **Access**: Super Admin and Auditor roles only

**RULE-AUDIT-003**: PDPA Compliance
- **Rule**: Obtain user consent for:
  - Geolocation tracking
  - Email/SMS notifications
  - Data sharing with EPSM API
- **Consent**: Record in database with timestamp
- **Right to Erasure**: Allow users to request data deletion (PDPA requirement)

**RULE-AUDIT-004**: Sensitive Data Encryption
- **Rule**: Encrypt at rest:
  - `users.no_kp` (IC number)
  - `users.kata_laluan_hash` (already hashed)
  - `audit_log.butiran_json` (may contain PII)
- **Algorithm**: AES-256
- **Key Management**: Laravel encryption (APP_KEY)

**RULE-AUDIT-005**: Access Logging
- **Rule**: Log all access to sensitive data:
  - Who accessed which user's profile
  - Who downloaded which reports
  - Who viewed certificate details
- **Purpose**: Compliance with MyMIS and PDPA audit requirements

### 15.2 Data Retention Rules

**RULE-AUDIT-006**: Event Data Retention
- **Rule**: Retain event and attendance data permanently (historical record)
- **Soft Delete**: Use soft deletes for events (mark as deleted, don't physically remove)
- **Reason**: Government record-keeping requirements

**RULE-AUDIT-007**: Certificate Retention
- **Rule**: Certificates never deleted (permanent record for civil servants)
- **Storage**: Migrate old certificates to archival storage after 3 years

**RULE-AUDIT-008**: User Data Deletion
- **Rule**: When user leaves civil service:
  - Do NOT delete historical attendance/certificates
  - Mark `status_aktif = false`
  - Revoke all roles
  - Retain data for audit purposes
- **Exception**: User requests PDPA erasure (requires special approval)

---

## Summary: Critical Rules Quick Reference

### Top 20 Most Critical Rules

| ID | Rule | Impact |
|----|------|--------|
| **RULE-USER-001** | No. KP uniqueness | Data integrity |
| **RULE-AUTH-006** | Token revocation on role change (60s) | Security |
| **RULE-QR-003** | Dynamic QR rotation (30s) | Anti-fraud |
| **RULE-ATTEND-007** | Training hours with 80% attendance minimum | Fairness |
| **RULE-GEO-002** | Radius verification formula | Location integrity |
| **RULE-SUB-012** | Session mutual exclusivity (no double attendance) | Data integrity |
| **RULE-SUB-013** | No chain substitution | Fraud prevention |
| **RULE-CALC-002** | Attendance percentage formula | Certificate eligibility |
| **RULE-CERT-008** | Certificate to substitute, not original | Fairness |
| **RULE-HOURS-006** | Training hours to substitute only | Fairness |
| **RULE-RBAC-011** | Permission check order | Security |
| **RULE-RBAC-012** | Auditor read-only enforcement | Compliance |
| **RULE-RBAC-013** | Super Admin bypass | System stability |
| **RULE-VALID-001** | Malaysian IC validation | Data quality |
| **RULE-AUDIT-001** | Critical action logging | Compliance |
| **RULE-AUDIT-003** | PDPA consent | Legal compliance |
| **RULE-AUDIT-004** | Sensitive data encryption | Security |
| **EVENT-005** | Event status transition rules | Workflow integrity |
| **SESI-004** | Session date within event period | Data integrity |
| **NOTIF-003** | Substitution approval notification | User experience |

---

## Implementation Checklist

When implementing these rules, developers should:

- [ ] Implement validation at BOTH frontend and backend (never trust client)
- [ ] Use database constraints where possible (`CHECK`, `UNIQUE`, `FOREIGN KEY`)
- [ ] Create custom Laravel validation rules for complex business logic
- [ ] Use Laravel Policies for authorization checks
- [ ] Implement audit logging via Laravel Observers
- [ ] Write comprehensive unit tests for all calculation formulas
- [ ] Document edge cases and exceptions in code comments
- [ ] Create admin override mechanisms for exceptional cases (with audit log)
- [ ] Implement rate limiting for external APIs (EPSM)
- [ ] Set up monitoring alerts for rule violations

---

**End of Business Rules Document**

**Version**: 1.0
**Last Updated**: 2026-05-01
**Author**: Claude Code
**Status**: Reference for Development Team
