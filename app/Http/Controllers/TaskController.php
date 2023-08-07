<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tasks = Task::orderBy('priority');
        $project = null;

        if ($request->project_id) {
            $project = Project::findOrFail($request->project_id);
            $tasks = $tasks->whereProjectId($request->project_id);
        }

        return view('tasks.index', [
            'tasks' => $tasks->orderBy('updated_at','DESC')->paginate($request->limit ?? 10),
            'projects' => Project::all(),
            'project' => $project
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create', ['projects' => Project::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        Task::create($request->safe()->only(['name', 'project_id', 'priority']));
        return to_route('tasks.index')->with('success', 'Task created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', [
            'task' => $task,
            'projects' => Project::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->safe()->only(['name', 'project_id', 'priority']));
        return to_route('tasks.index')->with('success', 'Task Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return to_route('tasks.index')->with('success', 'Task Deleted Successfully');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePriority(Request $request){

        $task = Task::find($request->task_id);
        $prev = null;
        $next = null;

        $max = 0;

        if ($request->prev_id){
            $prev = Task::find($request->prev_id);
        }

        if ($request->next_id){
            $next = Task::find($request->next_id);
        }

        /**
         * if Item move to the top of the list
         */
        if ($prev === null ) {
            $max = 1;
        }
        /**
         * Item move to the bottom of the list
         */
        else if ($next === null && $prev !== null) {
            $max = Task::count();
        }
        else if ($prev !== null && $next !== null) {
            $max = $task->priority < $prev->priority ? $prev->priority : $prev->priority + 1;
        }



        Task::where('priority', '>', $task->priority)->where('priority', '<=', $max)
            ->update(['priority' => DB::raw('priority - 1')]);

        Task::where('priority', '<', $task->priority)->where('priority', '>=', $max)
            ->update(['priority' => DB::raw('priority + 1')]);

        $task->priority = $max;
        $task->save();

        return response()->json(true);
    }

}
