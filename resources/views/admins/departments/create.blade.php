@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            {{ isset($department) ? "Update Department" : "Add a new Department" }}
        </div>
        <div class="card-body">
            <form action="{{ isset($department) ? route('admin.departments.update', $department->id) : route('admin.departments.store') }}" method="POST">
                @csrf
                @if (isset($department))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="department">Department Name:</label>
                    <input type="text" name="name" required class="@error('name') is-invalid @enderror form-control" placeholder="Add a new Department" value="{{ isset($department) ? $department->name : "" }}">
                    @error('name')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <button class="btn btn-success">
                        {{ isset($department) ? "Update" : "Add" }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
