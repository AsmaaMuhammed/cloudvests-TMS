<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class DepartmentsController
 * @package App\Http\Controllers\Admin
 */
class DepartmentsController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyId = auth()->user()->company->id;
        return view('admins.departments.index', ['departments' => Department::where('company_id', $companyId)->latest()->cursorPaginate(5)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admins.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $companyId = auth()->user()->company->id;

        $data = $request->all();
        $data['company_id'] = $companyId;

        Department::create($data);

        session()->flash('success', 'Department created successfully');

        return redirect(route('admin.departments.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Department  $department
     * @return \Illuminate\Http\Response | RedirectResponse
     */
    public function edit(Department $department)
    {
        if (auth()->user()->can('update', $department)) {
            return view('admins.departments.create', ['department' => $department]);
        }
        else
            return redirect('admin/departments')->with('error', 'You don\'t have access to required data');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Department  $department
     * @return \Illuminate\Http\Response | RedirectResponse
     */
    public function update(Request $request, Department $department)
    {
        if (auth()->user()->can('update', $department)) {
            $department->update([
                'name' => $request->name
            ]);
        }
        else
            return redirect('admin/departments')->with('error', 'You don\'t have access to required data');

        session()->flash('success', 'Department updated successfuly');
        return redirect(route('admin.departments.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Department  $department
     * @return \Illuminate\Http\Response| RedirectResponse
     */
    public function destroy(Department $department)
    {
        if (auth()->user()->can('delete', $department)) {
            $department->delete();
            return redirect(route('admin.departments.index'));
        }
        else
            return redirect('admin/departments')->with('error', 'You don\'t have access to required data');
    }
}
