<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'about_me',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * Get the contacts of the user
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Get the categories of the user
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_user');
    }

    /**
     * Get the educations of the user
     */
    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    /**
     * Get the certifications of the user
     */
    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }

    /**
     * Get the accomplishments of the user
     */
    public function accomplishments(): HasMany
    {
        return $this->hasMany(Accomplishment::class);
    }
}
