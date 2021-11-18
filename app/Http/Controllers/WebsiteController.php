<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWebsiteRequest;
use App\Http\Requests\UpdateWebsiteRequest;
use App\Models\Website;
use App\Repositories\WebsiteRepository;
use App\Services\WebsiteService;
use Illuminate\Database\Eloquent\Model;

class WebsiteController extends Controller
{
    public function index(WebsiteRepository $repository)
    {
        return $repository->all();
    }

    public function store(StoreWebsiteRequest $request, WebsiteService $service): Website|Model
    {
        return $service->store($request->validated());
    }

    public function show(Website $website): Website|Model
    {
        return $website;
    }

    public function update(UpdateWebsiteRequest $request, Website $website, WebsiteService $service)
    {
        return $service->update($website, $request->validated());
    }

    public function destroy(Website $website, WebsiteService $service)
    {
        return $service->destroy($website);
    }
}
