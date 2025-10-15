<?php

namespace App\Models;

use App\Traits\LocalTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, LocalTimestamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'role',
        'email_verified_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'role' => 'boolean',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($banner) {
            $max = config('max.admins', 1); // allowed users
            if (self::count() >= $max) {
                throw new \Exception(__('messages.max_reached', ['max' => $max, 'object' => __('messages.resources.user.plural')]), 400);
            }
        });
        static::deleting(function ($user) {
            $user->tokens()->delete();
            DB::table('password_reset_tokens')
                ->where('email', $user->email)
                ->delete();
        });
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    // public function otp(): HasOne
    // {
    //     return $this->hasOne(Otp::class, 'email', 'email');
    // }

    // public function siteInformation(): HasOne
    // {
    //     return $this->hasOne(SiteInformation::class, 'id');
    // }

    // public function phoneNumbers(): HasMany
    // {
    //     return $this->hasMany(PhoneNumber::class, 'created_by');
    // }

    // public function categories(): HasMany
    // {
    //     return $this->hasMany(Category::class, 'created_by');
    // }

    // public function products(): HasMany
    // {
    //     return $this->hasMany(Product::class, 'created_by');
    // }

    // public function productImage(): HasMany
    // {
    //     return $this->hasMany(ProductImage::class, 'created_by');
    // }

    ///
    // public function getAvatarUrlAttribute()
    // {
    //     return $this->avatar ? url('storage/' . $this->avatar) : null;
    // }

    // public function otpCodes()
    // {
    //     return $this->hasMany(OTPCode::class);
    // }

    // public function productCategories(): HasMany
    // {
    //     return $this->hasMany(ProductCategories::class, 'created_by');
    // }
}
