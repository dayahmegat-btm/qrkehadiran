<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * PemilikanResource (Resource Ownership) Model
 *
 * @property string $id UUID primary key
 * @property string $pengguna_id Owner user ID
 * @property string $jenis_resource Resource type
 * @property string $resource_id Resource UUID
 * @property string $jenis_pemilikan Ownership type
 * @property \Illuminate\Support\Carbon|null $dicipta_pada
 */
class PemilikanResource extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pemilikan_resource';

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
        'jenis_resource',
        'resource_id',
        'jenis_pemilikan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
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
     * Get the owner user.
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    /**
     * Get the related resource (polymorphic-like, but stored as UUID).
     * You'll need to manually handle this based on jenis_resource.
     */
    public function resource()
    {
        // This would typically use polymorphic relationships,
        // but since it's stored as UUID + type, you'll need
        // to manually query based on jenis_resource
        return match ($this->jenis_resource) {
            'event' => Acara::find($this->resource_id),
            'session' => Sesi::find($this->resource_id),
            default => null,
        };
    }
}
