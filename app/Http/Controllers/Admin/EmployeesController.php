<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{

    public function __construct() {
        $this->middleware('admin', ['except' => ['assignedTasks']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyId = auth()->user()->company->id;
        return view('admins.employees.index', ['employees' => Employee::where('company_id', $companyId)->get()]);
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
        $request->validate([
            'name' => ['required','string'],
            'mobile' => ['required','regex:/^([0-9\s\-\+\(\)]*)$/','min:10'],
            'department_id' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'type'=>'employee',
            'email' => $request->email,
            'password'=> \Hash::make($request->password)
        ]);

        Employee::create([
            'mobile' => $request->mobile,
            'company_id'=>auth()->user()->company->id,
            'department_id' => $request->department_id,
            'user_id' => $user->id
        ]);

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
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $companyId = auth()->user()->company->id;
        return view('admins.employees.create', ['employee'=> $employee, 'departments' => Department::where('company_id', $companyId)->get()]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => ['required','string'],
            'mobile' => ['required','regex:/^([0-9\s\-\+\(\)]*)$/','min:10'],
            'department_id' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$employee->user->id]
        ]);

        $user = User::find($employee->user_id);

        $userData = [
            'name' => $request->name,
            'email' => $request->email
        ];

        isset($request->password)?$userData['password'] = \Hash::make($request->password) : '';

        $employeeData = [
            'mobile' => $request->mobile,
            'department_id' => $request->department_id,
        ];

        $employee->update($employeeData);
        $user->update($userData);

        session()->flash('success', 'Employee updated successfully');
        return redirect(route('admin.employees.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $user = User::find($employee->user_id);
        $user->delete();
        $employee->delete();
        return redirect(route('admin.employees.index'));
    }

    public function assignedTasks()
    {
        return view('admins.employees.assigned_tasks', ['assignedTasks'=> auth()->user()->employee->tasks]);
    }
}
