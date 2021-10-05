@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Home') }}</div>
                    <div style="margin: 6%;">
                        <h4>
                            @if(auth()->user()->isAdmin()) @auth I am <b> {{ auth()->user()->name }} </b> Company @endauth @endif
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection