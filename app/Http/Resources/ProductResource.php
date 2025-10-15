<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,

            'categories' => $this->productCategories->map(function ($pc) {
                return $pc->category->load([
                    'creator',
                    'updater',
                ]);
            }),

            'before_imgs' => $this->beforeImgs
                ->load([
                    'creator',
                    'updater',
                ]),
            'after_imgs' => $this->afterImgs
                ->load([
                    'creator',
                    'updater',
                ]),

            // 'creator' => $this->creator,
            // 'updater' => $this->updater,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
