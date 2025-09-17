<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory;

    // Isinya cuma nama dan nik
    protected $fillable = ['full_name', 'nik'];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
