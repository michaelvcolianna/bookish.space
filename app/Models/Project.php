<?php

namespace App\Models;

use App\Traits\HasMarkdownFields;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Project extends Model
{
    use HasMarkdownFields;
    use HasSlug;
    use SoftDeletes;

    const SEEKING = [
        'readers' => 'Readers',
        'feedback' => 'Feedback',
        'agent' => 'An Agent',
    ];

    const FEEDBACK = [
        'positivity-pass' => 'Positivity Pass',
        'critique' => 'Critique',
        'editorial' => 'Editorial',
    ];

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'genre',
        'word_count',
        'seeking',
        'preview',
        'content_link',
        'feedback_type',
        'similar_works',
        'target_audience',
        'content_notices',
        'query_letter',
        'synopsis',
    ];

    protected $appends = [
        'feedback_label',
        'genre_label',
        'seeking_label',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(48)
            ->doNotGenerateSlugsOnUpdate()
        ;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function feedbackLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => static::FEEDBACK[$this->feedback_type] ?? null,
        );
    }

    protected function genreLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => config(sprintf('app.genres.%s', $this->genre)),
        );
    }

    protected function seekingLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => static::SEEKING[$this->seeking],
        );
    }

    public function isSeekingAgent()
    {
        return $this->seeking === 'agent';
    }

    public function isSeekingFeedback()
    {
        return $this->seeking === 'feedback';
    }

    public function isSeekingReaders()
    {
        return $this->seeking === 'readers';
    }

    public function url()
    {
        // return route('projects.view', [
        //     'handle' => $this->user->handle,
        //     'slug' => $this->slug,
        // ]);
        return '#';
    }
}
