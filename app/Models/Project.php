<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use Sluggable;
    use SoftDeletes;

    const FEEDBACK = [
        'positivity-pass' => 'Positivity Pass',
        'critique' => 'Critique',
        'editorial' => 'Editorial',
    ];

    const SEEKING = [
        'readers' => 'Readers',
        'feedback' => 'Feedback',
        'agent' => 'An Agent',
    ];

    const STATUS = [
        'public' => 'Public',
        'unlisted' => 'Unlisted',
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
        'content_link',
        'feedback_type',
        'genre',
        'word_count',
        'similar_works',
        'target_audience',
        'preview',
        'content_notices',
        'query_letter',
        'synopsis',
        'unlisted_at',
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
        'feedback_label',
        'seeking_label',
        'visibility',
        'visibility_label',
    ];

    /**
     * Get the user that owns the project.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
     * Get the project's seeking label.
     *
     * @return string
     */
    protected function seekingLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => static::SEEKING[$this->seeking],
        );
    }

    /**
     * Get the project's visibility.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function visibility(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->isUnlisted() ? 'unlisted' : 'public',
        );
    }

    /**
     * Format the project's visiblity for display.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function visibilityLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => static::STATUS[$this->visibility],
        );
    }

    /**
     * Format the project's feedback type for display.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function feedbackLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => static::FEEDBACK[$this->feedback_type] ?? null,
        );
    }

    /**
     * Retrieve a Markdown field and format it.
     *
     * @param  string  $field
     * @return string
     */
    public function markdown($field)
    {
        if($this->{$field})
        {
            return str($this->{$field})->markdown()->toHtmlString();
        }

        return null;
    }

    /**
     * Whether the project is public.
     *
     * @return boolean
     */
    public function isPublic()
    {
        return empty($this->unlisted_at);
    }

    /**
     * Whether the project is seeking an agent.
     *
     * @return boolean
     */
    public function isSeekingAgent()
    {
        return $this->seeking === 'agent';
    }

    /**
     * Whether the project is seeking feedbback.
     *
     * @return boolean
     */
    public function isSeekingFeedback()
    {
        return $this->seeking === 'feedback';
    }

    /**
     * Whether the project is seeking readers.
     *
     * @return boolean
     */
    public function isSeekingReaders()
    {
        return $this->seeking === 'readers';
    }

    /**
     * Whether the project is unlisted.
     *
     * @return boolean
     */
    public function isUnlisted()
    {
        return filled($this->unlisted_at);
    }

    /**
     * Get the project's URL.
     *
     * @return string
     */
    public function routeUrl()
    {
        return route('projects.view', [
            'handle' => $this->user->handle,
            'slug' => $this->slug,
        ]);
    }
}
