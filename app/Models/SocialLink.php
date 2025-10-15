<?php

namespace App\Models;

use App\Traits\LocalTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialLink extends Model
{
    /** @use HasFactory<\Database\Factories\SocialLinkFactory> */
    use HasFactory, LocalTimestamps;
    protected $fillable = [
        // 'id',
        'url',
        'social_media',
        // 'whatsapp_link',
        // 'messenger_link',
        // 'address',
        // 'created_by',
    ];

    // protected $hidden = [
    //     'created_by',
    // ];

    // public function creator(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'created_by', 'id');
    // }

    // public function phoneNumbers(): HasMany
    // {
    //     return $this->hasMany(PhoneNumber::class, 'created_by');
    // }

    // public function updater(): HasOne
    // {
    //     return $this->hasONe(User::class, 'updated_by');
    // }
}