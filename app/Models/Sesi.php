<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Sesi (Session) Model
 *
 * @property string $id UUID primary key
 * @property string $acara_id Parent event ID
 * @property int $urutan_sesi Session sequence
 * @property string $tajuk_sesi Session title
 * @property \Illuminate\Support\Carbon $tarikh Session date
 * @property string $masa_mula Start time
 * @property string $masa_tamat End time
 * @property string|null $lokasi_sesi Session location
 * @property float $jam_latihan_dikira Calculated training hours
 * @property string|null $qr_token_sesi Session-specific QR JWT token
 * @property string $qr_mod_sesi QR mode (statik/dinamik)
 * @property bool $adalah_wajib Mandatory session flag
 * @property int $tempoh_sah_imbas_sebelum_minit Valid scan period before (minutes)
 * @property int $tempoh_sah_imbas_selepas_minit Valid scan period after (minutes)
 * @property string $status_sesi Status (akan_datang/aktif/selesai/dibatalkan)
 */
class Sesi extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sesi';

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
        'acara_id',
        'urutan_sesi',
        'tajuk_sesi',
        'tarikh',
        'masa_mula',
        'masa_tamat',
        'lokasi_sesi',
        'jam_latihan_dikira',
        'qr_token_sesi',
        'qr_mod_sesi',
        'adalah_wajib',
        'tempoh_sah_imbas_sebelum_minit',
        'tempoh_sah_imbas_selepas_minit',
        'status_sesi',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tarikh' => 'date',
        'jam_latihan_dikira' => 'decimal:2',
        'adalah_wajib' => 'boolean',
        'tempoh_sah_imbas_sebelum_minit' => 'integer',
        'tempoh_sah_imbas_selepas_minit' => 'integer',
    ];

    // Relationships

    /**
     * Get the parent event.
     */
    public function acara(): BelongsTo
    {
        return $this->belongsTo(Acara::class, 'acara_id');
    }

    /**
     * Get the session attendance records.
     */
    public function kehadiranSesi(): HasMany
    {
        return $this->hasMany(KehadiranSesi::class, 'sesi_id');
    }

    /**
     * Get the substitutions for this session.
     */
    public function gantian(): HasMany
    {
        return $this->hasMany(Gantian::class, 'sesi_id');
    }
}
