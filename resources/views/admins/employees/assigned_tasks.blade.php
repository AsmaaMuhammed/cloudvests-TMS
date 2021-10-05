@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">Assigned Tasks</div>
        <table class="card-body">
            @if(count($assignedTasks) > 0)
                <table class="table">
                    <tbody>
                    @foreach ($assignedTasks as $task)
                        <tr>
                            <td>
                                {{ $task->title }}
                            </td>
                            <td>
                                {{ $task->description }}
                            </td>
                            <td>
                                {{ $employee->priority }}
                            </td>
                            <td>
                                {{ $task->department->name }}
                            </td>
                            <td>
                                {{ $task->created_at }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="card-body">
                    <h1 class="text-center">
                        No Assigned Tasks Yet.
                    </h1>
                </div>
            @endif

        </table>
    </div>
@endsection