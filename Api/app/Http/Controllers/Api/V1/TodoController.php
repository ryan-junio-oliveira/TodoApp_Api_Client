<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Http\Requests\TodoFilter;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class TodoController extends Controller
{
    public function index(Request $request, TodoFilter $filters)
    {
        try {
            $query = Todo::query();
            $filteredTodos = $filters->apply($query)->paginate(10);
            return response()->json($filteredTodos, 200);
        } catch (Exception $e) {
            Log::error('Erro ao listar as tarefas', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao listar as tarefas', 'details' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'nullable|string',
                'completed' => 'nullable|boolean',
                'reminder' => 'nullable|string',
                'due_date' => 'nullable|date'
            ]);

            $todo = Todo::create($validatedData);
            return response()->json($todo, 201);
        } catch (Exception $e) {
            Log::error('Erro ao criar a tarefa', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao criar a tarefa', 'details' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $todo = Todo::findOrFail($id); // Usando findOrFail para tratar a exceção automaticamente
            return response()->json($todo, 200);
        } catch (ModelNotFoundException $e) {
            Log::warning("Tarefa ID {$id} não encontrada.");
            return response()->json(['error' => 'Tarefa não encontrada'], 404);
        } catch (Exception $e) {
            Log::error("Erro ao exibir a tarefa ID {$id}", ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao exibir a tarefa', 'details' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $todo = Todo::findOrFail($id);

            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'nullable|string',
                'completed' => 'nullable|boolean',
                'reminder' => 'nullable|string',
                'due_date' => 'nullable|date'
            ]);

            $todo->update($validatedData);
            return response()->json($todo, 200);
        } catch (ModelNotFoundException $e) {
            Log::warning("Tarefa ID {$id} não encontrada para atualização.");
            return response()->json(['error' => 'Tarefa não encontrada'], 404);
        } catch (Exception $e) {
            Log::error("Erro ao atualizar a tarefa ID {$id}", ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao atualizar a tarefa', 'details' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $todo = Todo::findOrFail($id);
            $todo->delete();
            return response()->json(['message' => 'Tarefa deletada com sucesso'], 204);
        } catch (ModelNotFoundException $e) {
            Log::warning("Tarefa ID {$id} não encontrada para exclusão.");
            return response()->json(['error' => 'Tarefa não encontrada'], 404);
        } catch (Exception $e) {
            Log::error("Erro ao deletar a tarefa ID {$id}", ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao deletar a tarefa', 'details' => $e->getMessage()], 500);
        }
    }

    public function getCompleted()
    {
        $todos = Todo::where('completed', true)->get();
        return response()->json($todos, 200);
    }

    public function getPending()
    {
        $todos = Todo::where('completed', false)->get();
        return response()->json($todos, 200);
    }
}
