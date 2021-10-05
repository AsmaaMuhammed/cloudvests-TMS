<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Task;
use App\Models\User;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public $employee ;

    public function __construct(EmployeeRepository $employee) {
        $this->middleware('admin', ['except' => ['assignedTasks']]);
        $this->employee = $employee;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyId = auth()->user()->company->id;
        return view('admins.employees.index', ['employees' => Employee::where('company_id', $companyId)->latest()->cursorPaginate(3)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyId = auth()->user()->company->id;
        return view('admins.employees.create', ['departments' => Department::where('company_id', $companyId)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->employee->store($request);

        session()->flash('success', 'Employee created successfully');
        return redirect(route('admin.employees.index'));
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
     * @param  Employee  $employee
     * @return \Illuminate\Http\Response | RedirectResponse
     */
    public function edit(Employee $employee)
    {
        if (auth()->user()->can('update', $employee)) {
            $companyId = auth()->user()->company->id;
            return view('admins.employees.create', ['employee' => $employee, 'departments' => Department::where('company_id', $companyId)->get()]);
        }
        else
            return redirect('admin/employees')->with('error', 'You don\'t have access to required data');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Employee $employee
     * @return \Illuminate\Http\Response | RedirectResponse
     */
    public function update(Request $request, Employee $employee)
    {
        if (auth()->user()->can('update', $employee)) {

            $this->employee->update($request, $employee);

            session()->flash('success', 'Employee updated successfully');
            return redirect(route('admin.employees.index'));
        }
        else
            return redirect('admin/employees')->with('error', 'You don\'t have access to required data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Employee $employee
     * @return \Illuminate\Http\Response | RedirectResponse
     */
    public function destroy(Employee $employee)
    {
        if (auth()->user()->can('delete', $employee)) {
            $user = User::find($employee->user_id);
            $user->delete();
            $employee->delete();
            return redirect(route('admin.employees.index'));
        }
        else
            return redirect('admin/employees')->with('error', 'You don\'t have access to required data');
    }

    public function assignedTasks()
    {
        return view('admins.employees.assigned_tasks', ['assignedTasks'=> auth()->user()->employee->tasks()->latest()->cursorPaginate(1)]);
    }
}
