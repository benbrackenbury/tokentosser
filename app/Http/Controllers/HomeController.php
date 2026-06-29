<?php

namespace App\Http\Controllers;

use App\Services\ProfileDataService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(ProfileDataService $profiles): View
    {
        return view('welcome', $profiles->get());
    }
}
