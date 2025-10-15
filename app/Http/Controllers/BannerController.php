<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use Illuminate\Support\Facades\Storage;

class BannerController extends ApiController
{
    protected $key = 'banner';
    public function index()
    {
        return $this->runWithTransaction(function () {
            return [
                'banners' => Banner::get(),
            ];
        }, __('messages.actions.retrieved_success', ['resource' => $this->resources($this->key)]));
    }

    public function store(StoreBannerRequest $request)
    {
        $uploadedPaths = [];
        return $this->runWithTransaction(function () use ($request, &$uploadedPaths) {

            $validated = $request->validated();
            $banner = null;
            foreach ($validated['images'] as $image) {
                $image = $image->store('banner_images', 'public');
                array_push($uploadedPaths, $image);

                $banner[] = Banner::create([
                    'image' => $image,
                ]);
            }

            return [
                'banners' => $banner
            ];
        },  __('messages.actions.created_success', ['resource' => $this->resource($this->key)]), uploadedPaths: $uploadedPaths, successStatus: 201);
    }

    public function show(Banner $banner)
    {
        return $this->runWithTransaction(function () use ($banner) {
            return [
                'banner' => $banner
            ];
        }, __('messages.action.actions.retrieved_success', ['resource' => $this->resource($this->key)]));
    }

    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $uploadedPaths = [];
        return $this->runWithTransaction(function () use ($request, $banner, &$uploadedPaths) {

            $validated = $request->validated();
            if ($validated['image'] ?? null) {
                Storage::disk('public')->delete($banner->image);
                $validated['image'] = $validated['image']->store('banner_images', 'public');
                array_push($uploadedPaths, $validated['image']);
            }
            $banner->update($validated);

            return [
                'banner' => $banner->refresh()
            ];
        }, __('messages.actions.updated_success', ['resource' => $this->resource($this->key)]), uploadedPaths: $uploadedPaths);
    }

    public function destroy(Banner $banner)
    {
        return $this->runWithTransaction(function () use ($banner) {

            $image = $banner->image;
            $banner->delete();
            Storage::disk('public')->delete($image);

            return [
                'banner' => $banner
            ];
        }, __('messages.actions.deleted_success', ['resource' => $this->resource($this->key)]));
    }
}
