# Entity Relationship Diagram (ERD)
# e-DAFTAR Kedah - QR Attendance System

## Overview

This ERD represents the complete database schema for the e-DAFTAR Kedah system, a QR-based attendance tracking system for Kedah state government civil servants.

## Core Entities

### 1. users (Pengguna)
**Primary User Table** - Stores civil servant profiles

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | UUID | PK | Unique identifier |
| no_kp | VARCHAR(12) | UNIQUE, NOT NULL | IC Number (12 digits) |
| no_pekerja | VARCHAR(50) | UNIQUE | Employee Number |
| nama | VARCHAR(255) | NOT NULL | Full name |
| emel | VARCHAR(255) | UNIQUE, NOT NULL | Official email |
| no_telefon | VARCHAR(20) | | Phone number |
| kata_laluan_hash | VARCHAR(255) | NOT NULL | Password hash |
| jabatan_id | INT | FK → jabatan.id | Department |
| jawatan | VARCHAR(100) | | Position/job title |
| gred | VARCHAR(20) | | Government grade (e.g., N32, N29) |
| peranan | VARCHAR(50) | | Primary role (display only) |
| status_aktif | BOOLEAN | DEFAULT TRUE | Active status |
| dicipta_pada | TIMESTAMP | | Created at |
| dikemaskini_pada | TIMESTAMP | | Updated at |

**Indexes**:
- PRIMARY: id
- UNIQUE: no_kp, no_pekerja, emel
- INDEX: jabatan_id, status_aktif

---

### 2. jabatan (Jabatan/Department)
**Organizational Units** - Government departments under Kedah state

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | INT | PK, AUTO_INCREMENT | Unique identifier |
| kod_jabatan | VARCHAR(20) | UNIQUE, NOT NULL | Department code |
| nama_jabatan | VARCHAR(255) | NOT NULL | Department name |
| ptj_induk | INT | FK → jabatan.id (self) | Parent department (nullable) |
| alamat | TEXT | | Address |
| logo_url | VARCHAR(500) | | Department logo URL |

**Indexes**:
- PRIMARY: id
- UNIQUE: kod_jabatan
- INDEX: ptj_induk

---

### 3. acara (Acara/Event)
**Event Master Table** - Courses, meetings, seminars, training sessions

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | UUID | PK | Unique identifier |
| no_rujukan | VARCHAR(50) | UNIQUE, NOT NULL | Event reference (e.g., KEDAH-2026-LATIH-0142) |
| tajuk | VARCHAR(500) | NOT NULL | Event title |
| kategori | VARCHAR(100) | NOT NULL | Category (kursus/mesyuarat/bengkel/seminar) |
| penerangan | TEXT | | Description |
| tarikh_mula | DATETIME | NOT NULL | Start date & time |
| tarikh_tamat | DATETIME | NOT NULL | End date & time |
| lokasi | VARCHAR(500) | | Physical location |
| jenis_acara | ENUM | NOT NULL | 'fizikal', 'dalam_talian', 'hibrid' |
| kuota | INT | | Max participants |
| status | ENUM | NOT NULL | 'draf', 'aktif', 'selesai', 'dibatalkan' |
| dicipta_oleh | UUID | FK → users.id | Event creator |
| jabatan_id | INT | FK → jabatan.id | Organizing department |
| qr_token | TEXT | | JWT token for QR code |
| qr_mod | ENUM | DEFAULT 'statik' | 'statik', 'dinamik' |
| radius_geo_meter | INT | DEFAULT 100 | Geolocation radius in meters |
| koordinat_lat | DECIMAL(10,8) | | Latitude |
| koordinat_lng | DECIMAL(11,8) | | Longitude |
| mod_gantian | ENUM | DEFAULT 'dengan_kelulusan' | 'tidak_dibenarkan', 'dengan_kelulusan', 'terbuka' |
| pengesahan_berterusan_aktif | BOOLEAN | DEFAULT FALSE | Enable continuous verification |
| bilangan_check_in_rawak | INT | DEFAULT 2 | Random check-in count (2-3) |
| ambang_kehadiran_sebahagian | DECIMAL(5,2) | DEFAULT 75.00 | Partial attendance threshold % |
| pautan_meeting_url | VARCHAR(1000) | | Online meeting URL (Zoom/Teams) |
| adalah_berbilang_hari | BOOLEAN | DEFAULT FALSE | Multi-day event flag |
| ambang_sijil_peratus | DECIMAL(5,2) | DEFAULT 80.00 | Certificate threshold % |
| kategori_jam_latihan | ENUM | NOT NULL | 'kursus_wajib', 'kursus_sukarela', 'mesyuarat', etc. |
| adalah_siri | BOOLEAN | DEFAULT FALSE | Recurring series flag |
| id_acara_induk_siri | UUID | FK → acara.id (self) | Parent series event ID |

**Indexes**:
- PRIMARY: id
- UNIQUE: no_rujukan
- INDEX: jabatan_id, dicipta_oleh, status, tarikh_mula, jenis_acara, adalah_berbilang_hari
- SPATIAL: koordinat (lat, lng)

---

### 4. sesi (Session)
**Event Sessions** - Individual sessions within multi-day events

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | UUID | PK | Unique identifier |
| acara_id | UUID | FK → acara.id, NOT NULL | Parent event |
| urutan_sesi | INT | NOT NULL | Session sequence (1, 2, 3...) |
| tajuk_sesi | VARCHAR(255) | NOT NULL | Session title (e.g., "Day 1 - Morning") |
| tarikh | DATE | NOT NULL | Session date |
| masa_mula | TIME | NOT NULL | Start time |
| masa_tamat | TIME | NOT NULL | End time |
| lokasi_sesi | VARCHAR(500) | | Session location (if different from event) |
| jam_latihan_dikira | DECIMAL(4,2) | NOT NULL | Calculated training hours |
| qr_token_sesi | TEXT | | Session-specific QR JWT token |
| qr_mod_sesi | ENUM | DEFAULT 'statik' | 'statik', 'dinamik' |
| adalah_wajib | BOOLEAN | DEFAULT TRUE | Mandatory session flag |
| tempoh_sah_imbas_sebelum_minit | INT | DEFAULT 30 | Valid scan period before (minutes) |
| tempoh_sah_imbas_selepas_minit | INT | DEFAULT 30 | Valid scan period after (minutes) |
| status_sesi | ENUM | DEFAULT 'akan_datang' | 'akan_datang', 'aktif', 'selesai', 'dibatalkan' |

**Indexes**:
- PRIMARY: id
- INDEX: acara_id, tarikh, status_sesi
- UNIQUE: (acara_id, urutan_sesi)

---

### 5. peserta_acara (Event Participant)
**Event Participants** - Junction table linking users to events with invitation status

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | UUID | PK | Unique identifier |
| acara_id | UUID | FK → acara.id, NOT NULL | Event |
| pengguna_id | UUID | FK → users.id, NOT NULL | Participant user |
| status_jemputan | ENUM | DEFAULT 'dijemput' | 'dijemput', 'sah', 'tolak', 'gantian' |
| kategori_kehadiran | ENUM | | 'fizikal', 'dalam_talian' (for hybrid events) |
| token_pautan_unik | VARCHAR(255) | UNIQUE | Unique attendance link token (online events) |
| tarikh_tamat_token | DATETIME | | Token expiry datetime |
| dicipta_pada | TIMESTAMP | | Created at |

**Indexes**:
- PRIMARY: id
- INDEX: acara_id, pengguna_id, status_jemputan
- UNIQUE: (acara_id, pengguna_id), token_pautan_unik

---

### 6. kehadiran_sesi (Session Attendance)
**Session Attendance Records** - Individual session check-ins

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | UUID | PK | Unique identifier |
| sesi_id | UUID | FK → sesi.id, NOT NULL | Session |
| pengguna_id | UUID | FK → users.id, NOT NULL | Attending user |
| peserta_acara_id | UUID | FK → peserta_acara.id, NOT NULL | Participant record |
| masa_daftar_masuk | TIMESTAMP | NOT NULL | Check-in timestamp |
| masa_daftar_keluar | TIMESTAMP | | Check-out timestamp |
| koordinat_imbas | POINT | | GPS coordinates (lat, lng) |
| alat_imbas | VARCHAR(255) | | Scanning device (user agent) |
| ip_imbas | VARCHAR(45) | | IP address |
| status_sah | BOOLEAN | DEFAULT TRUE | Valid attendance flag |
| kaedah_kehadiran | ENUM | NOT NULL | 'qr_fizikal', 'qr_skrin', 'pautan_unik', 'pengesahan_berterusan', 'api_meeting' |
| adalah_wakil_gantian | BOOLEAN | DEFAULT FALSE | Substitute participant flag |
| id_peserta_asal | UUID | FK → users.id | Original participant (if substitute) |
| jam_latihan_dikreditkan | DECIMAL(4,2) | NOT NULL | Training hours credited |
| peratus_pengesahan | DECIMAL(5,2) | DEFAULT 100.00 | Verification % (for continuous verification) |

**Indexes**:
- PRIMARY: id
- INDEX: sesi_id, pengguna_id, masa_daftar_masuk, adalah_wakil_gantian
- UNIQUE: (sesi_id, pengguna_id) -- one attendance per session per user
- SPATIAL: koordinat_imbas

---

### 7. kehadiran (Aggregate Attendance)
**Event-Level Attendance Summary** - Aggregated attendance for entire event

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | UUID | PK | Unique identifier |
| acara_id | UUID | FK → acara.id, NOT NULL | Event |
| pengguna_id | UUID | FK → users.id, NOT NULL | Participant user |
| jumlah_sesi_wajib | INT | NOT NULL | Total mandatory sessions |
| sesi_wajib_dihadiri | INT | NOT NULL | Mandatory sessions attended |
| peratus_kehadiran_dikira | DECIMAL(5,2) | NOT NULL | Calculated attendance % |
| jumlah_jam_latihan_acara | DECIMAL(5,2) | NOT NULL | Total training hours for event |
| status_kelayakan_sijil | ENUM | NOT NULL | 'penuh', 'sebahagian', 'tidak_layak' |
| tarikh_dikira | TIMESTAMP | | Calculation timestamp |

**Indexes**:
- PRIMARY: id
- INDEX: acara_id, pengguna_id, status_kelayakan_sijil
- UNIQUE: (acara_id, pengguna_id)

---

### 8. gantian (Substitution)
**Participant Substitutions** - Replacement participant requests and approvals

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | UUID | PK | Unique identifier |
| acara_id | UUID | FK → acara.id, NOT NULL | Event |
| sesi_id | UUID | FK → sesi.id | Session (NULL = entire event, populated = per-session) |
| peserta_asal_id | UUID | FK → users.id, NOT NULL | Original participant |
| wakil_id | UUID | FK → users.id, NOT NULL | Substitute participant |
| alasan | TEXT | NOT NULL | Reason for substitution |
| jenis_gantian | ENUM | NOT NULL | 'pra_acara', 'walk_in', 'auto_terbuka', 'per_sesi' |
| status | ENUM | DEFAULT 'menunggu' | 'menunggu', 'diluluskan', 'ditolak' |
| penyelaras_lulus_id | UUID | FK → users.id | Approving organizer |
| masa_permohonan | TIMESTAMP | NOT NULL | Request timestamp |
| masa_keputusan | TIMESTAMP | | Decision timestamp |
| ulasan_penyelaras | TEXT | | Organizer comments |

**Indexes**:
- PRIMARY: id
- INDEX: acara_id, sesi_id, peserta_asal_id, wakil_id, status

---

### 9. pengesahan_berterusan (Continuous Verification)
**Continuous Verification Check-ins** - Random verification prompts for long online sessions

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | UUID | PK | Unique identifier |
| kehadiran_sesi_id | UUID | FK → kehadiran_sesi.id, NOT NULL | Session attendance record |
| masa_dijadual | TIMESTAMP | NOT NULL | Scheduled prompt time |
| masa_dipaparkan | TIMESTAMP | | Displayed timestamp |
| masa_dijawab | TIMESTAMP | | Response timestamp |
| status | ENUM | DEFAULT 'belum_dipaparkan' | 'dijawab', 'terlepas', 'belum_dipaparkan' |

**Indexes**:
- PRIMARY: id
- INDEX: kehadiran_sesi_id, masa_dijadual, status

---

### 10. sijil (Certificate)
**Training Certificates** - Generated attendance certificates

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | UUID | PK | Unique identifier |
| kehadiran_id | UUID | FK → kehadiran.id, NOT NULL | Attendance summary record |
| url_pdf | VARCHAR(1000) | NOT NULL | PDF file URL |
| kod_pengesahan | VARCHAR(100) | UNIQUE, NOT NULL | Verification code (QR on certificate) |
| dijana_pada | TIMESTAMP | NOT NULL | Generated timestamp |
| status_kehadiran | ENUM | NOT NULL | 'penuh', 'sebahagian' |
| peratus_kehadiran | DECIMAL(5,2) | NOT NULL | Attendance percentage |
| jenis_sijil | ENUM | NOT NULL | 'peserta_penuh', 'peserta_sebahagian', 'wakil_gantian' |
| senarai_sesi_dihadiri_json | JSON | | List of attended sessions (for partial) |

**Indexes**:
- PRIMARY: id
- INDEX: kehadiran_id, dijana_pada
- UNIQUE: kod_pengesahan

---

### 11. jam_latihan_tahunan (Annual Training Hours)
**Annual Training Hours Summary** - Yearly aggregation of training hours per user

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | UUID | PK | Unique identifier |
| pengguna_id | UUID | FK → users.id, NOT NULL | User |
| tahun | INT | NOT NULL | Year (e.g., 2026) |
| jumlah_jam | DECIMAL(6,2) | DEFAULT 0 | Total hours |
| jam_kursus_wajib | DECIMAL(6,2) | DEFAULT 0 | Mandatory course hours |
| jam_kursus_sukarela | DECIMAL(6,2) | DEFAULT 0 | Voluntary course hours |
| jam_mesyuarat | DECIMAL(6,2) | DEFAULT 0 | Meeting hours |
| jam_bengkel | DECIMAL(6,2) | DEFAULT 0 | Workshop hours |
| jam_seminar | DECIMAL(6,2) | DEFAULT 0 | Seminar hours |
| jam_latihan_khusus | DECIMAL(6,2) | DEFAULT 0 | Special training hours |
| sasaran_jam | DECIMAL(5,2) | DEFAULT 56.00 | Annual target hours |
| peratus_pencapaian | DECIMAL(5,2) | DEFAULT 0 | Achievement percentage |
| dikemaskini_pada | TIMESTAMP | | Last updated |

**Indexes**:
- PRIMARY: id
- INDEX: pengguna_id, tahun
- UNIQUE: (pengguna_id, tahun)

**Note**: This can be implemented as a materialized view or regular table updated via triggers/jobs.

---

## RBAC (Role-Based Access Control) Entities

### 12. peranan (Role)
**System Roles** - Defines user roles in the system

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | INT | PK, AUTO_INCREMENT | Unique identifier |
| kod_peranan | VARCHAR(50) | UNIQUE, NOT NULL | Role code (e.g., 'super_admin', 'penyelaras') |
| nama_peranan | VARCHAR(100) | NOT NULL | Role display name |
| penerangan | TEXT | | Role description |
| adalah_lalai_sistem | BOOLEAN | DEFAULT FALSE | System default role (cannot delete) |
| boleh_dipadam | BOOLEAN | DEFAULT TRUE | Can be deleted flag |
| tahap_hierarki | INT | NOT NULL | Hierarchy level (for comparison) |
| dicipta_oleh | UUID | FK → users.id | Creator |
| dicipta_pada | TIMESTAMP | | Created at |
| dikemaskini_pada | TIMESTAMP | | Updated at |

**Indexes**:
- PRIMARY: id
- UNIQUE: kod_peranan
- INDEX: tahap_hierarki, adalah_lalai_sistem

**Default Roles**:
1. `super_admin` - Super Admin Negeri (State-wide admin)
2. `admin_negeri` - Pegawai Pentadbir Negeri (State administrator)
3. `admin_jabatan` - Pentadbir Jabatan (Department admin)
4. `penyelaras` - Penyelaras Latihan (Event organizer)
5. `pengerusi_acara` - Pengerusi Acara (Event chair)
6. `ketua_jabatan` - Ketua Jabatan / Pengarah (Department head)
7. `pegawai_penilai` - Pegawai Penilai (Evaluator)
8. `auditor` - Auditor Negeri (State auditor - read-only)
9. `peserta` - Peserta / Penjawat Awam (Participant - default)

---

### 13. kebenaran (Permission)
**System Permissions** - Granular permissions

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | INT | PK, AUTO_INCREMENT | Unique identifier |
| kod_kebenaran | VARCHAR(100) | UNIQUE, NOT NULL | Permission code (e.g., 'event.create', 'user.delete') |
| nama_kebenaran | VARCHAR(100) | NOT NULL | Permission display name |
| kategori_modul | VARCHAR(50) | NOT NULL | Module category (user/event/attendance/etc.) |
| penerangan | TEXT | | Description |
| adalah_sensitif | BOOLEAN | DEFAULT FALSE | Sensitive permission flag (for security reports) |

**Indexes**:
- PRIMARY: id
- UNIQUE: kod_kebenaran
- INDEX: kategori_modul, adalah_sensitif

**Permission Categories**:
- `user.*` - User management permissions
- `event.*` - Event management permissions
- `session.*` - Session management permissions
- `attendance.*` - Attendance management permissions
- `substitution.*` - Substitution management permissions
- `certificate.*` - Certificate management permissions
- `report.*` - Report access permissions
- `training_hours.*` - Training hours permissions
- `rbac.*` - Role/permission management permissions
- `system.*` - System configuration permissions

---

### 14. peranan_kebenaran (Role-Permission Pivot)
**Role-Permission Mapping** - Links roles to permissions

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| peranan_id | INT | FK → peranan.id, NOT NULL | Role |
| kebenaran_id | INT | FK → kebenaran.id, NOT NULL | Permission |
| dicipta_pada | TIMESTAMP | | Created at |

**Indexes**:
- PRIMARY: (peranan_id, kebenaran_id)
- INDEX: kebenaran_id

---

### 15. pengguna_peranan (User-Role Assignment)
**User Role Assignments** - Assigns roles to users with scope and temporal constraints

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | UUID | PK | Unique identifier |
| pengguna_id | UUID | FK → users.id, NOT NULL | User |
| peranan_id | INT | FK → peranan.id, NOT NULL | Role |
| skop_jenis | ENUM | NOT NULL | 'semua_negeri', 'jabatan_tertentu', 'sendiri' |
| skop_jabatan_id | INT | FK → jabatan.id | Department scope (NULL if state-wide) |
| tarikh_mula | DATE | NOT NULL | Start date |
| tarikh_tamat | DATE | | End date (NULL = permanent) |
| status | ENUM | DEFAULT 'aktif' | 'aktif', 'dicabut', 'tamat_tempoh' |
| adalah_pemangku | BOOLEAN | DEFAULT FALSE | Acting role flag |
| rujukan_surat_pelantikan | VARCHAR(255) | | Official appointment letter reference |
| dilantik_oleh | UUID | FK → users.id | Appointing user |
| dilantik_pada | TIMESTAMP | | Appointed at |
| sebab_pencabutan | TEXT | | Revocation reason |

**Indexes**:
- PRIMARY: id
- INDEX: pengguna_id, peranan_id, status, tarikh_tamat, skop_jabatan_id
- INDEX: (pengguna_id, status) -- active roles per user

---

### 16. delegasi_peranan (Role Delegation)
**Temporary Role Delegations** - Temporary delegation of roles/permissions

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | UUID | PK | Unique identifier |
| pemberi_id | UUID | FK → users.id, NOT NULL | Delegator user |
| penerima_id | UUID | FK → users.id, NOT NULL | Delegate user |
| peranan_id | INT | FK → peranan.id, NOT NULL | Delegated role |
| kebenaran_terpilih_json | JSON | | Subset of permissions (NULL = entire role) |
| tarikh_mula | DATE | NOT NULL | Start date |
| tarikh_tamat | DATE | NOT NULL | End date (required for delegations) |
| alasan | TEXT | NOT NULL | Delegation reason |
| status | ENUM | DEFAULT 'menunggu' | 'menunggu', 'diluluskan', 'ditolak', 'aktif', 'tamat_tempoh', 'dibatalkan' |
| penerima_kelulusan_id | UUID | FK → users.id | Approving user |
| masa_kelulusan | TIMESTAMP | | Approval timestamp |
| ulasan | TEXT | | Comments |

**Indexes**:
- PRIMARY: id
- INDEX: pemberi_id, penerima_id, peranan_id, status, tarikh_tamat

---

### 17. pemilikan_resource (Resource Ownership)
**Resource-Level Ownership** - Tracks resource-level permissions

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | UUID | PK | Unique identifier |
| pengguna_id | UUID | FK → users.id, NOT NULL | Owner user |
| jenis_resource | ENUM | NOT NULL | 'event', 'session', 'report' |
| resource_id | UUID | NOT NULL | Resource UUID |
| jenis_pemilikan | ENUM | NOT NULL | 'pencipta', 'penyelaras', 'pengerusi' |
| dicipta_pada | TIMESTAMP | | Created at |

**Indexes**:
- PRIMARY: id
- INDEX: pengguna_id, jenis_resource, resource_id
- UNIQUE: (pengguna_id, jenis_resource, resource_id, jenis_pemilikan)

**Note**: This enables resource-level permissions where users have specific permissions on individual resources (e.g., event creator has full control over their event, even if they don't have global event.update permission).

---

### 18. audit_log (Audit Trail)
**System Audit Log** - Complete audit trail of all critical actions

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PK, AUTO_INCREMENT | Unique identifier |
| pengguna_id | UUID | FK → users.id | Acting user (NULL for system actions) |
| tindakan | VARCHAR(100) | NOT NULL | Action type (create/update/delete/login/etc.) |
| jenis_objek | VARCHAR(50) | NOT NULL | Object type (event/user/role/etc.) |
| id_objek | VARCHAR(255) | | Object ID |
| butiran_json | JSON | | Action details (before/after values) |
| ip | VARCHAR(45) | | IP address |
| masa | TIMESTAMP | NOT NULL | Action timestamp |

**Indexes**:
- PRIMARY: id
- INDEX: pengguna_id, tindakan, jenis_objek, masa
- INDEX: (jenis_objek, id_objek) -- actions on specific object

---

## Entity Relationships

### User & Department Relationships

```
jabatan (1) ──┬──< (N) users
              │
              └──< (N) jabatan (self-referencing: ptj_induk)

users (1) ──< (N) acara (dicipta_oleh)

users (N) ──< pengguna_peranan >── (N) peranan
                    │
                    └── (1) jabatan (skop_jabatan_id)
```

### Event & Session Relationships

```
jabatan (1) ──< (N) acara

acara (1) ──┬──< (N) sesi
            │
            ├──< (N) peserta_acara ──> (1) users
            │
            ├──< (N) kehadiran ──> (1) users
            │
            ├──< (N) gantian
            │
            └──< (N) acara (self-referencing: id_acara_induk_siri)

sesi (1) ──┬──< (N) kehadiran_sesi ──> (1) users
           │
           └──< (N) gantian (per-session substitutions)
```

### Attendance Workflow

```
peserta_acara (1) ──< (N) kehadiran_sesi

kehadiran_sesi (1) ──┬──< (N) pengesahan_berterusan
                     │
                     └──> (1) sesi
                     └──> (1) users (pengguna_id)
                     └──> (1) users (id_peserta_asal, if substitute)

kehadiran (1) ──< (1) sijil
           └──> (1) acara
           └──> (1) users
```

### Substitution Flow

```
gantian ──> (1) acara
        ├──> (1) sesi (nullable)
        ├──> (1) users (peserta_asal_id)
        ├──> (1) users (wakil_id)
        └──> (1) users (penyelaras_lulus_id)
```

### Training Hours Tracking

```
users (1) ──< (N) jam_latihan_tahunan

kehadiran_sesi ──(triggers calculation)──> jam_latihan_tahunan
                                           (updated via jobs/triggers)
```

### RBAC Structure

```
users (N) ──< pengguna_peranan >── (N) peranan ──< peranan_kebenaran >── (N) kebenaran
                                        │
                                        └──< (N) delegasi_peranan ──> (1) users (pemberi)
                                                                   └──> (1) users (penerima)

users (1) ──< (N) pemilikan_resource (resource-level ownership)
```

### Audit & Compliance

```
users (1) ──< (N) audit_log

All critical tables ──(triggers)──> audit_log
```

---

## Data Model Notes

### Multi-Tenancy Implementation

The system implements **department-based multi-tenancy** through:

1. **Scope on User Roles**: `pengguna_peranan.skop_jabatan_id` restricts role scope to specific departments
2. **Query Scopes**: Laravel global scopes automatically filter queries by department based on user's active role
3. **Resource Ownership**: `pemilikan_resource` tracks ownership for fine-grained access control

### QR Code Security

QR codes are secured through:

1. **JWT Tokens**: `acara.qr_token` and `sesi.qr_token_sesi` contain signed JWT tokens
2. **Dynamic QR**: When `qr_mod = 'dinamik'`, tokens rotate every 30 seconds
3. **Geolocation**: `kehadiran_sesi.koordinat_imbas` validated against `acara.koordinat_lat/lng` with `radius_geo_meter`
4. **Unique Online Links**: `peserta_acara.token_pautan_unik` tied to user's IC number and session

### Attendance Calculation Logic

For **multi-day events**:

```
peratus_kehadiran_dikira = (sesi_wajib_dihadiri ÷ jumlah_sesi_wajib) × 100

status_kelayakan_sijil:
  - 'penuh': peratus >= ambang_sijil_peratus (default 80%)
  - 'sebahagian': 50% <= peratus < ambang_sijil_peratus
  - 'tidak_layak': peratus < 50%
```

Attendance is tracked at **two levels**:
1. **Session level**: `kehadiran_sesi` - raw check-in/check-out per session
2. **Event level**: `kehadiran` - aggregated calculation for entire event

### Training Hours Accumulation

Training hours are calculated as:

```sql
-- For each kehadiran_sesi record:
jam_latihan_dikreditkan = TIMESTAMPDIFF(HOUR, masa_daftar_masuk, masa_daftar_keluar)
                          OR sesi.jam_latihan_dikira (if check-out not required)

-- Accumulated annually in jam_latihan_tahunan by category:
UPDATE jam_latihan_tahunan
SET jam_kursus_wajib = SUM(kehadiran_sesi.jam_latihan_dikreditkan)
WHERE acara.kategori_jam_latihan = 'kursus_wajib'
  AND YEAR(kehadiran_sesi.masa_daftar_masuk) = current_year
```

### Substitute Participant Logic

When substitution is approved:

1. **Pre-event substitution**:
   - `peserta_acara.status_jemputan` for original participant → 'gantian'
   - New `peserta_acara` record created for substitute with status 'sah'

2. **Walk-in substitution**:
   - `kehadiran_sesi.adalah_wakil_gantian = TRUE`
   - `kehadiran_sesi.id_peserta_asal` points to original participant
   - Training hours credited to substitute (`kehadiran_sesi.pengguna_id`), NOT original participant

3. **Per-session substitution** (multi-day):
   - `gantian.sesi_id` is populated (not NULL)
   - Substitute can only scan QR for specified session(s)
   - Original participant remains valid for other sessions

### Certificate Types

Three certificate types based on attendance:

1. **`peserta_penuh`**: Attended >= threshold (default 80%)
   - Full certificate with total training hours

2. **`peserta_sebahagian`**: Attended 50-79%
   - Partial certificate listing attended sessions (`senarai_sesi_dihadiri_json`)

3. **`wakil_gantian`**: Substitute participant
   - Special certificate indicating substitute status
   - Lists only sessions attended by substitute

### Continuous Verification (Online Events)

For online events > 90 minutes with `pengesahan_berterusan_aktif = TRUE`:

1. System schedules 2-3 random prompts (`pengesahan_berterusan.masa_dijadual`)
2. Participants must respond within 3 minutes (configurable)
3. Failed verifications tracked: `status = 'terlepas'`
4. Partial attendance calculated:
   ```
   peratus_pengesahan = (prompts answered ÷ total prompts) × 100
   ```
5. Affects `kehadiran_sesi.peratus_pengesahan` and certificate eligibility

---

## Database Optimization & Indexing Strategy

### Primary Indexes

All tables use appropriate primary keys:
- **UUID**: `users`, `acara`, `sesi`, `kehadiran_sesi`, `kehadiran`, `gantian`, `sijil`, `jam_latihan_tahunan`, etc.
- **Auto-increment INT**: `jabatan`, `peranan`, `kebenaran`
- **BIGINT**: `audit_log` (high-volume table)

### Secondary Indexes

Critical indexes for performance:

1. **Foreign Key Indexes**: All FK columns indexed
2. **Status Indexes**: All `status` enum columns
3. **Date/Timestamp Indexes**: For reporting queries
4. **Composite Indexes**:
   - `(acara_id, urutan_sesi)` on `sesi`
   - `(sesi_id, pengguna_id)` on `kehadiran_sesi` (prevent duplicate scans)
   - `(pengguna_id, tahun)` on `jam_latihan_tahunan`
   - `(pengguna_id, status)` on `pengguna_peranan` (active roles lookup)

### Spatial Indexes

Geolocation validation:
- `koordinat` (lat, lng) on `acara` - SPATIAL INDEX
- `koordinat_imbas` POINT on `kehadiran_sesi` - SPATIAL INDEX

### Full-Text Indexes (Future)

For search functionality:
- `acara.tajuk`, `acara.penerangan`
- `users.nama`, `users.no_pekerja`

---

## Data Integrity Constraints

### Referential Integrity

All foreign keys use `ON DELETE` and `ON UPDATE` rules:

- `CASCADE`: When parent is deleted, children are deleted
  - `acara` → `sesi` (deleting event deletes sessions)
  - `sesi` → `kehadiran_sesi` (deleting session deletes attendance)

- `RESTRICT`: Prevent deletion if children exist
  - `users` → `acara.dicipta_oleh` (cannot delete user who created events)
  - `jabatan` → `users` (cannot delete department with users)

- `SET NULL`: Set to NULL when parent is deleted
  - `acara.id_acara_induk_siri` (deleting parent series sets children to standalone)

### Check Constraints

Business rule validation:

```sql
-- Event dates
CHECK (tarikh_tamat >= tarikh_mula)

-- Session times
CHECK (masa_tamat > masa_mula)

-- Percentages
CHECK (peratus_kehadiran_dikira BETWEEN 0 AND 100)
CHECK (ambang_sijil_peratus BETWEEN 50 AND 100)

-- Geolocation radius
CHECK (radius_geo_meter > 0)

-- Training hours
CHECK (jam_latihan_dikira >= 0)
```

### Unique Constraints

Business uniqueness:

- `users.no_kp` - IC number is unique identifier
- `acara.no_rujukan` - Event reference number
- `(acara_id, pengguna_id)` on `peserta_acara` - user invited once per event
- `(sesi_id, pengguna_id)` on `kehadiran_sesi` - one check-in per session
- `sijil.kod_pengesahan` - unique certificate verification code

---

## Database Size Estimations

### Assumptions
- 50,000 active users
- 6,000 events per year (500/month)
- Average 50 participants per event
- Average 3 sessions per multi-day event
- 10-year retention period

### Storage Estimates

| Table | Rows (Annual) | Size per Row | Annual Storage | 10-Year Storage |
|-------|---------------|--------------|----------------|-----------------|
| users | 50,000 | 1 KB | 50 MB | 50 MB |
| acara | 6,000 | 2 KB | 12 MB | 120 MB |
| sesi | 18,000 | 0.5 KB | 9 MB | 90 MB |
| peserta_acara | 300,000 | 0.3 KB | 90 MB | 900 MB |
| kehadiran_sesi | 900,000 | 0.5 KB | 450 MB | 4.5 GB |
| kehadiran | 300,000 | 0.3 KB | 90 MB | 900 MB |
| sijil | 250,000 | 0.5 KB | 125 MB | 1.25 GB |
| audit_log | 5,000,000 | 0.5 KB | 2.5 GB | 25 GB |
| **Total** | | | **~3.3 GB/year** | **~33 GB** |

**Note**: PDF certificates stored in MinIO/S3, not in database. Estimated 500 KB per certificate = 125 GB for 250K certificates/year.

---

## Migration & Seeding Strategy

### Migration Order

Due to foreign key dependencies, migrations must run in this order:

1. `jabatan` (no dependencies)
2. `users` (depends on jabatan)
3. `peranan`, `kebenaran` (no dependencies)
4. `peranan_kebenaran` (depends on peranan, kebenaran)
5. `pengguna_peranan` (depends on users, peranan, jabatan)
6. `acara` (depends on users, jabatan)
7. `sesi` (depends on acara)
8. `peserta_acara` (depends on acara, users)
9. `kehadiran_sesi` (depends on sesi, users, peserta_acara)
10. `pengesahan_berterusan` (depends on kehadiran_sesi)
11. `gantian` (depends on acara, sesi, users)
12. `kehadiran` (depends on acara, users)
13. `sijil` (depends on kehadiran)
14. `jam_latihan_tahunan` (depends on users)
15. `delegasi_peranan` (depends on users, peranan)
16. `pemilikan_resource` (depends on users)
17. `audit_log` (depends on users)

### Seed Data

Must seed in order:

1. **Jabatan**: Major departments under Kedah state government
2. **Peranan**: 9 default roles (super_admin through peserta)
3. **Kebenaran**: Permission set (~50-80 permissions across modules)
4. **Peranan_Kebenaran**: Role-permission matrix
5. **Users**: Super admin account + sample admin jabatan accounts
6. **Pengguna_Peranan**: Assign super_admin role to initial admin user

---

## Version History

| Version | Date | Changes | Author |
|---------|------|---------|--------|
| 1.0 | 2026-05-01 | Initial ERD based on PRD v1.4 | Claude Code |

---

**End of ERD Document**
