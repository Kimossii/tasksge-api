<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(RefreshDatabase::class);

test('usuário pode criar uma tarefa', function () {
    // Criar um usuário de teste
    $user = User::factory()->create();

    // Dados da tarefa a ser criada
    $dados = [
        'title' => 'Tarefa de Teste',
        'description' => 'Descrição da tarefa'
    ];

    // Enviar requisição autenticada para o endpoint de criação
    $response = $this
        ->actingAs($user, 'sanctum')
        ->postJson('/api/tasks/store', $dados);

    // Verificar se retornou status HTTP 201 (Created)
    $response->assertStatus(201);

    // Verificar se a resposta contém os dados esperados
    $response->assertJsonFragment([
        'title' => 'Tarefa de Teste',
        'description' => 'Descrição da tarefa'
    ]);

    // Verificar se foi salvo no banco de dados
    $this->assertDatabaseHas('tasks', [
        'title' => 'Tarefa de Teste',
        'user_id' => $user->id,
    ]);
});


test('usuário pode listar suas tarefas', function () {
    $user = User::factory()->create();


    $user->tasks()->createMany([
        ['title' => 'Tarefa 1', 'description' => 'Desc 1', 'status' => 'pendente'],
        ['title' => 'Tarefa 2', 'description' => 'Desc 2', 'status' => 'concluída'],
    ]);


    User::factory()->create()->tasks()->create([
        'title' => 'Tarefa de outro usuário',
        'description' => 'Não deve aparecer',
        'status' => 'pendente',
    ]);

    $response = $this
        ->actingAs($user, 'sanctum')
        ->getJson('/api/tasks/list');

    $response->assertStatus(200);


    $response->assertJsonFragment(['title' => 'Tarefa 1']);
    $response->assertJsonFragment(['title' => 'Tarefa 2']);


    $response->assertJsonMissing(['title' => 'Tarefa de outro usuário']);
});

test('usuário pode filtrar tarefas por status', function () {
    $user = User::factory()->create();


    $user->tasks()->createMany([
        ['title' => 'Tarefa pendente', 'description' => 'Desc 1', 'status' => 'pendente'],
        ['title' => 'Tarefa concluída', 'description' => 'Desc 2', 'status' => 'concluída'],
        ['title' => 'Tarefa em andamento', 'description' => 'Desc 3', 'status' => 'em andamento'],
    ]);

    $response = $this
        ->actingAs($user, 'sanctum')
        ->getJson('/api/tasks/filter/pendente');

    $response->assertStatus(200);


    $response->assertJsonFragment(['title' => 'Tarefa pendente']);
    $response->assertJsonMissing(['title' => 'Tarefa concluída']);
    $response->assertJsonMissing(['title' => 'Tarefa em andamento']);
});

test('usuário pode atualizar status da tarefa', function () {
    $user = User::factory()->create();

    $task = $user->tasks()->create([
        'title' => 'Tarefa para atualizar',
        'description' => 'Descrição',
        'status' => 'pendente',
    ]);

    $novoStatus = 'concluída';

    $response = $this
        ->actingAs($user, 'sanctum')
        ->putJson("/api/tasks/status/{$task->id}", [
            'status' => $novoStatus,
        ]);

    $response->assertStatus(200);

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'status' => $novoStatus,
    ]);

    $response->assertJsonFragment([
        'status' => $novoStatus,
    ]);
});


test('usuário pode deletar uma tarefa', function () {
    $user = User::factory()->create();


    $task = $user->tasks()->create([
        'title' => 'Tarefa para deletar',
        'description' => 'Descrição',
        'status' => 'pendente',
    ]);


    $response = $this
        ->actingAs($user, 'sanctum')
        ->deleteJson("/api/tasks/delete/{$task->id}");

    $response->assertStatus(200);


    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
});
