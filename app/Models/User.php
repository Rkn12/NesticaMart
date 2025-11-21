<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'seller_id',
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

    /**
     * Relasi ke seller
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Check if user is platform admin
     */
    public function isPlatform()
    {
        return $this->role === 'platform';
    }

    /**
     * Check if user is seller
     */
    public function isPenjual()
    {
        return $this->role === 'penjual';
    }

    /**
     * Check if user is visitor
     */
    public function isPengunjung()
    {
        return $this->role === 'pengunjung';
    }
}
