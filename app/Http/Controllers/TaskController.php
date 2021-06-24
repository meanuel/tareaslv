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
     * Cargo una tarea de un usuario
     * 
     * @param Task id $id
     * @return Response
     */
    public function editView($id)
    {
        $task = Task::find($id);

        if (empty($task)) {
            return redirect('/tasks');
        }

        //Valido que el usuario tenga autorización
        $this->authorize('verify', $task);

        return view('tasks.edit', ['task' => $task]);
    }

    /**
     * Edito una tarea de un usuario
     * 
     * @param Request $request
     * @param Task id $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255' //Indico el campo title que es obligatorio y máximo de 255 caracteres
        ]);

        $task = Task::find($id);

        if (empty($task)) {
            return redirect('/tasks');
        }

        //Valido que el usuario tenga autorización
        $this->authorize('verify', $task);

        $task->title = $request->title;
        $task->save();

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
        
        //Valido que el usuario tenga autorización
        $this->authorize('verify', $task);

        $task->delete();

        return redirect('/tasks');
    }
}
