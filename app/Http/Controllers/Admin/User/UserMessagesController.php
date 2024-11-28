<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Info;
use Illuminate\Http\Request;

class UserMessagesController extends Controller
{

    public function index()
    {
        $messages = Info::query()->first();
        return view('dashboard.messages.index', compact('messages'));
    }

    public function store(Request $request)
    {
        //
    }

}
