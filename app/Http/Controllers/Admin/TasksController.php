<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public $companyId;

    public function __construct() {

        $this->middleware(function ($request, $next) {
            $this->companyId = auth()->user()->company->id;

            return $next($request);
        });
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tasks = Task::where('company_id', $this->companyId)->get();
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
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'company_id'=> $this->companyId,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to
        ]);

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
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $priorities = ['High', 'Medium', 'Low'];
        $employees = Employee::where('company_id', $this->companyId)->get();
        return view('admins.tasks.create', ['employees' => $employees, 'priorities' => $priorities, 'task'=> $task]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest $request
     * @param  Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Task $task)
    {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'company_id'=> $this->companyId,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to
        ];
        $task->update($data);

        session()->flash('success', 'Task updated successfully');
        return redirect(route('admin.tasks.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect(route('admin.tasks.index'));
    }
}
