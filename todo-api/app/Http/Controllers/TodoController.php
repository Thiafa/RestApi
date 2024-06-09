<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoStoreRequest;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::all();
        return response()->success('Listagem de todos os todos', $todos);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $todo = Todo::create($data);
        } catch (\Throwable $th) {
            return response()->fail($th->getMessage());
        }
        return response()->success('Todo criado com sucesso!', $todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        try {
            $todo->delete();
        } catch (\Throwable $th) {
            return response()->fail($th->getMessage());
        }
        return response()->success('Todo deletado com sucesso!', $todo);
    }
}
