<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $todos = Todo::all();

        if ($todos->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum todo encontrado.',
                'status' => false
            ], 204);
        }

        return (TodoResource::collection(Todo::all()))->additional([
            'message' => 'Listagem de todos os todos!',
            'status' => True
        ])->response()->setStatusCode(200);
    }
    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $todo = Todo::findOrFail($id);
            return (new TodoResource($todo))->additional([
                'message' => 'Detalhes do todo!',
                'status' => True
            ])->response()->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $todo = Todo::create($data);
            return (new TodoResource($todo))->additional([
                'message' => 'Todo criado com sucesso!',
                'status' => True
            ])->response()->setStatusCode(201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoRequest $request, string $id): JsonResponse
    {
        try {
            $todo = Todo::findOrFail($id);
            $data = $request->validated();
            $todo->update($data);
            return (new TodoResource($todo))->additional([
                'message' => 'Todo atualizado com sucesso!',
                'status' => true
            ])->response()->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar todo: ' . $th->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $todo = Todo::findOrFail($id);
            $todo->delete();
            return response()->json([
                'status' => true,
                'message' => 'Todo deletado com sucesso!',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 400);
        }
    }
}
