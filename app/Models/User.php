<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Kisah;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function kisah()
    {
        return $this->hasMany(Kisah::class);
    }

    public function bookmarks()
    {
        return $this->belongsToMany(Kisah::class, 'bookmark');
    }

    // relasi ke yang difollow
    public function follows()
    {
        return $this->belongsToMany(User::class, 'follow', 'user_id', 'following_id');
    }

    // relasi ke follower
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follow', 'following_id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(komen::class);
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('' . $this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode(ucwords($this->name)) . '&color=7F9CF5&background=EBF4FF';
    }
}
