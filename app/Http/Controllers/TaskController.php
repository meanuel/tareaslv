<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar lista de todas las tareas de un usuario
     * 
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //Cargo las tareas
        $tasks = $request->user()->tasks()->orderBy('created_at', 'desc')->get();

        return view('tasks.index', ['tasks' => $tasks]);
    }

    /**
     * Guardar una tarea de un usuario
     * 
     * @param Request $request
     * @return Response
     */
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

    /**
     * Elimino una tarea de un usuario
     * 
     * @param Task id $id
     * @return Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if (empty($task)) {
            return redirect('/tasks');
        }

        $task->delete();

        return redirect('/tasks');
    }
}
