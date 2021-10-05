@extends('layouts.app')

@section('content')
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif
    @can('create', \App\Models\Task::class)
        <div class="clearfix">
            <a href="{{ route('admin.tasks.create') }}" class="btn float-right btn-success" style="margin-bottom: 10px">Add
                Task</a>
        </div>
    @endcan
    <div class="card card-default">
        <div class="card-header">All Tasks</div>
        <table class="card-body">
            @if(count($tasks) > 0)
                <table class="table">
                    <tbody>
                    <tr>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Priority') }}</th>
                        <th>{{ __('Assigned To') }}</th>
                    </tr>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>
                                {{ $task->title }}
                            </td>
                            <td>
                                {!! $task->getPartDescription($task->description) !!}
                            </td>
                            <td>
                                {{ $task->priority }}
                            </td>
                            <td>
                                {{ $task->employee->user->name }}
                            </td>
                            <td>
                                @can('delete', $task)
                                    <form class="float-right ml-2" action="{{route('admin.tasks.destroy', $task->id)}}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit"
                                                onclick="return confirm('Sure Want Delete?')">
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                                @can('update', $task)
                                    <a href="{{route('admin.tasks.edit', $task->id)}}"
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
                        No Tasks Yet.
                    </h1>
                </div>
            @endif

        </table>
    </div>
    <div style="margin:5%;">
        {{ $tasks->appends(request()->query())->links() }}
    </div>
@endsection