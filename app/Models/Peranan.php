<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Peranan (Role) Model
 *
 * @property int $id
 * @property string $kod_peranan Role code
 * @property string $nama_peranan Role display name
 * @property string|null $penerangan Role description
 * @property bool $adalah_lalai_sistem System default role
 * @property bool $boleh_dipadam Can be deleted
 * @property int $tahap_hierarki Hierarchy level
 * @property string|null $dicipta_oleh Creator user ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Peranan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'peranan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kod_peranan',
        'nama_peranan',
        'penerangan',
        'adalah_lalai_sistem',
        'boleh_dipadam',
        'tahap_hierarki',
        'dicipta_oleh',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'adalah_lalai_sistem' => 'boolean',
        'boleh_dipadam' => 'boolean',
        'tahap_hierarki' => 'integer',
    ];

    // Relationships

    /**
     * Get the user who created this role.
     */
    public function pencipta(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicipta_oleh');
    }

    /**
     * Get the permissions for this role.
     */
    public function kebenaran(): BelongsToMany
    {
        return $this->belongsToMany(Kebenaran::class, 'peranan_kebenaran', 'peranan_id', 'kebenaran_id')
            ->withTimestamps();
    }

    /**
     * Get the user role assignments.
     */
    public function penggunaPeranan(): HasMany
    {
        return $this->hasMany(PenggunaPeranan::class, 'peranan_id');
    }

    /**
     * Get the role delegations.
     */
    public function delegasi(): HasMany
    {
        return $this->hasMany(DelegasiPeranan::class, 'peranan_id');
    }
}
