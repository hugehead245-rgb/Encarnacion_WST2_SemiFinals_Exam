<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_home_page_redirects_to_the_task_dashboard(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/tasks');
    }

    public function test_tasks_can_be_viewed_and_created(): void
    {
        $this->get(route('tasks.create'))
            ->assertOk()
            ->assertSee('name="_token"', false);

        $token = session()->token();

        $response = $this->post(route('tasks.store'), [
            '_token' => $token,
            'task_name' => 'Submit project',
            'description' => 'Upload the completed project to GitHub.',
            'status' => 'Pending',
            'due_date' => '2026-09-30',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'task_name' => 'Submit project',
            'status' => 'Pending',
        ]);

        $this->get(route('tasks.index'))
            ->assertOk()
            ->assertSee('Submit project');
    }

    public function test_tasks_can_be_searched_by_name_description_or_status(): void
    {
        Task::create([
            'task_name' => 'Buy groceries',
            'description' => 'Pick up vegetables.',
            'status' => 'Pending',
            'due_date' => null,
        ]);
        Task::create([
            'task_name' => 'Finish report',
            'description' => 'Send the completed report.',
            'status' => 'Completed',
            'due_date' => null,
        ]);

        $this->get(route('tasks.index', ['search' => 'vegetables']))
            ->assertOk()
            ->assertSee('Buy groceries')
            ->assertDontSee('Finish report');

        $this->get(route('tasks.index', ['search' => 'completed']))
            ->assertSee('Finish report')
            ->assertDontSee('Buy groceries');
    }

    public function test_a_task_can_be_updated(): void
    {
        $task = Task::create([
            'task_name' => 'Draft project',
            'description' => 'Write the first draft.',
            'status' => 'Pending',
            'due_date' => '2026-09-28',
        ]);

        $this->get(route('tasks.edit', $task))
            ->assertOk()
            ->assertSee('name="_method" value="PUT"', false)
            ->assertSee('name="_token"', false);

        $token = session()->token();

        $response = $this->put(route('tasks.update', $task), [
            '_token' => $token,
            'task_name' => 'Finish project',
            'description' => 'Review and submit the project.',
            'status' => 'Completed',
            'due_date' => '2026-09-29',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'task_name' => 'Finish project',
            'status' => 'Completed',
        ]);
    }

    public function test_a_task_status_can_be_toggled(): void
    {
        $task = Task::create([
            'task_name' => 'Review notes',
            'description' => null,
            'status' => 'Pending',
            'due_date' => null,
        ]);

        $this->get(route('tasks.index'))
            ->assertOk()
            ->assertSee('name="_method" value="PATCH"', false)
            ->assertSee('name="_token"', false);

        $token = session()->token();

        $this->patch(route('tasks.toggle', $task), ['_token' => $token])
            ->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'Completed',
        ]);
    }

    public function test_a_task_can_be_deleted(): void
    {
        $task = Task::create([
            'task_name' => 'Remove this task',
            'description' => null,
            'status' => 'Pending',
            'due_date' => null,
        ]);

        $dashboard = $this->get(route('tasks.index'));
        $dashboard->assertOk()
            ->assertSee('action="'.route('tasks.destroy', [$task], false).'"', false)
            ->assertSee('name="_method" value="DELETE"', false)
            ->assertSee('name="_token"', false);

        $token = session()->token();

        $this->delete(route('tasks.destroy', $task), ['_token' => $token])
            ->assertRedirect('/tasks');

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);

        $this->get(route('tasks.index'))
            ->assertOk()
            ->assertSee('Tasks Dashboard');
    }
}
