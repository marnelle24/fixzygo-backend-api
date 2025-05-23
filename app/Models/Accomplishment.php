<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accomplishment extends Model
{
    /** @use HasFactory<\Database\Factories\AccomplishmentFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'about',
        'date',
        'status',
    ];
    protected $casts = [
        'date' => 'date',
        'status' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
