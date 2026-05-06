<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Gantian (Substitution) Model
 *
 * @property string $id UUID primary key
 * @property string $acara_id Event ID
 * @property string|null $sesi_id Session ID (NULL = entire event, populated = per-session)
 * @property string $peserta_asal_id Original participant ID
 * @property string $wakil_id Substitute participant ID
 * @property string $alasan Reason for substitution
 * @property string $jenis_gantian Substitution type
 * @property string $status Status (menunggu/diluluskan/ditolak)
 * @property string|null $penyelaras_lulus_id Approving organizer ID
 * @property \Illuminate\Support\Carbon $masa_permohonan Request timestamp
 * @property \Illuminate\Support\Carbon|null $masa_keputusan Decision timestamp
 * @property string|null $ulasan_penyelaras Organizer comments
 */
class Gantian extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gantian';

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
        'sesi_id',
        'peserta_asal_id',
        'wakil_id',
        'alasan',
        'jenis_gantian',
        'status',
        'penyelaras_lulus_id',
        'masa_permohonan',
        'masa_keputusan',
        'ulasan_penyelaras',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'masa_permohonan' => 'datetime',
        'masa_keputusan' => 'datetime',
    ];

    // Relationships

    /**
     * Get the event for this substitution.
     */
    public function acara(): BelongsTo
    {
        return $this->belongsTo(Acara::class, 'acara_id');
    }

    /**
     * Get the session for this substitution (if per-session).
     */
    public function sesi(): BelongsTo
    {
        return $this->belongsTo(Sesi::class, 'sesi_id');
    }

    /**
     * Get the original participant.
     */
    public function pesertaAsal(): BelongsTo
    {
        return $this->belongsTo(User::class, 'peserta_asal_id');
    }

    /**
     * Get the substitute participant.
     */
    public function wakil(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wakil_id');
    }

    /**
     * Get the approving organizer.
     */
    public function penyelarasLulus(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penyelaras_lulus_id');
    }
}
