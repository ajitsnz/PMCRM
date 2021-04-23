<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\AppBaseController;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class ClientController
 */
class ClientController extends AppBaseController
{
    /**
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('clients.dashboard');
    }
}
