@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            {{ isset($employee) ? "Update Employee" : "Add a new Employee" }}
        </div>
        <div class="card-body">
            <form action="{{ isset($employee) ? route('admin.employees.update', $employee->id) : route('admin.employees.store') }}" method="POST">
                @csrf
                @if (isset($employee))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="employee name">{{ __('Name') }}:</label>
                    <input type="text" required class="form-control @error('name') is-invalid @enderror"  name="name" placeholder="Add a name" value="{{ isset($employee) ? $employee->user->name : old('name') }}">

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" placeholder=" Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ isset($employee) ? $employee->user->email : old('email') }}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" {{ !isset($employee) ? 'required' : '' }} autocomplete="new-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control" name="password_confirmation" {{ !isset($employee) ? 'required' : '' }} autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="employee mobile">{{ __('Mobile') }}:</label>
                    <input type="text" required class="form-control @error('mobile') is-invalid @enderror" name="mobile" placeholder="Add a Mobile" value="{{ isset($employee) ? $employee->mobile : old('mobile') }}">

                    @error('mobile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="selectDepartment">{{ __('Select a department') }}</label>
                    <select required name="department_id" class="form-control @error('department_id') is-invalid @enderror" id="selectDepartment">
                        @foreach ($departments as $department)
                            @if(isset($employee) && $employee->department_id === $department->id)
                                <option selected value="{{$department->id}}">{{$department->name}}</option>
                            @else
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @endif
                        @endforeach
                    </select>

                    @error('department_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        {{ isset($employee) ? "Update" : "Add" }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

