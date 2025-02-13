<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Moderator extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'biography',
    ];

    /**
     * Get the program sessions associated with the moderator.
     */
    public function programSessions()
    {
        return $this->belongsToMany(ProgramSession::class, 'moderator_program_session');
    }

    /**
     * Get the moderator's avatar.
     */
    public function avatar()
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'photo');
    }
}
