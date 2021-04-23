<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class MenuSettingController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('menu_settings.index');
    }
}
