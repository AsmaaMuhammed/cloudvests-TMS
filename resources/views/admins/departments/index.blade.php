@extends('layouts.app')

@section('content')
    {{session()->has('error')}}
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif

    @can('create', \App\Models\Department::class)
        <div class="clearfix">
            <a href="{{ route('admin.departments.create') }}" class="btn float-right btn-success"
               style="margin-bottom: 10px">Add Department</a>
        </div>
    @endcan
    <div class="card card-default">
        <div class="card-header">All Departments</div>
        <table class="card-body">
            @if(count($departments) > 0)

                <table class="table">
                    <tbody>
                    @foreach ($departments as $department)
                        <tr>
                            <td>
                                {{ $department->name }}
                            </td>
                            <td>
                                @can('delete', $department)
                                    <form class="float-right ml-2"
                                          action="{{route('admin.departments.destroy', $department->id)}}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit"
                                                onclick="return confirm('Sure Want Delete?')">
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                                @can('update', $department)
                                    <a href="{{route('admin.departments.edit', $department->id)}}"
                                       class="btn btn-primary float-right btn-sm">Edit</a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="card-body">
                    <h1 class="text-center">
                        No Departments Yet.
                    </h1>
                </div>
            @endif

        </table>

    </div>
    <div style="margin:5%;">
        {{ $departments->appends(request()->query())->links() }}
    </div>

@endsection