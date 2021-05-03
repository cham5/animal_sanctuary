<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AdoptionRequest extends Model
{
    use HasFactory;

    // reverse of a one-to-many relationship. 
    public function user() {
        return $this->belongsTo(User::class);
    }
}
