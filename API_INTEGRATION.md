# API Integration Specification
# e-DAFTAR Kedah - External API Integration

## 1. EPSM Staff Data API

### 1.1 Overview

The e-DAFTAR Kedah system integrates with the existing **EPSM (Kedah State Government)** API to auto-populate staff information during user registration and profile updates.

**API Purpose**: Retrieve civil servant profile data to reduce manual data entry and ensure data consistency across government systems.

### 1.2 API Endpoint Details

**Base URL**: `https://epsm.kedah.gov.my/api_kuarters.php`

**Method**: `GET`

**Authentication**: Query parameter with shared secret key

**Parameters**:
| Parameter | Type | Required | Description | Example |
|-----------|------|----------|-------------|---------|
| `secret_key` | string | Yes | Shared secret key for API access | `DigitalPKN2021` |
| `no_kp` | string | Yes | IC Number (12 digits) | `900101015678` |

**Full Request Example**:
```
GET https://epsm.kedah.gov.my/api_kuarters.php?secret_key=DigitalPKN2021&no_kp=900101015678
```

### 1.3 Expected Response Format

**Note**: The actual response format should be verified with EPSM system administrators. Below is the assumed format based on typical government APIs.

**Success Response (Staff Found)**:
```json
{
  "status": "success",
  "data": {
    "no_kp": "900101015678",
    "no_pekerja": "KEDAH12345",
    "nama": "AHMAD BIN ABDULLAH",
    "emel": "ahmad.abdullah@kedah.gov.my",
    "no_telefon": "0123456789",
    "jabatan": "Pejabat Setiausaha Kerajaan Negeri",
    "kod_jabatan": "SUK001",
    "jawatan": "Pegawai Tadbir",
    "gred": "N41",
    "ptj": "100001",
    "status_perkhidmatan": "aktif"
  }
}
```

**Not Found Response (Staff Not in System)**:
```json
{
  "status": "not_found",
  "message": "Tiada rekod dijumpai untuk No. KP ini"
}
```

**Error Response (Invalid Request)**:
```json
{
  "status": "error",
  "message": "Invalid secret key or missing parameters"
}
```

### 1.4 Response Field Mapping

Mapping EPSM API response to e-DAFTAR database fields:

| EPSM API Field | e-DAFTAR Field (`users` table) | Transformation |
|----------------|--------------------------------|----------------|
| `no_kp` | `no_kp` | Direct mapping |
| `no_pekerja` | `no_pekerja` | Direct mapping |
| `nama` | `nama` | Direct mapping (uppercase) |
| `emel` | `emel` | Direct mapping, validate email format |
| `no_telefon` | `no_telefon` | Direct mapping |
| `kod_jabatan` | `jabatan_id` | **Lookup** in `jabatan` table by `kod_jabatan` |
| `jawatan` | `jawatan` | Direct mapping |
| `gred` | `gred` | Direct mapping |
| - | `kata_laluan_hash` | **User sets** during registration |
| - | `peranan` | **Auto-assign** `peserta` role |
| - | `status_aktif` | Set to `true` if `status_perkhidmatan = 'aktif'` |

**Important**: If `kod_jabatan` from API does not exist in `jabatan` table, the system should:
1. Create a new department record (if Super Admin has enabled auto-department creation)
2. OR assign to a default "Jabatan Tidak Diketahui" department
3. OR require manual department selection by user

---

## 2. Integration Workflows

### 2.1 User Registration Flow (New User)

```
┌─────────────────────────────────────────────────────────────┐
│  User Registration Page                                      │
└─────────────────────────────────────────────────────────────┘
                          │
                          ▼
         ┌────────────────────────────────┐
         │ User enters No. KP             │
         │ (12 digits, validated)         │
         └────────────────┬───────────────┘
                          │
                          ▼
         ┌────────────────────────────────┐
         │ Check if No. KP exists in      │
         │ `users` table                  │
         └────────┬───────────────────────┘
                  │
        ┌─────────┴─────────┐
        │                   │
        ▼                   ▼
   [EXISTS]            [NOT EXISTS]
        │                   │
        │                   ▼
        │      ┌────────────────────────────────┐
        │      │ Call EPSM API:                 │
        │      │ GET /api_kuarters.php          │
        │      │ ?secret_key=xxx&no_kp=xxx      │
        │      └────────┬───────────────────────┘
        │               │
        │     ┌─────────┴─────────┐
        │     │                   │
        │     ▼                   ▼
        │ [SUCCESS]          [NOT FOUND / ERROR]
        │     │                   │
        │     ▼                   ▼
        │ ┌────────────────┐  ┌──────────────────────┐
        │ │ Auto-fill form │  │ Show manual form     │
        │ │ with API data: │  │ User fills:          │
        │ │ - Nama         │  │ - Nama               │
        │ │ - No. Pekerja  │  │ - No. Pekerja        │
        │ │ - Email        │  │ - Email              │
        │ │ - Phone        │  │ - Phone              │
        │ │ - Jabatan      │  │ - Jabatan (dropdown) │
        │ │ - Jawatan      │  │ - Jawatan            │
        │ │ - Gred         │  │ - Gred               │
        │ │ (Read-only or  │  │ (All editable)       │
        │ │  editable)     │  │                      │
        │ └────────┬───────┘  └──────────┬───────────┘
        │          │                     │
        │          └──────────┬──────────┘
        │                     │
        ▼                     ▼
   ┌────────────────────────────────────────┐
   │ User sets password & confirms          │
   └────────────────┬───────────────────────┘
                    │
                    ▼
   ┌────────────────────────────────────────┐
   │ Save to database:                      │
   │ - INSERT INTO users                    │
   │ - Auto-assign 'peserta' role           │
   │ - Send verification email              │
   └────────────────┬───────────────────────┘
                    │
                    ▼
   ┌────────────────────────────────────────┐
   │ Registration complete                  │
   │ Redirect to login or dashboard         │
   └────────────────────────────────────────┘
```

**Error exists message**:
```
"Akaun dengan No. KP ini telah wujud. Sila log masuk atau reset kata laluan anda."
(An account with this IC Number already exists. Please login or reset your password.)
```

### 2.2 Profile Update Flow (Existing User)

When an existing user updates their profile:

```
┌─────────────────────────────────────────────────────────────┐
│  User Profile Edit Page                                      │
└─────────────────────────────────────────────────────────────┘
                          │
                          ▼
         ┌────────────────────────────────┐
         │ Show current profile data      │
         │ Display "Sync with EPSM" button│
         └────────────────┬───────────────┘
                          │
                          ▼
         ┌────────────────────────────────┐
         │ User clicks "Sync with EPSM"   │
         └────────────────┬───────────────┘
                          │
                          ▼
         ┌────────────────────────────────┐
         │ Call EPSM API with user's No.KP│
         └────────┬───────────────────────┘
                  │
        ┌─────────┴─────────┐
        │                   │
        ▼                   ▼
   [SUCCESS]            [NOT FOUND]
        │                   │
        ▼                   ▼
   ┌────────────────┐  ┌──────────────────────┐
   │ Show comparison│  │ Show message:        │
   │ table:         │  │ "Tiada rekod dijumpai│
   │                │  │  dalam sistem EPSM.  │
   │ Current | API  │  │  Anda boleh kemaskini│
   │ --------|------│  │  profil secara manual"│
   │ Name A  |Name B│  │                      │
   │ Dept X  |Dept Y│  └──────────────────────┘
   │ ...     |...   │
   │                │
   │ [Update All]   │
   │ [Cancel]       │
   └────────┬───────┘
            │
            ▼
   ┌────────────────────────────────────────┐
   │ User confirms update                   │
   └────────────────┬───────────────────────┘
                    │
                    ▼
   ┌────────────────────────────────────────┐
   │ Update database (except password)      │
   │ Log change in audit_log                │
   └────────────────┬───────────────────────┘
                    │
                    ▼
   ┌────────────────────────────────────────┐
   │ Show success message                   │
   └────────────────────────────────────────┘
```

### 2.3 Bulk User Import Flow (Admin Jabatan)

When Admin Jabatan imports users via CSV:

```
┌─────────────────────────────────────────────────────────────┐
│  Admin uploads CSV with No. KP column                        │
└─────────────────────────────────────────────────────────────┘
                          │
                          ▼
         ┌────────────────────────────────┐
         │ System reads CSV file          │
         │ Validates format               │
         └────────────────┬───────────────┘
                          │
                          ▼
         ┌────────────────────────────────┐
         │ For each No. KP in CSV:        │
         │ - Call EPSM API                │
         │ - Collect results              │
         └────────────────┬───────────────┘
                          │
                          ▼
         ┌────────────────────────────────┐
         │ Show preview table:            │
         │                                │
         │ No.KP | Name | Status          │
         │ ------|------|-------          │
         │ 12345 | Ali  | ✓ Found in EPSM│
         │ 67890 | Abu  | ⚠ Not found    │
         │ ...   | ...  | ...             │
         │                                │
         │ [Import Found Users]           │
         │ [Download Failed List]         │
         └────────────────┬───────────────┘
                          │
                          ▼
         ┌────────────────────────────────┐
         │ Admin confirms import          │
         └────────────────┬───────────────┘
                          │
                          ▼
         ┌────────────────────────────────┐
         │ Bulk INSERT found users        │
         │ Generate temporary passwords   │
         │ Send welcome emails            │
         └────────────────┬───────────────┘
                          │
                          ▼
         ┌────────────────────────────────┐
         │ Show import summary:           │
         │ - 150 users imported           │
         │ - 20 users not found in EPSM   │
         │ - 5 users already exist        │
         └────────────────────────────────┘
```

---

## 3. Implementation Details

### 3.1 Laravel Service Class

Create a dedicated service class for EPSM API integration:

**File**: `app/Services/EpsmApiService.php`

```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class EpsmApiService
{
    private string $baseUrl;
    private string $secretKey;
    private int $timeout;
    private int $cacheMinutes;

    public function __construct()
    {
        $this->baseUrl = config('services.epsm.url');
        $this->secretKey = config('services.epsm.secret_key');
        $this->timeout = config('services.epsm.timeout', 10);
        $this->cacheMinutes = config('services.epsm.cache_minutes', 60);
    }

    /**
     * Fetch staff data by IC number (No. KP)
     *
     * @param string $noKp IC Number (12 digits)
     * @return array|null Returns staff data or null if not found
     * @throws \Exception on API error
     */
    public function getStaffByNoKp(string $noKp): ?array
    {
        // Validate No. KP format (12 digits)
        if (!preg_match('/^\d{12}$/', $noKp)) {
            throw new \InvalidArgumentException('No. KP mesti 12 digit');
        }

        // Check cache first (reduce API calls)
        $cacheKey = "epsm_staff_{$noKp}";

        if (Cache::has($cacheKey)) {
            Log::info("EPSM API: Cache hit for No. KP {$noKp}");
            return Cache::get($cacheKey);
        }

        try {
            Log::info("EPSM API: Fetching data for No. KP {$noKp}");

            $response = Http::timeout($this->timeout)
                ->get($this->baseUrl, [
                    'secret_key' => $this->secretKey,
                    'no_kp' => $noKp,
                ]);

            if (!$response->successful()) {
                Log::error("EPSM API: HTTP error {$response->status()}", [
                    'no_kp' => $noKp,
                    'body' => $response->body(),
                ]);
                throw new \Exception("EPSM API returned status {$response->status()}");
            }

            $data = $response->json();

            // Handle different response formats
            if (isset($data['status'])) {
                if ($data['status'] === 'success' && isset($data['data'])) {
                    // Cache successful result
                    Cache::put($cacheKey, $data['data'], now()->addMinutes($this->cacheMinutes));
                    return $data['data'];
                }

                if ($data['status'] === 'not_found') {
                    Log::info("EPSM API: No record found for No. KP {$noKp}");
                    // Cache not-found result for shorter duration to allow updates
                    Cache::put($cacheKey, null, now()->addMinutes(5));
                    return null;
                }

                if ($data['status'] === 'error') {
                    Log::error("EPSM API: Error response", ['message' => $data['message'] ?? 'Unknown error']);
                    throw new \Exception($data['message'] ?? 'EPSM API error');
                }
            }

            // Unexpected response format
            Log::warning("EPSM API: Unexpected response format", ['data' => $data]);
            return null;

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error("EPSM API: Connection failed for No. KP {$noKp}", [
                'error' => $e->getMessage()
            ]);
            throw new \Exception("Gagal menyambung ke sistem EPSM. Sila cuba sebentar lagi.");
        } catch (\Exception $e) {
            Log::error("EPSM API: Unexpected error", [
                'no_kp' => $noKp,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Bulk fetch staff data for multiple IC numbers
     *
     * @param array $noKpList Array of IC numbers
     * @return array ['found' => [...], 'not_found' => [...]]
     */
    public function bulkGetStaff(array $noKpList): array
    {
        $found = [];
        $notFound = [];

        foreach ($noKpList as $noKp) {
            try {
                $staffData = $this->getStaffByNoKp($noKp);

                if ($staffData !== null) {
                    $found[] = $staffData;
                } else {
                    $notFound[] = $noKp;
                }

                // Rate limiting: sleep 100ms between requests
                usleep(100000);

            } catch (\Exception $e) {
                Log::error("EPSM API: Bulk fetch failed for No. KP {$noKp}", [
                    'error' => $e->getMessage()
                ]);
                $notFound[] = $noKp;
            }
        }

        return [
            'found' => $found,
            'not_found' => $notFound,
        ];
    }

    /**
     * Clear cache for specific No. KP (force refresh)
     *
     * @param string $noKp
     * @return void
     */
    public function clearCache(string $noKp): void
    {
        Cache::forget("epsm_staff_{$noKp}");
    }
}
```

### 3.2 Configuration

**File**: `config/services.php`

Add EPSM configuration:

```php
return [
    // ... other services

    'epsm' => [
        'url' => env('EPSM_API_URL', 'https://epsm.kedah.gov.my/api_kuarters.php'),
        'secret_key' => env('EPSM_API_SECRET_KEY'),
        'timeout' => env('EPSM_API_TIMEOUT', 10), // seconds
        'cache_minutes' => env('EPSM_API_CACHE_MINUTES', 60),
    ],
];
```

**File**: `.env`

```ini
# EPSM API Configuration
EPSM_API_URL=https://epsm.kedah.gov.my/api_kuarters.php
EPSM_API_SECRET_KEY=DigitalPKN2021
EPSM_API_TIMEOUT=10
EPSM_API_CACHE_MINUTES=60
```

**SECURITY NOTE**: The secret key `DigitalPKN2021` should be stored in `.env` and NEVER committed to version control. Add to `.gitignore`.

### 3.3 Controller Usage Example

**File**: `app/Http/Controllers/Auth/RegisterController.php`

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\EpsmApiService;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    protected EpsmApiService $epsmApi;

    public function __construct(EpsmApiService $epsmApi)
    {
        $this->epsmApi = $epsmApi;
    }

    /**
     * Check if No. KP exists and fetch EPSM data
     *
     * POST /api/auth/check-nokp
     */
    public function checkNoKp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_kp' => 'required|digits:12',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No. KP mesti 12 digit',
                'errors' => $validator->errors(),
            ], 422);
        }

        $noKp = $request->no_kp;

        // Check if user already exists
        if (User::where('no_kp', $noKp)->exists()) {
            return response()->json([
                'status' => 'exists',
                'message' => 'Akaun dengan No. KP ini telah wujud. Sila log masuk.',
            ], 409);
        }

        // Fetch from EPSM API
        try {
            $epsmData = $this->epsmApi->getStaffByNoKp($noKp);

            if ($epsmData !== null) {
                // Map jabatan
                $jabatan = null;
                if (isset($epsmData['kod_jabatan'])) {
                    $jabatan = Jabatan::where('kod_jabatan', $epsmData['kod_jabatan'])->first();
                }

                return response()->json([
                    'status' => 'found',
                    'message' => 'Data dijumpai dalam sistem EPSM',
                    'data' => [
                        'no_kp' => $epsmData['no_kp'],
                        'no_pekerja' => $epsmData['no_pekerja'] ?? null,
                        'nama' => $epsmData['nama'] ?? null,
                        'emel' => $epsmData['emel'] ?? null,
                        'no_telefon' => $epsmData['no_telefon'] ?? null,
                        'jabatan_id' => $jabatan?->id,
                        'jabatan_nama' => $jabatan?->nama_jabatan ?? $epsmData['jabatan'] ?? null,
                        'jawatan' => $epsmData['jawatan'] ?? null,
                        'gred' => $epsmData['gred'] ?? null,
                    ],
                ], 200);
            } else {
                return response()->json([
                    'status' => 'not_found',
                    'message' => 'Tiada rekod dijumpai dalam sistem EPSM. Sila isi maklumat secara manual.',
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Register new user
     *
     * POST /api/auth/register
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_kp' => 'required|digits:12|unique:users,no_kp',
            'nama' => 'required|string|max:255',
            'emel' => 'required|email|unique:users,emel',
            'no_telefon' => 'nullable|string|max:20',
            'no_pekerja' => 'nullable|string|max:50|unique:users,no_pekerja',
            'jabatan_id' => 'required|exists:jabatan,id',
            'jawatan' => 'nullable|string|max:100',
            'gred' => 'nullable|string|max:20',
            'kata_laluan' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'no_kp' => $request->no_kp,
            'nama' => strtoupper($request->nama),
            'emel' => $request->emel,
            'no_telefon' => $request->no_telefon,
            'no_pekerja' => $request->no_pekerja,
            'jabatan_id' => $request->jabatan_id,
            'jawatan' => $request->jawatan,
            'gred' => $request->gred,
            'kata_laluan_hash' => Hash::make($request->kata_laluan),
            'peranan' => 'peserta', // Default role
            'status_aktif' => true,
        ]);

        // Assign default 'peserta' role via RBAC
        $user->assignRole('peserta');

        // TODO: Send verification email

        return response()->json([
            'status' => 'success',
            'message' => 'Pendaftaran berjaya. Sila log masuk.',
            'data' => [
                'user_id' => $user->id,
            ],
        ], 201);
    }
}
```

### 3.4 Frontend Integration (Vue.js Example)

**Registration Form Component**:

```vue
<template>
  <div class="registration-form">
    <h2>Pendaftaran Pengguna Baharu</h2>

    <!-- Step 1: Check No. KP -->
    <div v-if="step === 1">
      <label>No. Kad Pengenalan (No. KP)</label>
      <input
        v-model="noKp"
        type="text"
        maxlength="12"
        placeholder="Contoh: 900101015678"
        @input="noKpErrors = []"
      />
      <span v-if="noKpErrors.length" class="error">{{ noKpErrors[0] }}</span>

      <button @click="checkNoKp" :disabled="loading">
        {{ loading ? 'Menyemak...' : 'Semak & Teruskan' }}
      </button>
    </div>

    <!-- Step 2: Fill Profile -->
    <div v-if="step === 2">
      <div v-if="epsmDataFound" class="alert alert-success">
        ✓ Data dijumpai dalam sistem EPSM. Sila sahkan maklumat di bawah.
      </div>
      <div v-else class="alert alert-warning">
        ⚠ Tiada rekod dijumpai dalam sistem EPSM. Sila isi maklumat secara manual.
      </div>

      <form @submit.prevent="register">
        <div>
          <label>Nama Penuh *</label>
          <input v-model="form.nama" type="text" required />
        </div>

        <div>
          <label>No. Pekerja</label>
          <input v-model="form.no_pekerja" type="text" />
        </div>

        <div>
          <label>E-mel Rasmi *</label>
          <input v-model="form.emel" type="email" required />
        </div>

        <div>
          <label>No. Telefon</label>
          <input v-model="form.no_telefon" type="tel" />
        </div>

        <div>
          <label>Jabatan *</label>
          <select v-model="form.jabatan_id" required>
            <option value="">-- Pilih Jabatan --</option>
            <option v-for="jab in jabatanList" :key="jab.id" :value="jab.id">
              {{ jab.nama_jabatan }}
            </option>
          </select>
        </div>

        <div>
          <label>Jawatan</label>
          <input v-model="form.jawatan" type="text" />
        </div>

        <div>
          <label>Gred</label>
          <input v-model="form.gred" type="text" placeholder="Contoh: N32" />
        </div>

        <div>
          <label>Kata Laluan *</label>
          <input v-model="form.kata_laluan" type="password" required minlength="8" />
        </div>

        <div>
          <label>Sahkan Kata Laluan *</label>
          <input v-model="form.kata_laluan_confirmation" type="password" required />
        </div>

        <button type="submit" :disabled="loading">
          {{ loading ? 'Mendaftar...' : 'Daftar' }}
        </button>
        <button type="button" @click="step = 1">Kembali</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import axios from 'axios'

const step = ref(1)
const noKp = ref('')
const noKpErrors = ref([])
const epsmDataFound = ref(false)
const loading = ref(false)
const jabatanList = ref([])

const form = reactive({
  no_kp: '',
  nama: '',
  no_pekerja: '',
  emel: '',
  no_telefon: '',
  jabatan_id: '',
  jawatan: '',
  gred: '',
  kata_laluan: '',
  kata_laluan_confirmation: '',
})

// Check No. KP with EPSM API
const checkNoKp = async () => {
  noKpErrors.value = []

  if (!/^\d{12}$/.test(noKp.value)) {
    noKpErrors.value = ['No. KP mesti 12 digit']
    return
  }

  loading.value = true

  try {
    const response = await axios.post('/api/auth/check-nokp', { no_kp: noKp.value })

    if (response.data.status === 'exists') {
      noKpErrors.value = [response.data.message]
      return
    }

    form.no_kp = noKp.value

    if (response.data.status === 'found') {
      // Auto-fill from EPSM data
      epsmDataFound.value = true
      const data = response.data.data

      form.nama = data.nama || ''
      form.no_pekerja = data.no_pekerja || ''
      form.emel = data.emel || ''
      form.no_telefon = data.no_telefon || ''
      form.jabatan_id = data.jabatan_id || ''
      form.jawatan = data.jawatan || ''
      form.gred = data.gred || ''
    } else {
      // Not found in EPSM - manual entry
      epsmDataFound.value = false
    }

    // Load jabatan list
    await loadJabatanList()

    step.value = 2

  } catch (error) {
    if (error.response?.data?.message) {
      noKpErrors.value = [error.response.data.message]
    } else {
      noKpErrors.value = ['Ralat sistem. Sila cuba lagi.']
    }
  } finally {
    loading.value = false
  }
}

// Load department list
const loadJabatanList = async () => {
  try {
    const response = await axios.get('/api/jabatan')
    jabatanList.value = response.data.data
  } catch (error) {
    console.error('Failed to load jabatan list', error)
  }
}

// Register user
const register = async () => {
  loading.value = true

  try {
    const response = await axios.post('/api/auth/register', form)

    if (response.data.status === 'success') {
      alert('Pendaftaran berjaya! Sila log masuk.')
      window.location.href = '/login'
    }

  } catch (error) {
    if (error.response?.data?.errors) {
      alert('Terdapat ralat dalam borang. Sila semak semula.')
      console.error(error.response.data.errors)
    } else {
      alert('Pendaftaran gagal. Sila cuba lagi.')
    }
  } finally {
    loading.value = false
  }
}
</script>
```

---

## 4. Error Handling & Fallback Strategy

### 4.1 API Failure Scenarios

| Scenario | System Behavior |
|----------|-----------------|
| **EPSM API is down / timeout** | Show message: "Sistem EPSM tidak dapat dihubungi. Sila isi maklumat secara manual atau cuba lagi sebentar." |
| **Invalid secret key** | Log error, notify Super Admin via email/notification. Show generic error to user. |
| **Rate limiting / too many requests** | Implement exponential backoff. Queue bulk imports instead of real-time calls. |
| **Staff not found in EPSM** | Allow manual registration. Mark user record with `epsm_verified = false` flag. |
| **Partial data returned** | Use available data, require user to fill missing fields manually. |
| **Department code mismatch** | Create mapping table or allow admin to map EPSM dept codes to e-DAFTAR departments. |

### 4.2 Fallback Registration Flow

If EPSM API is unavailable for > 5 minutes (detected via health check):

1. System automatically switches to **manual registration mode**
2. Banner message displayed: "Pendaftaran automatik tidak tersedia. Sila isi borang secara manual."
3. All fields become editable text inputs
4. Admin receives notification to check EPSM API status
5. System retries API every 15 minutes until restored

### 4.3 Data Validation Rules

Even when EPSM data is available, validate:

| Field | Validation Rule |
|-------|----------------|
| `no_kp` | 12 digits, valid Malaysian IC format |
| `emel` | Valid email format, must end with `.gov.my` or approved domains |
| `no_telefon` | Malaysian phone format (01X-XXXXXXX) |
| `no_pekerja` | Alphanumeric, max 50 characters |
| `gred` | Valid government grade (N17-N54, DG41-DG54, etc.) - reference table |

---

## 5. Database Schema Updates

### 5.1 Add EPSM Tracking Fields to `users` Table

**Migration**: `database/migrations/2026_05_01_add_epsm_fields_to_users_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // EPSM integration tracking
            $table->boolean('epsm_verified')->default(false)
                  ->comment('Whether user data was verified with EPSM API');

            $table->timestamp('epsm_last_synced_at')->nullable()
                  ->comment('Last successful sync with EPSM API');

            $table->json('epsm_raw_data')->nullable()
                  ->comment('Raw EPSM API response for audit trail');

            // Index for filtering
            $table->index('epsm_verified');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['epsm_verified', 'epsm_last_synced_at', 'epsm_raw_data']);
        });
    }
};
```

### 5.2 Update ERD.md

Add new columns to `users` table documentation:

| Column | Type | Description |
|--------|------|-------------|
| `epsm_verified` | BOOLEAN | Whether user data was verified with EPSM API (default: false) |
| `epsm_last_synced_at` | TIMESTAMP | Last successful sync with EPSM API |
| `epsm_raw_data` | JSON | Raw EPSM API response for audit trail |

---

## 6. Testing Strategy

### 6.1 Unit Tests

**File**: `tests/Unit/EpsmApiServiceTest.php`

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\EpsmApiService;
use Illuminate\Support\Facades\Http;

class EpsmApiServiceTest extends TestCase
{
    public function test_get_staff_by_nokp_success()
    {
        Http::fake([
            'epsm.kedah.gov.my/*' => Http::response([
                'status' => 'success',
                'data' => [
                    'no_kp' => '900101015678',
                    'nama' => 'AHMAD BIN ABDULLAH',
                    'no_pekerja' => 'KEDAH12345',
                    'emel' => 'ahmad@kedah.gov.my',
                ],
            ], 200),
        ]);

        $service = new EpsmApiService();
        $result = $service->getStaffByNoKp('900101015678');

        $this->assertNotNull($result);
        $this->assertEquals('900101015678', $result['no_kp']);
        $this->assertEquals('AHMAD BIN ABDULLAH', $result['nama']);
    }

    public function test_get_staff_not_found()
    {
        Http::fake([
            'epsm.kedah.gov.my/*' => Http::response([
                'status' => 'not_found',
                'message' => 'Tiada rekod dijumpai',
            ], 200),
        ]);

        $service = new EpsmApiService();
        $result = $service->getStaffByNoKp('999999999999');

        $this->assertNull($result);
    }

    public function test_invalid_nokp_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $service = new EpsmApiService();
        $service->getStaffByNoKp('12345'); // Invalid format
    }
}
```

### 6.2 Integration Tests

Test scenarios:
1. ✓ User registers with No. KP found in EPSM
2. ✓ User registers with No. KP not in EPSM (manual entry)
3. ✓ User tries to register with existing No. KP (should fail)
4. ✓ EPSM API timeout handling
5. ✓ Invalid department code mapping
6. ✓ Bulk import with mixed results (some found, some not)

### 6.3 Manual Testing Checklist

- [ ] Test with valid No. KP from production EPSM system
- [ ] Test with invalid No. KP (not in EPSM)
- [ ] Test manual registration when API is down
- [ ] Test profile sync feature
- [ ] Test bulk import CSV
- [ ] Verify audit logging
- [ ] Test caching mechanism (2nd request should hit cache)
- [ ] Test department code mapping

---

## 7. Security Considerations

### 7.1 API Key Security

**DO:**
- ✅ Store `secret_key` in `.env` file (never in code)
- ✅ Add `.env` to `.gitignore`
- ✅ Use Laravel Vault/AWS Secrets Manager for production
- ✅ Rotate secret key periodically (coordinate with EPSM admin)
- ✅ Log all API calls with timestamps for audit

**DON'T:**
- ❌ Never commit secret key to Git
- ❌ Never expose secret key in frontend code
- ❌ Never log secret key value in plain text

### 7.2 Rate Limiting

Implement rate limiting to avoid overwhelming EPSM API:

```php
// In EpsmApiService
use Illuminate\Support\Facades\RateLimiter;

public function getStaffByNoKp(string $noKp): ?array
{
    $rateLimitKey = 'epsm_api';

    if (RateLimiter::tooManyAttempts($rateLimitKey, 60)) {
        $seconds = RateLimiter::availableIn($rateLimitKey);
        throw new \Exception("Terlalu banyak permintaan. Sila tunggu {$seconds} saat.");
    }

    RateLimiter::hit($rateLimitKey, 60); // 60 requests per minute max

    // ... rest of the code
}
```

### 7.3 Data Privacy

- Only fetch data from EPSM when user explicitly provides their No. KP
- Store raw EPSM response in encrypted JSON field for audit trail
- Comply with PDPA 2010 - obtain user consent for data processing
- Allow users to opt-out of EPSM sync (manual profile only)

---

## 8. Monitoring & Logging

### 8.1 Metrics to Track

Dashboard metrics for Super Admin:

| Metric | Description | Alert Threshold |
|--------|-------------|-----------------|
| **EPSM API Success Rate** | % of successful API calls | < 90% |
| **EPSM API Response Time** | Average response time (ms) | > 3000ms |
| **Users Registered via EPSM** | Count of users auto-filled | - |
| **Users Registered Manually** | Count of users not in EPSM | - |
| **API Errors (Last 24h)** | Count of API failures | > 10 |
| **Cache Hit Rate** | % of requests served from cache | < 50% |

### 8.2 Logging Standards

All EPSM API interactions should log:

```php
Log::channel('epsm')->info('EPSM API Call', [
    'no_kp' => $noKp,
    'action' => 'fetch_staff',
    'result' => 'success|not_found|error',
    'response_time_ms' => $responseTime,
    'cache_hit' => $cacheHit,
    'user_ip' => request()->ip(),
    'timestamp' => now(),
]);
```

Create dedicated log channel in `config/logging.php`:

```php
'epsm' => [
    'driver' => 'daily',
    'path' => storage_path('logs/epsm.log'),
    'level' => 'info',
    'days' => 90,
],
```

---

## 9. Future Enhancements

### 9.1 Planned Integrations (Phase 2)

1. **HRMIS Integration**: Full bidirectional sync with HRMIS for employee records
2. **Active Directory SSO**: Single Sign-On using LDAP/AD credentials
3. **Two-way Sync**: Push attendance records back to EPSM/HRMIS
4. **Webhook Support**: Real-time updates when staff data changes in EPSM

### 9.2 Enhancement Ideas

- **Auto-sync Scheduler**: Daily cron job to refresh all user profiles from EPSM
- **Conflict Resolution UI**: When EPSM data differs from local data, show diff and let user choose
- **Department Auto-creation**: Automatically create new departments when new dept codes appear in EPSM
- **Photo Sync**: If EPSM provides staff photos, sync to user profile picture

---

## 10. Support & Troubleshooting

### 10.1 Common Issues

**Issue**: "Gagal menyambung ke sistem EPSM"

**Causes**:
- EPSM server is down
- Network firewall blocking requests
- SSL certificate issues

**Solution**:
1. Check EPSM API status: `curl -I https://epsm.kedah.gov.my/api_kuarters.php`
2. Verify secret key is correct
3. Check Laravel logs: `storage/logs/epsm.log`
4. Contact EPSM administrator

---

**Issue**: "No. KP dijumpai tetapi jabatan tidak wujud"

**Cause**: Department code from EPSM doesn't exist in e-DAFTAR `jabatan` table

**Solution**:
1. Check `epsm_raw_data` field to see original dept code
2. Create department manually or map to existing department
3. Update user's `jabatan_id`

---

**Issue**: Cache showing outdated data

**Solution**:
```bash
# Clear EPSM cache via artisan command
php artisan cache:forget "epsm_staff_{NO_KP}"

# Or clear all EPSM cache
php artisan cache:tags epsm:clear
```

### 10.2 Admin Commands

Create artisan commands for common operations:

```bash
# Sync specific user with EPSM
php artisan epsm:sync-user {no_kp}

# Bulk sync all users (scheduled daily)
php artisan epsm:sync-all

# Check EPSM API health
php artisan epsm:health-check

# Clear EPSM cache
php artisan epsm:cache-clear
```

---

**Document Version**: 1.0
**Last Updated**: 2026-05-01
**Author**: Claude Code
**Status**: Draft for Review
