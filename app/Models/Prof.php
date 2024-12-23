<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prof extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    public function cours()
    {
        return $this->belongsToMany(Cour::class);
    }
}
