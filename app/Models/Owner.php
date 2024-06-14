<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'surname',
        'email',
        'phone',
        'address',
    ];

    public function visits()
    {
        return $this->hasManyThrough(Visit::class, Pet::class);
    }
}
