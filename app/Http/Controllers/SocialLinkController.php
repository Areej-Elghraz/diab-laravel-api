<?php

namespace App\Http\Controllers;

use App\Filters\SocialLinkFilter;
use App\Http\Requests\IndexSocialLinkRequest;
use App\Http\Requests\StoreSocialLinkRequest;
use App\Http\Requests\UpdateSocialLinkRequest;
use App\Models\SocialLink;

class SocialLinkController extends ApiController
{
    protected $key = 'sociallink';
    public function index(IndexSocialLinkRequest $request)
    {
        return $this->runWithTransaction(function () use ($request) {
            return [
                'social_links' => (new SocialLinkFilter())->apply(SocialLink::query(), $request)->get(),
            ];
        }, __('messages.actions.retrieved_success', ['resource' => $this->resources($this->key)]));
    }

    public function store(StoreSocialLinkRequest $request) ///
    {
        return $this->runWithTransaction(function () use ($request) {
            return [
                'social_link' => SocialLink::create($request->validated()),
            ];
        }, __('messages.actions.created_success', ['resource' => $this->resource($this->key)]), successStatus: 201);
    }

    public function show(SocialLink $socialLink) /// not verified...
    {
        return $this->runWithTransaction(function () use ($socialLink) {
            return [
                'social_link' => $socialLink,
            ];
        }, __('messages.actions.retrieved_success', ['resource' => $this->resource($this->key)]));
    }

    public function update(UpdateSocialLinkRequest $request, SocialLink $socialLink) /// not verified...
    {
        return $this->runWithTransaction(function () use ($request, $socialLink) {
            $socialLink->update($request->validated());
            return [
                'social_link' => $socialLink->refresh(),
            ];
        }, __('messages.actions.updated_success', ['resource' => $this->resource($this->key)]));
    }

    public function destroy(SocialLink $socialLink) ///
    {
        return $this->runWithTransaction(function () use ($socialLink) {
            $socialLink->delete();
            return [
                'social_link' => $socialLink,
            ];
        },  __('messages.actions.deleted_success', ['resource' => $this->resource($this->key)]));
    }
}
