<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * KehadiranSesi (Session Attendance) Model
 *
 * @property string $id UUID primary key
 * @property string $sesi_id Session ID
 * @property string $pengguna_id Attending user ID
 * @property string $peserta_acara_id Participant record ID
 * @property \Illuminate\Support\Carbon $masa_daftar_masuk Check-in timestamp
 * @property \Illuminate\Support\Carbon|null $masa_daftar_keluar Check-out timestamp
 * @property string|null $koordinat_imbas GPS coordinates (lat, lng) as POINT
 * @property string|null $alat_imbas Scanning device (user agent)
 * @property string|null $ip_imbas IP address
 * @property bool $status_sah Valid attendance flag
 * @property string $kaedah_kehadiran Attendance method
 * @property bool $adalah_wakil_gantian Substitute participant flag
 * @property string|null $id_peserta_asal Original participant ID (if substitute)
 * @property float $jam_latihan_dikreditkan Training hours credited
 * @property float $peratus_pengesahan Verification % (for continuous verification)
 */
class KehadiranSesi extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kehadiran_sesi';

    /**
     * The primary key type.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sesi_id',
        'pengguna_id',
        'peserta_acara_id',
        'masa_daftar_masuk',
        'masa_daftar_keluar',
        'koordinat_imbas',
        'alat_imbas',
        'ip_imbas',
        'status_sah',
        'kaedah_kehadiran',
        'adalah_wakil_gantian',
        'id_peserta_asal',
        'jam_latihan_dikreditkan',
        'peratus_pengesahan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'masa_daftar_masuk' => 'datetime',
        'masa_daftar_keluar' => 'datetime',
        'status_sah' => 'boolean',
        'adalah_wakil_gantian' => 'boolean',
        'jam_latihan_dikreditkan' => 'decimal:2',
        'peratus_pengesahan' => 'decimal:2',
    ];

    // Relationships

    /**
     * Get the session for this attendance.
     */
    public function sesi(): BelongsTo
    {
        return $this->belongsTo(Sesi::class, 'sesi_id');
    }

    /**
     * Get the attending user.
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    /**
     * Get the participant record.
     */
    public function pesertaAcara(): BelongsTo
    {
        return $this->belongsTo(PesertaAcara::class, 'peserta_acara_id');
    }

    /**
     * Get the original participant (if this is a substitute).
     */
    public function pesertaAsal(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_peserta_asal');
    }

    /**
     * Get the continuous verification records.
     */
    public function pengesahanBerterusan(): HasMany
    {
        return $this->hasMany(PengesahanBerterusan::class, 'kehadiran_sesi_id');
    }
}
