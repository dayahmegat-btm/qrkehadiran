<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * AuditLog (System Audit Log) Model
 *
 * @property int $id Primary key (BIGINT)
 * @property string|null $pengguna_id Acting user ID (NULL for system actions)
 * @property string $tindakan Action type (create/update/delete/login/etc.)
 * @property string $jenis_objek Object type (event/user/role/etc.)
 * @property string|null $id_objek Object ID
 * @property array|null $butiran_json Action details (before/after values)
 * @property string|null $ip IP address
 * @property \Illuminate\Support\Carbon $masa Action timestamp
 */
class AuditLog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'audit_log';

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
        'tindakan',
        'jenis_objek',
        'id_objek',
        'butiran_json',
        'ip',
        'masa',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'butiran_json' => 'array',
        'masa' => 'datetime',
    ];

    // Relationships

    /**
     * Get the user who performed this action.
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }
}
