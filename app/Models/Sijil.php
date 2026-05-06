<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Sijil (Certificate) Model
 *
 * @property string $id UUID primary key
 * @property string $kehadiran_id Attendance summary record ID
 * @property string $url_pdf PDF file URL
 * @property string $kod_pengesahan Verification code (QR on certificate)
 * @property \Illuminate\Support\Carbon $dijana_pada Generated timestamp
 * @property string $status_kehadiran Attendance status (penuh/sebahagian)
 * @property float $peratus_kehadiran Attendance percentage
 * @property string $jenis_sijil Certificate type
 * @property array|null $senarai_sesi_dihadiri_json List of attended sessions
 */
class Sijil extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sijil';

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
        'kehadiran_id',
        'url_pdf',
        'kod_pengesahan',
        'dijana_pada',
        'status_kehadiran',
        'peratus_kehadiran',
        'jenis_sijil',
        'senarai_sesi_dihadiri_json',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dijana_pada' => 'datetime',
        'peratus_kehadiran' => 'decimal:2',
        'senarai_sesi_dihadiri_json' => 'array',
    ];

    // Relationships

    /**
     * Get the attendance summary record.
     */
    public function kehadiran(): BelongsTo
    {
        return $this->belongsTo(Kehadiran::class, 'kehadiran_id');
    }
}
