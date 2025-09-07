<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'email', 'no_hp'];

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
