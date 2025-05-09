<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class komen extends Model
{
    protected $table = 'komen';

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kisah()
    {
        return $this->belongsTo(Kisah::class);
    }
}
