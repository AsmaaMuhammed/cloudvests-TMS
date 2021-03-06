<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Employee;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public $companyId;
    public $task;
    public function __construct(TaskRepository $task) {

        $this->middleware(function ($request, $next) {
            $this->companyId = auth()->user()->company->id;

            return $next($request);
        });
        $this->middleware('admin');
        $this->task = $task;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tasks = Task::where('company_id', $this->companyId)->latest()->cursorPaginate(2);
        return view('admins.tasks.index', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $priorities = ['High', 'Medium', 'Low'];
        $employees = Employee::where('company_id', $this->companyId)->get();
        return view('admins.tasks.create', ['employees' => $employees, 'priorities' => $priorities]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $this->task->store($request);
        session()->flash('success', 'Task created successfully');
        return redirect(route('admin.tasks.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Task $task
     * @return \Illuminate\Http\Response | RedirectResponse
     */
    public function edit(Task $task)
    {
        if (auth()->user()->can('update', $task)) {
            $priorities = ['High', 'Medium', 'Low'];
            $employees = Employee::where('company_id', $this->companyId)->get();
            return view('admins.tasks.create', ['employees' => $employees, 'priorities' => $priorities, 'task' => $task]);
        }
        else
            return redirect('admin/tasks')->with('error', 'You don\'t have access to required data');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest $request
     * @param  Task $task
     * @return \Illuminate\Http\Response | RedirectResponse
     */
    public function update(TaskRequest $request, Task $task)
    {
        if (auth()->user()->can('update', $task)) {
            $this->task->update($request, $task);

            session()->flash('success', 'Task updated successfully');
            return redirect(route('admin.tasks.index'));
        }
        else
            return redirect('admin/tasks')->with('error', 'You don\'t have access to required data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Task $task
     * @return \Illuminate\Http\Response | RedirectResponse
     */
    public function destroy(Task $task)
    {
        if (auth()->user()->can('delete', $task)) {
            $task->delete();
            return redirect(route('admin.tasks.index'));
        }
        else
            return redirect('admin/tasks')->with('error', 'You don\'t have access to required data');
    }
}
