<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert-success></x-alert-success>

            <a href="{{ route('tasks.create') }}" class="btn-link btn-lg">+ New Task</a>

            <div class="p-6 mt-6 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                <select name="project_id" id="project_id" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">{{ __("All Project") }}</option>

                    @foreach($projects as $proj)
                        <option value="{{ $proj->id }}" {{ $project && $proj->id == $project->id ? 'selected' : '' }}>{{$proj->name}}</option>
                    @endforeach
                </select>
            </div>

            <h1 class="mt-3 ps-2">{{ __('Taks for') }} {{ $project->name ?? 'All Projects' }}</h1>

            <ul id="sortable">
                @forelse($tasks as $task)
                    <li class="p-6 mt-2 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg"
                        data-task-id="{{ $task->id }}" data-project-id="{{ $task->project ? $task->project->id : '' }}">
                        <h1 class="font-bold text-2xl">
                            <p>
                                {{ $task->name }} /
                                <span class="text-sm opacity-70">{{ __('priority') }} - {{ $task->priority }}</span> /
                                <a href="{{ route('tasks.edit', $task) }}" class="btn-edit-link bg-blue-400 px-1">{{ __('Edit') }}</a>
                                /
                                <form action="{{ route('tasks.destroy', $task) }}" method="post" class="inline-block">
                                    @method('delete')
                                    @csrf

                                    <x-danger-button type="submit"  onclick="return confirm('Are you sure you want to delete?')">Delete</x-danger-button>
                                </form>
                            </p>
                        </h1>
                        <span class="text-sm opacity-70">{{$task->updated_at->diffForHumans()}}</span>
                    </li>
                @empty
                    <p>You have no tasks yet.</p>
                @endforelse
                <p class="p-2">
                    {{ $tasks->links() }}
                </p>
            </ul>
        </div>
    </div>
</x-app-layout>

<script>

    /**
     * Handle change event for projects select
     */
    $("#project_id").on('change', function(){
        let $this = $(this);

        if( $this.val() ){
            window.location.replace(`/tasks?project_id=${$this.val()}`)
        } else {
            window.location.replace("/tasks")
        }
    });


    /**
     * Handle sorting by priority
     */
    $("#sortable").sortable({
        stop: function( event, ui ) {
            let $e        = $(ui.item);
            let $prevItem = $e.prev();
            let $nextItem = $e.next();

            console.log($e.data('task-id'))
            console.log($prevItem.data('task-id'))
            console.log($nextItem.data('task-id'))

            $.ajax({
                url: "{{ route('api.tasks.update-priority') }}",
                method: 'POST',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    task_id: $e.data('task-id'),
                    prev_id: $prevItem ? $prevItem.data('task-id') : null,
                    next_id: $nextItem ? $nextItem.data('task-id') : null
                }
            });
        }
    });

</script>
