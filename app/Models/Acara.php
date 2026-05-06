<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Acara (Event) Model
 *
 * @property string $id UUID primary key
 * @property string $no_rujukan Event reference number
 * @property string $tajuk Event title
 * @property string $kategori Category
 * @property string|null $penerangan Description
 * @property \Illuminate\Support\Carbon $tarikh_mula Start date & time
 * @property \Illuminate\Support\Carbon $tarikh_tamat End date & time
 * @property string|null $lokasi Physical location
 * @property string $jenis_acara Event type (fizikal/dalam_talian/hibrid)
 * @property int|null $kuota Max participants
 * @property string $status Status (draf/aktif/selesai/dibatalkan)
 * @property string $dicipta_oleh Event creator user ID
 * @property int $jabatan_id Organizing department ID
 * @property string|null $qr_token JWT token for QR code
 * @property string $qr_mod QR mode (statik/dinamik)
 * @property int $radius_geo_meter Geolocation radius in meters
 * @property float|null $koordinat_lat Latitude
 * @property float|null $koordinat_lng Longitude
 * @property string $mod_gantian Substitution mode
 * @property bool $pengesahan_berterusan_aktif Enable continuous verification
 * @property int $bilangan_check_in_rawak Random check-in count
 * @property float $ambang_kehadiran_sebahagian Partial attendance threshold %
 * @property string|null $pautan_meeting_url Online meeting URL
 * @property bool $adalah_berbilang_hari Multi-day event flag
 * @property float $ambang_sijil_peratus Certificate threshold %
 * @property string $kategori_jam_latihan Training hour category
 * @property bool $adalah_siri Recurring series flag
 * @property string|null $id_acara_induk_siri Parent series event ID
 */
class Acara extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'acara';

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
        'no_rujukan',
        'tajuk',
        'kategori',
        'penerangan',
        'tarikh_mula',
        'tarikh_tamat',
        'lokasi',
        'jenis_acara',
        'kuota',
        'status',
        'dicipta_oleh',
        'jabatan_id',
        'qr_token',
        'qr_mod',
        'radius_geo_meter',
        'koordinat_lat',
        'koordinat_lng',
        'mod_gantian',
        'pengesahan_berterusan_aktif',
        'bilangan_check_in_rawak',
        'ambang_kehadiran_sebahagian',
        'pautan_meeting_url',
        'adalah_berbilang_hari',
        'ambang_sijil_peratus',
        'kategori_jam_latihan',
        'adalah_siri',
        'id_acara_induk_siri',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tarikh_mula' => 'datetime',
        'tarikh_tamat' => 'datetime',
        'kuota' => 'integer',
        'radius_geo_meter' => 'integer',
        'koordinat_lat' => 'decimal:8',
        'koordinat_lng' => 'decimal:8',
        'pengesahan_berterusan_aktif' => 'boolean',
        'bilangan_check_in_rawak' => 'integer',
        'ambang_kehadiran_sebahagian' => 'decimal:2',
        'adalah_berbilang_hari' => 'boolean',
        'ambang_sijil_peratus' => 'decimal:2',
        'adalah_siri' => 'boolean',
    ];

    // Relationships

    /**
     * Get the user who created this event.
     */
    public function pencipta(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicipta_oleh');
    }

    /**
     * Get the organizing department.
     */
    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    /**
     * Get the parent series event.
     */
    public function acaraIndukSiri(): BelongsTo
    {
        return $this->belongsTo(Acara::class, 'id_acara_induk_siri');
    }

    /**
     * Get the child events in this series.
     */
    public function acaraSiri(): HasMany
    {
        return $this->hasMany(Acara::class, 'id_acara_induk_siri');
    }

    /**
     * Get the sessions for this event.
     */
    public function sesi(): HasMany
    {
        return $this->hasMany(Sesi::class, 'acara_id');
    }

    /**
     * Get the event participants.
     */
    public function peserta(): HasMany
    {
        return $this->hasMany(PesertaAcara::class, 'acara_id');
    }

    /**
     * Get the attendance summaries for this event.
     */
    public function kehadiran(): HasMany
    {
        return $this->hasMany(Kehadiran::class, 'acara_id');
    }

    /**
     * Get the substitutions for this event.
     */
    public function gantian(): HasMany
    {
        return $this->hasMany(Gantian::class, 'acara_id');
    }
}
