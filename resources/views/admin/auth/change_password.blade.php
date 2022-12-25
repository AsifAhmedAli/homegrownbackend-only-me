@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('generic.change_password'))

@section('page_header')

    <h1 class="page-title">
        <i class="voyager-key"></i>
        {{ __('generic.change_password') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <form action="" method="post">
                        <div class="panel-body">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="Current Password">Current Password</label>
                                <div class="controls position-relative">
                                <input type="password" placeholder="Enter your current password" class="form-control"
                                       name="current_password">
                                    <a href="javascript:" class="voyager-eye show-hide-info vhide"></a>
                                </div>
                                @if ($errors->has('current_password'))
                                    @foreach ($errors->get('current_password') as $error)
                                        <span class="help-block alert-danger">{{ $error }}</span>
                                    @endforeach
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="New Password">New Password</label>
                                <div class="controls position-relative">
                                <input type="password" placeholder="Enter your new password" class="form-control"
                                       name="new_password">
                                    <a href="javascript:" class="voyager-eye show-hide-info vhide"></a>
                                </div>
                                @if ($errors->has('new_password'))
                                    @foreach ($errors->get('new_password') as $error)
                                        <span class="help-block alert-danger">{{ $error }}</span>
                                    @endforeach
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="Confirm Password">Confirm Password</label>
                                <div class="controls position-relative">
                                <input type="password" placeholder="Enter new password again" class="form-control"
                                       name="password_confirmation">
                                <a href="javascript:" class="voyager-eye show-hide-info vhide"></a>
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    @foreach ($errors->get('password_confirmation') as $error)
                                        <span class="help-block alert-danger">{{ $error }}</span>
                                    @endforeach
                                @endif
                            </div>

                        </div>
                        <div class="panel-footer">
                            @section('submit-buttons')
                                <button type="submit"
                                        class="btn btn-primary save" name="submit">{{ __('voyager::generic.save') }}</button>
                            @stop
                            @yield('submit-buttons')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
