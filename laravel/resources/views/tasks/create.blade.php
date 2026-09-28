@extends('Layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-xl p-6">
    <h1 class="text-2xl font-bold text-slate-900 mb-6">Create New Task</h1>

    <form action="{{ route('tasks.store', [], false) }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Task Name *</label>
            <input type="text" name="task_name" value="{{ old('task_name') }}" required class="w-full border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            @error('task_name') <span class="text-rose-600 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('description') }}</textarea>
            @error('description') <span class="text-rose-600 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Status *</label>
                <select name="status" class="w-full border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="Pending" {{ old('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Completed" {{ old('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
                @error('status') <span class="text-rose-600 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Due Date</label>
                <input type="date" name="due_date" value="{{ old('due_date') }}" class="w-full border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                @error('due_date') <span class="text-rose-600 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('tasks.index', [], false) }}" class="px-5 py-2.5 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">Cancel</a>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Save Task</button>
        </div>
    </form>
</div>
@endsection