<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Task;

class TaskController extends Controller
{
    //
    function show()
    {
        return response()->json(['message' => 'Hello, World!'], 200);
    }
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = $request->user()->tasks();

        if ($status) {
            $query->where('status', $status);
        }

        return response()->json($query->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $id = $request->user()->id;

        $task = Task::create(
            [
                'title' => $validated['title'],
                'description' => $validated['description'],
                'user_id' => $id,
            ]
        );

        return response()->json($task, 201);
    }

    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pendente', 'em andamento', 'concluída'])],
        ]);
        $id = $request->user()->id;
        $task = $request->user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }
        if ($task->status === $validated['status']) {
            return response()->json(['message' => 'A tarefa já está com o status ' . $validated['status']], 200);
        }
        $task->update(
            [
                'status' => $validated['status'],
            ]
        );

        return response()->json($task, 200);
    }

    public function destroy(Request $request, $id)
    {
        
        $task = $request->user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Tarefa deletada com sucesso'], 200);
    }
}
