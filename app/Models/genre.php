<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class genre extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'genre';

    public function kisah()
    {
        return $this->belongsTo(Kisah::class);
    }
}
