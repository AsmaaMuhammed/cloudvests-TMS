@extends('layouts.app')

@section('content')
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif
    <div class="clearfix">
        <a href="{{ route('admin.departments.create') }}" class="btn float-right btn-success" style="margin-bottom: 10px">Add Department</a>
    </div>
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
                            <form class="float-right ml-2" action="{{route('admin.departments.destroy', $department->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    Delete
                                </button>
                            </form>
                            <a href="{{route('admin.departments.edit', $department->id)}}" class="btn btn-primary float-right btn-sm">Edit</a>
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
@endsection