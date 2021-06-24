<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('tasks.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255' //Indico el campo title que es obligatorio y máximo de 255 caracteres
        ]);

        $request->user()->tasks()->create([
            'title' => $request->title
        ]);

        return redirect('/tasks');
    }
}
