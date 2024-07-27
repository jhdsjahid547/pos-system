<?php

namespace App\Http\Controllers;

use Inertia\Response;

class IndexController extends Controller
{
    public function index(): Response
    {
        return Inertia('Index/MainView');
    }
    public function view(): Response
    {
        return Inertia('Index/AnotherView');
    }
    public function show(): Response
    {
        return Inertia('Index/AnotherView');
    }
}
