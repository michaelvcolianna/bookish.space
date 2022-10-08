<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'seeking',
        'reader_type',
        'feedback_type',
        'genre',
        'word_count',
        'similar_works',
        'preview',
        'content_notices',
        'query_letter',
        'synopsis',
        'password',
        'unlisted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'unlisted_at' => 'datetime',
    ];

    // @todo Add Tag relationship

    // @todo Add Conversation relationship

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'handle' => [
                'source' => 'title',
                'onUpdate' => true,
                'includeTrashed' => true,
            ],
        ];
    }
}
