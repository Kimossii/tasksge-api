<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Task;

class TaskController extends Controller
{
    //
    function list()
    {
        $userId = request()->user()->id;
        $tasks = Task::where('user_id', $userId)->get();
        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'Nenhuma tarefa encontrada'], 404);
        }
        return response()->json([$tasks], 200);
    }

    public function filter($status)
    {
        $userId = request()->user()->id;
        $tasks = Task::where('user_id', $userId)
                         ->where('status', strtolower($status))
                         ->get();
        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'Nenhuma tarefa encontrada com o status ' . $status], 404);
        }
        return response()->json($tasks, 200);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = Task::create(
            [
                'title' => $validated['title'],
                'description' => $validated['description'],
                'user_id' => $request->user()->id,
            ]
        );

        return response()->json(['data' => $task], 201);
    }



    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pendente', 'em andamento', 'concluída'])],
        ]);

        $task = $request->user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }

        if ($task->status === $validated['status']) {
            return response()->json([
                'message' => 'A tarefa já está com o status "' . $validated['status'] . '".'
            ], 200);
        }

        $task->update([
            'status' => $validated['status'],
        ]);

        return response()->json($task, 200);
    }


    public function destroy(Request $request, $id)
    {

        $task = $request->user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tarefa deletada com sucesso',
        ], 200);
    }
}
