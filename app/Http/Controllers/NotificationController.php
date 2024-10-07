<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Auth::user()->notifications;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
