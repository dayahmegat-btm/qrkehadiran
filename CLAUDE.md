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
- How to set up the development environment
- How to run the application locally
- How to run tests
- How to build for production
- Database migration commands
- How to generate QR codes
- How to test push notifications
- How to import users via CSV

## Reference Documents

- **Primary Requirements**: `PRD_eDaftar_Kedah_3.md` - Comprehensive PRD in Bahasa Malaysia (v1.4, dated May 1, 2026)
  - Contains detailed user flows (sections 8.1-8.11)
  - Contains functional requirements (section 9)
  - Contains non-functional requirements (section 10)
  - Contains UI/UX wireframes (section 11)
  - Contains deployment architecture (section 12)
  - Contains security requirements (section 13)

## Future Phases (Out of Scope for v1.0)

- Financial management/allowance claims integration
- Learning Management System (LMS) features
- Performance evaluation (quizzes, tests)
- HRMIS integration (planned for Phase 3)
