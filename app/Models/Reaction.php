<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    protected $table = 'kisah_user_reactions';

    // Relationship to Kisah
    public function kisah()
    {
        return $this->belongsTo(Kisah::class);
    }

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
