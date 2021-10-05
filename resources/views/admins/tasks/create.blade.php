@extends('layouts.app')
@section('stylesheets')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css" rel="stylesheet">
@endsection
@section('content')
    <div class="card card-default">
        <div class="card-header">
            {{ isset($task) ? "Update Task" : "Add a new Task" }}
        </div>
        <div class="card-body">
            <form action="{{ isset($task) ? route('admin.tasks.update', $task->id) : route('admin.tasks.store') }}" method="POST">
                @csrf
                @if (isset($task))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="assigned_to title">{{ __('Title') }}:</label>
                    <input type="text" required class="form-control @error('title') is-invalid @enderror"  name="title" placeholder="Add a title" value="{{ isset($task) ? $task->title : old('title') }}">

                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="assigned_to description">{{ __('Description') }}:</label>
                    <input id="description" type="hidden" name="description" value="{{ isset($task) ? $task->description : "" }}">
                    <trix-editor input="description"></trix-editor>

                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="selectPriority">{{ __('Select a priority') }}</label>
                    <select required name="priority" class="form-control @error('priority') is-invalid @enderror" id="selectPriority">
                        @foreach ($priorities as $priority)
                            @if(isset($task) && $task->priority === $priority)
                                <option selected value="{{$priority}}">{{$priority}}</option>
                            @else
                                <option value="{{$priority}}">{{$priority}}</option>
                            @endif
                        @endforeach
                    </select>

                    @error('priority')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="selectEmployee">{{ __('Select a employee') }}</label>
                    <select required name="assigned_to" class="form-control @error('assigned_to') is-invalid @enderror" id="selectEmployee">
                        @foreach ($employees as $employee)
                            @if(isset($task) && $task->assigned_to === $employee->id)
                                <option selected value="{{$employee->id}}">{{$employee->user->name}}</option>
                            @else
                                <option value="{{$employee->id}}">{{$employee->user->name}}</option>
                            @endif
                        @endforeach
                    </select>

                    @error('assigned_to')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        {{ isset($task) ? "Update" : "Add" }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
@endsection
