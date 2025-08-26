<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'read_date',
        'impression',
    ];

    protected $casts = [
        'read_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
