@extends('Layouts.app')

@section('content')
<div class="bg-green-50 shadow-md rounded-xl p-6 text-black">
    <div class="flex flex-col gap-4 mb-6 md:flex-row md:justify-between md:items-center">
        <div>
            <h1 class="text-2xl font-bold text-black">Tasks Dashboard</h1>
            <span class="text-sm text-black">Total Tasks: {{ $tasks->count() }}</span>
        </div>
        <form action="{{ route('tasks.index', [], false) }}" method="GET" class="flex w-full md:w-auto">
            <label for="search" class="sr-only">Search tasks</label>
            <input id="search" type="search" name="search" value="{{ $search ?? '' }}" placeholder="Search tasks..." class="w-full md:w-64 rounded-l-lg border border-green-700 bg-white px-3 py-2 text-black placeholder:text-gray-600 focus:outline-none focus:ring-2 focus:ring-green-700">
            <button type="submit" class="rounded-r-lg bg-green-700 px-4 py-2 font-semibold text-black hover:bg-green-800">Search</button>
        </form>
    </div>

    @if($tasks->isEmpty())
        <div class="text-center py-12">
            <p class="text-slate-500 mb-4">No tasks found. Get started by adding a new task!</p>
            <a href="{{ route('tasks.create', [], false) }}" class="inline-block bg-green-700 text-black px-5 py-2.5 rounded-lg font-medium hover:bg-green-800 transition">Create Task</a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-green-200 text-xs font-semibold text-black uppercase tracking-wider">
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Task Name</th>
                        <th class="py-3 px-4">Description</th>
                        <th class="py-3 px-4">Due Date</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-green-100 text-sm">
                    @foreach($tasks as $task)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-4 whitespace-nowrap">
                                <form action="{{ route('tasks.toggle', [$task], false) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium cursor-pointer transition {{ $task->status === 'Completed' ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-amber-100 text-amber-800 hover:bg-amber-200' }}">
                                        {{ $task->status }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-4 font-semibold text-black {{ $task->status === 'Completed' ? 'line-through text-gray-700' : '' }}">
                                {{ $task->task_name }}
                            </td>
                            <td class="py-4 px-4 text-black max-w-xs truncate">
                                {{ $task->description ?? 'N/A' }}
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap text-black">
                                {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No Limit' }}
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap text-right font-medium">
                                <a href="{{ route('tasks.edit', [$task], false) }}" class="text-black underline hover:text-green-800 mr-3">Edit</a>
                                <form action="{{ route('tasks.destroy', [$task], false) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center rounded-md bg-red-100 px-3 py-1.5 font-semibold text-red-800 transition hover:bg-red-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection