<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Task;
use OpenApi\Annotations as OA;



class TaskController extends Controller
{
    //Aqui anotações Swagger


    /**
     * @OA\Get(
     *     path="/v1/tasks/",
     *     summary="Lista todas as tarefas do usuário autenticado",
     *     tags={"Tarefas"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tarefas",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Task"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nenhuma tarefa encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Nenhuma tarefa encontrada")
     *         )
     *     )
     * )
     */

    public function index()
    {
        $userId = request()->user()->id;
        $tasks = Task::where('user_id', $userId)->get();

        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'Nenhuma tarefa encontrada'], 404);
        }

        return response()->json($tasks, 200);
    }


    /**
     * @OA\Get(
     *     path="/v1/tasks/filter/{status}",
     *     tags={"Tarefas"},
     *     summary="Filtrar tarefas por status",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="status",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", enum={"pendente", "em andamento", "concluída"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tarefas filtradas"
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/v1/tasks/",
     *     tags={"Tarefas"},
     *     summary="Criar uma nova tarefa",
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"titulo"},
     *             @OA\Property(property="titulo", type="string", example="Estudar Swagger"),
     *             @OA\Property(property="descricao", type="string", example="Aprender a documentar APIs")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tarefa criada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
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


    /**
     * @OA\Put(
     *     path="/v1/tasks/status/{id}",
     *     tags={"Tarefas"},
     *     summary="Atualizar o status de uma tarefa",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="string", enum={"pendente", "em andamento", "concluída"}, example="concluída")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Status atualizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tarefa não encontrada"
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/v1/tasks/{id}",
     *     tags={"Tarefas"},
     *     summary="Deletar uma tarefa",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tarefa deletada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tarefa não encontrada"
     *     )
     * )
     */
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

