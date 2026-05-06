<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * PenggunaPeranan (User-Role Assignment) Model
 *
 * @property string $id UUID primary key
 * @property string $pengguna_id User ID
 * @property int $peranan_id Role ID
 * @property string $skop_jenis Scope type
 * @property int|null $skop_jabatan_id Department scope ID
 * @property \Illuminate\Support\Carbon $tarikh_mula Start date
 * @property \Illuminate\Support\Carbon|null $tarikh_tamat End date
 * @property string $status Status
 * @property bool $adalah_pemangku Acting role flag
 * @property string|null $rujukan_surat_pelantikan Appointment letter reference
 * @property string|null $dilantik_oleh Appointing user ID
 * @property \Illuminate\Support\Carbon|null $dilantik_pada Appointed at
 * @property string|null $sebab_pencabutan Revocation reason
 */
class PenggunaPeranan extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengguna_peranan';

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
        'peranan_id',
        'skop_jenis',
        'skop_jabatan_id',
        'tarikh_mula',
        'tarikh_tamat',
        'status',
        'adalah_pemangku',
        'rujukan_surat_pelantikan',
        'dilantik_oleh',
        'dilantik_pada',
        'sebab_pencabutan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tarikh_mula' => 'date',
        'tarikh_tamat' => 'date',
        'adalah_pemangku' => 'boolean',
        'dilantik_pada' => 'datetime',
    ];

    // Relationships

    /**
     * Get the user for this role assignment.
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    /**
     * Get the role for this assignment.
     */
    public function peranan(): BelongsTo
    {
        return $this->belongsTo(Peranan::class, 'peranan_id');
    }

    /**
     * Get the department scope for this role assignment.
     */
    public function skopJabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'skop_jabatan_id');
    }

    /**
     * Get the user who appointed this role.
     */
    public function pelantik(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dilantik_oleh');
    }
}
