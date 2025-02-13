<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramSession extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'date',
        'start_time',
        'end_time',
    ];

    /**
     * Get the session's moderators.
     */
    public function moderators()
    {
        return $this->belongsToMany(Moderator::class, 'moderator_program_session');
    }

    /**
     * Get the session's communications.
     */
    public function communications()
    {
        return $this->hasMany(Communication::class, 'program_session_id');
    }
}
