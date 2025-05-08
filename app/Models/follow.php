<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class follow extends Model
{
    protected $table = 'follow';
    public $timestamps = false;

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //
}
