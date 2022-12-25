@extends('voyager::master')

@section('page_title', $title)

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-external"></i>
        {{ $title }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form" class="form-edit-add" action="{{ route('admin.grow-log.post.assign', ['growLog' => $growLog->id]) }}" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                        @csrf
                        <div class="panel-body">
                            @if(session()->has('required_assigned_to'))
                                <div class="alert alert-danger">
                                    {{ session()->get('required_assigned_to') }}
                                </div>
                            @endif
                            <div class="form-group  col-md-12 ">
                                <label class="control-label">Assign To
                                </label>
                                <x-dropdown.grow-operator
                                        name="assigned_to"
                                        :value="$growLog->assigned_to"
                                        :value-name="optional($growLog->assignee)->name"
                                />
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary save">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
