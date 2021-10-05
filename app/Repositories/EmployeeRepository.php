<?php

namespace App\Repositories;


use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class EmployeeRepository
 * @package App\Repositories
 */
class EmployeeRepository
{

    /**
     * @param Request $request
     * @return mixed
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

        $employee = Employee::create([
            'mobile' => $request->mobile,
            'company_id'=>auth()->user()->company->id,
            'department_id' => $request->department_id,
            'user_id' => $user->id
        ]);

        return $employee;
    }

    /**
     * @param Request $request
     * @param Employee $employee
     * @return Employee
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'mobile' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
            'department_id' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $employee->user->id]
        ]);

        $user = User::find($employee->user_id);

        $userData = [
            'name' => $request->name,
            'email' => $request->email
        ];

        isset($request->password) ? $userData['password'] = \Hash::make($request->password) : '';

        $employeeData = [
            'mobile' => $request->mobile,
            'department_id' => $request->department_id,
        ];

        $employee->update($employeeData);
        $user->update($userData);

        return $employee;
    }
}