<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * DelegasiPeranan (Role Delegation) Model
 *
 * @property string $id UUID primary key
 * @property string $pemberi_id Delegator user ID
 * @property string $penerima_id Delegate user ID
 * @property int $peranan_id Delegated role ID
 * @property array|null $kebenaran_terpilih_json Subset of permissions
 * @property \Illuminate\Support\Carbon $tarikh_mula Start date
 * @property \Illuminate\Support\Carbon $tarikh_tamat End date
 * @property string $alasan Delegation reason
 * @property string $status Status
 * @property string|null $penerima_kelulusan_id Approving user ID
 * @property \Illuminate\Support\Carbon|null $masa_kelulusan Approval timestamp
 * @property string|null $ulasan Comments
 */
class DelegasiPeranan extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'delegasi_peranan';

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
        'pemberi_id',
        'penerima_id',
        'peranan_id',
        'kebenaran_terpilih_json',
        'tarikh_mula',
        'tarikh_tamat',
        'alasan',
        'status',
        'penerima_kelulusan_id',
        'masa_kelulusan',
        'ulasan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'kebenaran_terpilih_json' => 'array',
        'tarikh_mula' => 'date',
        'tarikh_tamat' => 'date',
        'masa_kelulusan' => 'datetime',
    ];

    // Relationships

    /**
     * Get the delegator user.
     */
    public function pemberi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pemberi_id');
    }

    /**
     * Get the delegate user.
     */
    public function penerima(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penerima_id');
    }

    /**
     * Get the delegated role.
     */
    public function peranan(): BelongsTo
    {
        return $this->belongsTo(Peranan::class, 'peranan_id');
    }

    /**
     * Get the approving user.
     */
    public function penerimaKelulusan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penerima_kelulusan_id');
    }
}
