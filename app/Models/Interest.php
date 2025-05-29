<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Interest extends Model
{
    /** @use HasFactory<\Database\Factories\InterestFactory> */
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'is_featured',
        'description',
        'sort_order',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // belongsToMany relationship with User model
    public function users()
    {
        return $this->belongsToMany(User::class, 'interest_user');
    }

}
