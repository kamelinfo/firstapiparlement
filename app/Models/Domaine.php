<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domaine extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];
    public function cours()
    {
        return $this->hasMany(Cour::class);
    }

}