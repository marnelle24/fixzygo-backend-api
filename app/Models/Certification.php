<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    /** @use HasFactory<\Database\Factories\CertificationFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'institution',
        'short_description',
        'completion_date',
        'certification_no',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
