<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * User Model
 *
 * @property string $id UUID primary key
 * @property string $no_kp IC Number (12 digits)
 * @property string|null $no_pekerja Employee Number
 * @property string $nama Full name
 * @property string $emel Official email
 * @property string|null $no_telefon Phone number
 * @property string $kata_laluan_hash Password hash
 * @property int|null $jabatan_id Department ID
 * @property string|null $jawatan Position/job title
 * @property string|null $gred Government grade
 * @property string|null $peranan Primary role (display only)
 * @property bool $status_aktif Active status
 * @property bool $epsm_verified Verified with EPSM API
 * @property \Illuminate\Support\Carbon|null $epsm_last_synced_at Last EPSM sync timestamp
 * @property array|null $epsm_raw_data Raw EPSM API response
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, HasUuids, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

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
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_kp',
        'no_pekerja',
        'nama',
        'emel',
        'no_telefon',
        'kata_laluan_hash',
        'jabatan_id',
        'jawatan',
        'gred',
        'peranan',
        'status_aktif',
        'epsm_verified',
        'epsm_last_synced_at',
        'epsm_raw_data',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'kata_laluan_hash',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status_aktif' => 'boolean',
        'epsm_verified' => 'boolean',
        'epsm_last_synced_at' => 'datetime',
        'epsm_raw_data' => 'array',
    ];

    /**
     * Laravel Auth password column mapping
     */
    public function getAuthPassword()
    {
        return $this->kata_laluan_hash;
    }

    // Relationships

    /**
     * Get the department that the user belongs to.
     */
    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    /**
     * Get the events created by this user.
     */
    public function acaraDicipta(): HasMany
    {
        return $this->hasMany(Acara::class, 'dicipta_oleh');
    }

    /**
     * Get the user role assignments.
     */
    public function penggunaPeranan(): HasMany
    {
        return $this->hasMany(PenggunaPeranan::class, 'pengguna_id');
    }

    /**
     * Get the roles assigned to this user through pengguna_peranan.
     */
    public function peranan(): HasManyThrough
    {
        return $this->hasManyThrough(
            Peranan::class,
            PenggunaPeranan::class,
            'pengguna_id',
            'id',
            'id',
            'peranan_id'
        );
    }

    /**
     * Get delegations where user is the delegator.
     */
    public function delegasiDiberi(): HasMany
    {
        return $this->hasMany(DelegasiPeranan::class, 'pemberi_id');
    }

    /**
     * Get delegations where user is the delegate.
     */
    public function delegasiDiterima(): HasMany
    {
        return $this->hasMany(DelegasiPeranan::class, 'penerima_id');
    }

    /**
     * Get resource ownerships.
     */
    public function pemilikanResource(): HasMany
    {
        return $this->hasMany(PemilikanResource::class, 'pengguna_id');
    }

    /**
     * Get event participations.
     */
    public function pesertaAcara(): HasMany
    {
        return $this->hasMany(PesertaAcara::class, 'pengguna_id');
    }

    /**
     * Get session attendance records.
     */
    public function kehadiranSesi(): HasMany
    {
        return $this->hasMany(KehadiranSesi::class, 'pengguna_id');
    }

    /**
     * Get event attendance summaries.
     */
    public function kehadiran(): HasMany
    {
        return $this->hasMany(Kehadiran::class, 'pengguna_id');
    }

    /**
     * Get substitutions where user is the original participant.
     */
    public function gantianAsalPeserta(): HasMany
    {
        return $this->hasMany(Gantian::class, 'peserta_asal_id');
    }

    /**
     * Get substitutions where user is the substitute.
     */
    public function gantianWakil(): HasMany
    {
        return $this->hasMany(Gantian::class, 'wakil_id');
    }

    /**
     * Get annual training hours.
     */
    public function jamLatihanTahunan(): HasMany
    {
        return $this->hasMany(JamLatihanTahunan::class, 'pengguna_id');
    }

    /**
     * Get audit log entries for this user.
     */
    public function auditLog(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'pengguna_id');
    }
}
