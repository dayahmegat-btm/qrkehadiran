<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Jabatan (Department) Model
 *
 * @property int $id
 * @property string $kod_jabatan Department code
 * @property string $nama_jabatan Department name
 * @property int|null $ptj_induk Parent department ID
 * @property string|null $alamat Address
 * @property string|null $logo_url Department logo URL
 */
class Jabatan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jabatan';

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
        'kod_jabatan',
        'nama_jabatan',
        'ptj_induk',
        'alamat',
        'logo_url',
    ];

    // Relationships

    /**
     * Get the parent department.
     */
    public function induk(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'ptj_induk');
    }

    /**
     * Get the child departments.
     */
    public function subJabatan(): HasMany
    {
        return $this->hasMany(Jabatan::class, 'ptj_induk');
    }

    /**
     * Get the users in this department.
     */
    public function pengguna(): HasMany
    {
        return $this->hasMany(User::class, 'jabatan_id');
    }

    /**
     * Get the events organized by this department.
     */
    public function acara(): HasMany
    {
        return $this->hasMany(Acara::class, 'jabatan_id');
    }

    /**
     * Get the role assignments scoped to this department.
     */
    public function penggunaPeranan(): HasMany
    {
        return $this->hasMany(PenggunaPeranan::class, 'skop_jabatan_id');
    }
}
