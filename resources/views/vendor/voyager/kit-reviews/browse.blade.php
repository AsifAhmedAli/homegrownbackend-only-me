@extends('vendor.voyager.bread.browse')


@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->getTranslatedAttribute('display_name_plural') }}
        </h1>
        @php
            $canBulkDelete = true;
            if(defined("{$dataType->model_name}::CAN_BULK_DELETE")) {
              $canBulkDelete = $dataType->model_name::CAN_BULK_DELETE;
            }
        @endphp
        @if($canBulkDelete)
            @can('delete', app($dataType->model_name))
                @include('voyager::partials.bulk-delete')
            @endcan
        @endif
        @can('edit', app($dataType->model_name))
            @if(isset($dataType->order_column) && isset($dataType->order_display_column))
                <a href="{{ route('voyager.'.$dataType->slug.'.order') }}" class="btn btn-primary btn-add-new">
                    <i class="voyager-list"></i> <span>{{ __('voyager::bread.order') }}</span>
                </a>
            @endif
        @endcan
        @if($canBulkDelete)
            @can('delete', app($dataType->model_name))
                @if($usesSoftDeletes)
                    <input type="checkbox" @if ($showSoftDeleted) checked @endif id="show_soft_deletes" data-toggle="toggle" data-on="{{ __('voyager::bread.soft_deletes_off') }}" data-off="{{ __('voyager::bread.soft_deletes_on') }}">
                @endif
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

