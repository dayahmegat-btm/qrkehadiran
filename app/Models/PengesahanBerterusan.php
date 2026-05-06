<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * PengesahanBerterusan (Continuous Verification) Model
 *
 * @property string $id UUID primary key
 * @property string $kehadiran_sesi_id Session attendance record ID
 * @property \Illuminate\Support\Carbon $masa_dijadual Scheduled prompt time
 * @property \Illuminate\Support\Carbon|null $masa_dipaparkan Displayed timestamp
 * @property \Illuminate\Support\Carbon|null $masa_dijawab Response timestamp
 * @property string $status Status (dijawab/terlepas/belum_dipaparkan)
 */
class PengesahanBerterusan extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengesahan_berterusan';

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
        'kehadiran_sesi_id',
        'masa_dijadual',
        'masa_dipaparkan',
        'masa_dijawab',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'masa_dijadual' => 'datetime',
        'masa_dipaparkan' => 'datetime',
        'masa_dijawab' => 'datetime',
    ];

    // Relationships

    /**
     * Get the session attendance record.
     */
    public function kehadiranSesi(): BelongsTo
    {
        return $this->belongsTo(KehadiranSesi::class, 'kehadiran_sesi_id');
    }
}
