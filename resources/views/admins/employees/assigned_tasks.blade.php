@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">Assigned Tasks</div>
        <table class="card-body">
            @if(count($assignedTasks) > 0)
                <table class="table">
                    <tbody>
                    <tr style="color: steelblue">
                        <th >{{ __('Title') }}</th>
                        <th >{{ __('Description') }}</th>
                        <th >{{ __('Priority') }}</th>
                        <th >{{ __('Created At') }}</th>
                    </tr>
                    @foreach ($assignedTasks as $task)
                        <tr>
                            <td >
                                {{ $task->title }}
                            </td>
                            <td style="width: 40%">
                                {!! $task->description !!}
                            </td>
                            <td>
                                @if($task->priority === 'High')
                                   <p style="color: red">{{ $task->priority }} </p>
                                @elseif($task->priority === 'Medium')
                                    <p style="color: green">{{ $task->priority }} </p>
                                @else
                                    <p style="color: blue">{{ $task->priority }} </p>
                                @endif
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