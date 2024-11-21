<?php

namespace Tests\Unit\Api\V1;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class)->group('todo');

// Testando o endpoint index
it('can list todos', function () {
    Todo::factory()->count(3)->create();
    $response = $this->getJson('/api/v1/todos');
    $response->assertStatus(200);
    $response->assertJsonCount(3, 'data');
});

// Testando o endpoint store
it('can create a todo', function () {
    $todoData = [
        'title' => 'Nova tarefa',
        'category' => 'Trabalho',
        'completed' => false,
        'reminder' => '2024-11-20 10:00:00',
        'due_date' => '2024-12-01'
    ];

    $response = $this->postJson('/api/v1/todos', $todoData);
    $response->assertStatus(201);
    $response->assertJsonFragment($todoData);
    $this->assertDatabaseHas('todos', $todoData);
});

// Testando o endpoint show
it('can show a todo', function () {
    $todo = Todo::factory()->create();
    $response = $this->getJson("/api/v1/todos/{$todo->id}");
    $response->assertStatus(200);
    $response->assertJsonFragment(['title' => $todo->title]);
});

// Testando o endpoint update
it('can update a todo', function () {
    $todo = Todo::factory()->create();

    $updatedData = [
        'title' => 'Tarefa Atualizada',
        'category' => 'Pessoal',
        'completed' => true,
        'reminder' => '2024-11-21 12:00:00',
        'due_date' => '2024-12-02'
    ];

    $response = $this->putJson("/api/v1/todos/{$todo->id}", $updatedData);
    $response->assertStatus(200);
    $response->assertJsonFragment($updatedData);
    $this->assertDatabaseHas('todos', $updatedData);
});

// Testando o endpoint destroy
it('can delete a todo', function () {
    $todo = Todo::factory()->create();
    $response = $this->deleteJson("/api/v1/todos/{$todo->id}");
    $response->assertStatus(204);
    $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
});

