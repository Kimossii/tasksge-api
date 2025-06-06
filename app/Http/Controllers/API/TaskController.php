<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        // $task = $request->user()->tasks()->create($validated);

        return response()->json($task, 201);
    }
}
