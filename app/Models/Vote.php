<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    // Kasih izin buat ngisi voter_id dan product_id
    protected $fillable = ['voter_id', 'product_id'];

    public function voter()
    {
        return $this->belongsTo(Voter::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
