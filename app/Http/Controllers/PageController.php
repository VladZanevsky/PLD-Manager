<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $title = __('messages.main');

        return view('index', compact('title'));
    }

    public function about()
    {
        $title = __('messages.about');

        return view('about', compact('title'));
    }

    public function contacts()
    {
        $title = __('messages.contacts');

        return view('contacts', compact('title'));
    }
}
