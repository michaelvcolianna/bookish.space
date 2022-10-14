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
        'password-protected' => 'Password-Protected',
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
        'password',
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
        'is_password_protected',
        'is_public',
        'is_seeking_agent',
        'is_seeking_feedback',
        'is_seeking_readers',
        'is_unlisted',
        'seeking_label',
        'visibility',
        'visibility_label',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
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
     * Get the project's seeking label.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function seekingLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => static::SEEKING[$this->seeking],
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
            get: fn () => !$this->is_unlisted && !$this->is_password_protected,
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
            get: function() {
                return $this->is_password_protected
                    ? 'password-protected'
                    : (
                        $this->is_unlisted
                            ? 'unlisted'
                            : 'public'
                    )
                ;
            },
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
     * Whether the project is seeking an agent.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function isSeekingAgent(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->seeking === 'agent',
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
            get: fn () => $this->seeking === 'feedback',
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
            get: fn () => $this->seeking === 'readers',
        );
    }
}
