<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * PesertaAcara (Event Participant) Model
 *
 * @property string $id UUID primary key
 * @property string $acara_id Event ID
 * @property string $pengguna_id Participant user ID
 * @property string $status_jemputan Invitation status
 * @property string|null $kategori_kehadiran Attendance category (for hybrid events)
 * @property string|null $token_pautan_unik Unique attendance link token
 * @property \Illuminate\Support\Carbon|null $tarikh_tamat_token Token expiry datetime
 * @property \Illuminate\Support\Carbon|null $dicipta_pada
 */
class PesertaAcara extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'peserta_acara';

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
        'status_jemputan',
        'kategori_kehadiran',
        'token_pautan_unik',
        'tarikh_tamat_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tarikh_tamat_token' => 'datetime',
        'dicipta_pada' => 'datetime',
    ];

    /**
     * Get the name of the "created at" column.
     */
    public function getCreatedAtColumn(): string
    {
        return 'dicipta_pada';
    }

    /**
     * Get the name of the "updated at" column.
     */
    public function getUpdatedAtColumn(): ?string
    {
        return null;
    }

    // Relationships

    /**
     * Get the event for this participant.
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
     * Get the session attendance records for this participant.
     */
    public function kehadiranSesi(): HasMany
    {
        return $this->hasMany(KehadiranSesi::class, 'peserta_acara_id');
    }
}
