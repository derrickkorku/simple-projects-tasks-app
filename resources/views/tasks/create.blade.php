<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 mt-6 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('tasks.store')  }}" method="post">
                    @csrf

                    <label for="name">{{ __('Name') }}</label>
                    <x-text-input :value="@old('name')" class="w-full" field="name" type="text" name="name" id="name" placeholder="{{ __('Enter task name') }}" autocomplete="off" />

                    <label for="priority" class="mt-2">{{ __('Priority') }}</label>
                    <x-text-input :value="@old('priority')" class="w-full" field="priority" type="number" name="priority" id="priority" placeholder="{{ __('Enter task priority number') }}" autocomplete="off" />

                    <label for="project_id" class="mt-2">{{ __('Project') }}</label>
                    <select name="project_id" id="project_id" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">{{ __("Select Project") }}</option>

                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{$project->name}}</option>
                        @endforeach
                    </select>
                    @error('project_id')
                    <p class="text-red-600 text-sm">{{$message}}</p>
                    @enderror

                    <x-primary-button class="mt-3">{{ __('Save Task') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
