<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Kisah extends Model
{

    use HasFactory;

    protected $table = 'kisah';

    protected $fillable = [
        'judul',
        'sinopsis',
        'user_id',
        'isi',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function genres()
    {
        return $this->hasMany(genre::class);
    }

    public function bookmarkedBy()
    {
        return $this->belongsToMany(User::class, 'bookmark');
    }

    public function comments()
    {
        return $this->hasMany(komen::class);
    }
}
