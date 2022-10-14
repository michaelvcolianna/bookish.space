<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use Sluggable;
    use SluggableScopeHelpers;
    use SoftDeletes;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'handle',
        'pronouns',
        'bio',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'has_projects',
        'latest_projects',
    ];

    /**
     * Get the projects owned by the user.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'handle' => [
                'source' => 'name',
                'includeTrashed' => true,
            ],
        ];
    }

    /**
     * Get whether the user has any projects.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function hasProjects(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->projects->count() > 0,
        );
    }

    /**
     * Order the projects by most recently updated.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function latestProjects(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->projects()->orderByDesc('updated_at')->get(),
        );
    }
}
