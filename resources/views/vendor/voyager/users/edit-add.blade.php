@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::bread.edit-add')

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')) . ' ' . \App\Utils\Helpers\Helper::browseUserTitle(true))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')) . ' ' . \App\Utils\Helpers\Helper::browseUserTitle(true) }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop
