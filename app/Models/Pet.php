<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Owner;
use App\Models\PetImage;

class Pet extends Model
{
    use HasFactory;
    protected $table = 'animals';
    protected $fillable = [
        'name',
        'species',
        'breed',
        'weight',
        'age',
        'owner_id',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function petImages()
    {
        return $this->hasMany(PetImage::class);
    }
}
