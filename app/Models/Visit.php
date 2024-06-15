<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = ['visit_date', 'owner_id', 'pet_id', 'report'];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
