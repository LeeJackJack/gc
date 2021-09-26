<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Speedy;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Storage;

class MapController extends BaseController
{
    public function index()
    {
        return view( 'vendor.speedy.admin.map.index-vue'  );
    }
}
