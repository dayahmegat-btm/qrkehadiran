<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Kehadiran (Event-Level Attendance Summary) Model
 *
 * @property string $id UUID primary key
 * @property string $acara_id Event ID
 * @property string $pengguna_id Participant user ID
 * @property int $jumlah_sesi_wajib Total mandatory sessions
 * @property int $sesi_wajib_dihadiri Mandatory sessions attended
 * @property float $peratus_kehadiran_dikira Calculated attendance %
 * @property float $jumlah_jam_latihan_acara Total training hours for event
 * @property string $status_kelayakan_sijil Certificate eligibility status
 * @property \Illuminate\Support\Carbon|null $tarikh_dikira Calculation timestamp
 */
class Kehadiran extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kehadiran';

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
        'pengguna_id',
        'jumlah_sesi_wajib',
        'sesi_wajib_dihadiri',
        'peratus_kehadiran_dikira',
        'jumlah_jam_latihan_acara',
        'status_kelayakan_sijil',
        'tarikh_dikira',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'jumlah_sesi_wajib' => 'integer',
        'sesi_wajib_dihadiri' => 'integer',
        'peratus_kehadiran_dikira' => 'decimal:2',
        'jumlah_jam_latihan_acara' => 'decimal:2',
        'tarikh_dikira' => 'datetime',
    ];

    // Relationships

    /**
     * Get the event for this attendance summary.
     */
    public function acara(): BelongsTo
    {
        return $this->belongsTo(Acara::class, 'acara_id');
    }

    /**
     * Get the user (participant).
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    /**
     * Get the certificate for this attendance.
     */
    public function sijil(): HasOne
    {
        return $this->hasOne(Sijil::class, 'kehadiran_id');
    }
}
