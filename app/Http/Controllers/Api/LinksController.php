<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public function index(Link $link)
    {
        $liks = $link->getCachedLinks();
        LinkResource::wrap('data');
        return LinkResource::collection($liks);
    }
}
