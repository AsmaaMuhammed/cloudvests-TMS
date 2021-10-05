@extends('layouts.app')

@section('content')
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif
    <div class="clearfix">
        <a href="{{ route('admin.employees.create') }}" class="btn float-right btn-success" style="margin-bottom: 10px">Add Employee</a>
    </div>
    <div class="card card-default">
        <div class="card-header">All Employees</div>
        <table class="card-body">
            @if(count($employees) > 0)
                <table class="table">
                    <tbody>
                    <tr>
                        <th >{{ __('Name') }}</th>
                        <th >{{ __('E-Mail Address') }}</th>
                        <th >{{ __('Mobile') }}</th>
                        <th >{{ __('Department') }}</th>
                    </tr>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>
                                {{ $employee->user->name }}
                            </td>
                            <td>
                                {{ $employee->user->email }}
                            </td>
                            <td>
                                {{ $employee->mobile }}
                            </td>
                            <td>
                                {{ $employee->department->name }}
                            </td>
                            <td>
                                <form class="float-right ml-2" action="{{route('admin.employees.destroy', $employee->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </form>
                                <a href="{{route('admin.employees.edit', $employee->id)}}" class="btn btn-primary float-right btn-sm">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="card-body">
                    <h1 class="text-center">
                        No Employees Yet.
                    </h1>
                </div>
            @endif

        </table>
    </div>
@endsection