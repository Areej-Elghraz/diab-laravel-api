<?php

namespace App\Models;

use App\Enums\PhoneNumberTypeEnum;
use App\Traits\LocalTimestamps;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    /** @use HasFactory<\Database\Factories\PhoneNumberFactory> */
    use HasFactory, LocalTimestamps;

    protected $fillable = [
        'phone',
        'type',
    ];

    protected $casts = [
        'type' => 'array',
    ];

    public $allTypes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->allTypes = PhoneNumberTypeEnum::values();
    }

    public function scopeOfType(Builder $query, array $type)
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        // $allTypes = PhoneNumberTypeEnum::values();
        $type = array_map('strtolower', $type);

        if (array_diff($type, $this->allTypes)) {
            throw new \Exception(__('validation.invalid_value', ['attribute' => __('validation.attributes.type')]));
        }

        return $this->phonesByType($query, $type);
    }

    // public function scopeOfType(Builder $query, array $types)
    // {
    //     /** @var \Illuminate\Database\Eloquent\Builder $query */
    //     return $query->whereJsonContains('type', $types);
    // }

    public function phonesByType($query, array $type)
    {
        return $query->whereJsonContains('type', $type)
            ->whereJsonDoesntContain('type', array_diff($this->allTypes, $type));
    }

    // public function scopeOnlyOfType(Builder $query, array $types)
    // {
    //     /** @var \Illuminate\Database\Eloquent\Builder $query */
    //     $phoneTypes = PhoneNumberTypeEnum::values();
    //     $remainingTypes = array_diff($phoneTypes, $types);

    //     return $query
    //         ->whereJsonContains('type', $types)
    //         ->whereJsonDoesntContain('type', $remainingTypes);
    // }


    // public function creator(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }

    // public function siteInformation(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }

    // public function updater(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'updated_by');
    // }

}
