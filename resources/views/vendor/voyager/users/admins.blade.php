@extends('voyager::users.browse')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ ucwords(request()->segment(2)) }}
        </h1>
        @php
            $canAddNew = true;
            if(defined("{$dataType->model_name}::CAN_ADD_NEW")) {
              $canAddNew = $dataType->model_name::CAN_ADD_NEW;
            }
        @endphp
        @if($canAddNew)
            @can('add', app($dataType->model_name))
                <a href="{{ route('voyager.'.$dataType->slug.'.create', ['source' => request()->segment(2, 'users')]) }}" class="btn btn-success btn-add-new">
                    <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
                </a>
            @endcan
        @endif
        @foreach($actions as $action)
            @if (method_exists($action, 'massAction'))
                @include('voyager::bread.partials.actions', ['action' => $action, 'data' => null])
            @endif
        @endforeach
        @include('voyager::multilingual.language-selector')
    </div>
@stop
