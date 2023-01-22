<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siteinfo;
class SiteinfoController extends Controller
{
    //
    public function index() {
        $siteInfo = SiteInfo::all();
        return response($siteInfo);
    }
}