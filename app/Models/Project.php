<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;
    use SoftDeletes;

    const SEEKING = [
        [
            'label' => 'Readers',
            'name' => 'readers',
        ],
        [
            'label' => 'Feedback',
            'name' => 'feedback',
        ],
        [
            'label' => 'An Agent',
            'name' => 'agent',
        ],
    ];

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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_password_protected',
        'is_public',
        'is_seeking_agent',
        'is_seeking_feedback',
        'is_seeking_readers',
        'is_unlisted',
        'seeking_label',
        'visibility_label',
        'visibility_slug',
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
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
                'includeTrashed' => true,
            ],
        ];
    }

    /**
     * Format the project's seeking type.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function seekingLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => static::SEEKING[$this->seeking]['label'],
        );
    }

    /**
     * Format the project's visibility.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function visibilityLabel(): Attribute
    {
        return Attribute::make(
            get: function() {
                switch(true)
                {
                    case filled($this->password):
                        return 'Password-Protected';
                        break;
                    case filled($this->unlisted_at):
                        return 'Unlisted';
                        break;
                    default:
                        return 'Public';
                        break;
                }
            },
        );
    }

    /**
     * Get the project's visibility slug.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function visibilitySlug(): Attribute
    {
        return Attribute::make(
            get: function() {
                switch(true)
                {
                    case filled($this->password):
                        return 'password-protected';
                        break;
                    case filled($this->unlisted_at):
                        return 'unlisted';
                        break;
                    default:
                        return 'public';
                        break;
                }
            },
        );
    }

    /**
     * Whether the project is unlisted.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function isUnlisted(): Attribute
    {
        return Attribute::make(
            get: fn () => filled($this->unlisted_at),
        );
    }

    /**
     * Whether the project is password-protected.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function isPasswordProtected(): Attribute
    {
        return Attribute::make(
            get: fn () => filled($this->password),
        );
    }

    /**
     * Whether the project is public.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function isPublic(): Attribute
    {
        return Attribute::make(
            get: fn () => empty($this->unlisted_at) && empty($this->password),
        );
    }

    /**
     * Whether the project is seeking an agent.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function isSeekingAgent(): Attribute
    {
        return Attribute::make(
            get: function() {
                $seeking = collect(static::SEEKING)->search(function($item) {
                    return $item['name'] === 'agent';
                });

                return $this->seeking === $seeking;
            },
        );
    }

    /**
     * Whether the project is seeking feedbback.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function isSeekingFeedback(): Attribute
    {
        return Attribute::make(
            get: function() {
                $seeking = collect(static::SEEKING)->search(function($item) {
                    return $item['name'] === 'feedback';
                });

                return $this->seeking === $seeking;
            },
        );
    }

    /**
     * Whether the project is seeking readers.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function isSeekingReaders(): Attribute
    {
        return Attribute::make(
            get: function() {
                $seeking = collect(static::SEEKING)->search(function($item) {
                    return $item['name'] === 'readers';
                });

                return $this->seeking === $seeking;
            },
        );
    }
}
