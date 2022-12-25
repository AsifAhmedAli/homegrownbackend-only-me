@extends('voyager::bread.read')

@section('page_title', __('voyager::generic.view') .' '. \App\Utils\Helpers\Helper::browseUserTitle(true))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }}
        {{ \App\Utils\Helpers\Helper::browseUserTitle(true) }}
        @php
            $instance = get_class($dataTypeContent);
            $canDelete = true;
            if(defined("{$instance}::EXCLUDE_ACTIONS")) {
              $excludeActions = $instance::EXCLUDE_ACTIONS;
              $canDelete = !in_array(\TCG\Voyager\Actions\DeleteAction::class, $excludeActions);
            }
            $canDelete = !$dataTypeContent->isAdmin();
        @endphp
        @can('edit', $dataTypeContent)
            <a href="{{ route('voyager.'.$dataType->slug.'.edit', $dataTypeContent->getKey()) }}?source={{ request('source', 'users') }}" class="btn btn-info">
                <span class="glyphicon glyphicon-pencil"></span>&nbsp;
                {{ __('voyager::generic.edit') }}
            </a>
        @endcan

        @if($canDelete)
            @can('delete', $dataTypeContent)
                @if($isSoftDeleted)
                    <a href="{{ route('voyager.'.$dataType->slug.'.restore', $dataTypeContent->getKey()) }}" title="{{ __('voyager::generic.restore') }}" class="btn btn-default restore" data-id="{{ $dataTypeContent->getKey() }}" id="restore-{{ $dataTypeContent->getKey() }}">
                        <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.restore') }}</span>
                    </a>
                @else
                    <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete" data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
                        <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
                    </a>
                @endif
            @endcan
        @endif

        <a href="{{ url('/admin/' . request('source', 'users')) }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            {{ __('voyager::generic.return_to_list') }}
        </a>
    </h1>
    @include('voyager::multilingual.language-selector')
@stop
