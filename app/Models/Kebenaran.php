<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Kebenaran (Permission) Model
 *
 * @property int $id
 * @property string $kod_kebenaran Permission code
 * @property string $nama_kebenaran Permission display name
 * @property string $kategori_modul Module category
 * @property string|null $penerangan Description
 * @property bool $adalah_sensitif Sensitive permission flag
 */
class Kebenaran extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kebenaran';

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
        'kod_kebenaran',
        'nama_kebenaran',
        'kategori_modul',
        'penerangan',
        'adalah_sensitif',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'adalah_sensitif' => 'boolean',
    ];

    // Relationships

    /**
     * Get the roles that have this permission.
     */
    public function peranan(): BelongsToMany
    {
        return $this->belongsToMany(Peranan::class, 'peranan_kebenaran', 'kebenaran_id', 'peranan_id')
            ->withTimestamps();
    }
}
