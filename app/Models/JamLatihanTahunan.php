<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * JamLatihanTahunan (Annual Training Hours) Model
 *
 * @property string $id UUID primary key
 * @property string $pengguna_id User ID
 * @property int $tahun Year (e.g., 2026)
 * @property float $jumlah_jam Total hours
 * @property float $jam_kursus_wajib Mandatory course hours
 * @property float $jam_kursus_sukarela Voluntary course hours
 * @property float $jam_mesyuarat Meeting hours
 * @property float $jam_bengkel Workshop hours
 * @property float $jam_seminar Seminar hours
 * @property float $jam_latihan_khusus Special training hours
 * @property float $sasaran_jam Annual target hours
 * @property float $peratus_pencapaian Achievement percentage
 * @property \Illuminate\Support\Carbon|null $dikemaskini_pada Last updated
 */
class JamLatihanTahunan extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jam_latihan_tahunan';

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
        'pengguna_id',
        'tahun',
        'jumlah_jam',
        'jam_kursus_wajib',
        'jam_kursus_sukarela',
        'jam_mesyuarat',
        'jam_bengkel',
        'jam_seminar',
        'jam_latihan_khusus',
        'sasaran_jam',
        'peratus_pencapaian',
        'dikemaskini_pada',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tahun' => 'integer',
        'jumlah_jam' => 'decimal:2',
        'jam_kursus_wajib' => 'decimal:2',
        'jam_kursus_sukarela' => 'decimal:2',
        'jam_mesyuarat' => 'decimal:2',
        'jam_bengkel' => 'decimal:2',
        'jam_seminar' => 'decimal:2',
        'jam_latihan_khusus' => 'decimal:2',
        'sasaran_jam' => 'decimal:2',
        'peratus_pencapaian' => 'decimal:2',
        'dikemaskini_pada' => 'datetime',
    ];

    // Relationships

    /**
     * Get the user for this training hours record.
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }
}
