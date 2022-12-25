@extends('admin.layout.unauthorized_layout.layout')

@section('content')

    <style>
        .position-relative {
            position: relative;
        }
        .show-hide-info {
            position: absolute;
            top: 50%;
            right: 0;
            -webkit-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            text-decoration: none;
            outline: none;
        }
        .show-hide-info.vhide{
            color: #929191;
        }
        .show-hide-info.vhide::after {
            content: '';
            position: absolute;
            top: 45%;
            left: 50%;
            width: 2px;
            height: 15px;
            background-color: #929191;
            -webkit-transform: translate(-50%, -50%) rotate(45deg);
            -ms-transform: translate(-50%, -50%) rotate(45deg);
            transform: translate(-50%, -50%) rotate(45deg);
        }
    </style>

    <div class="row">
        <div class="faded-bg animated"></div>
        <div class="hidden-xs col-sm-7 col-md-8">
            <div class="clearfix">
                <div class="col-sm-12 col-md-10 col-md-offset-2">
                    <div class="logo-title-container">
                        <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                        @if($admin_logo_img == '')
                            <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn"
                                 src="{{ voyager_asset('images/logo-icon-light.png') }}" alt="Logo Icon">
                        @else
                            <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn"
                                 src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
                        @endif
                        <div class="copy animated fadeIn">
                            <h1>{{ Voyager::setting('admin.title', 'Voyager') }}</h1>
                            <p>{{ Voyager::setting('admin.description', __('voyager::login.welcome')) }}</p>
                        </div>
                    </div> <!-- .logo-title-container -->
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">

            <div class="login-container">

                @if(isset($expired) && $expired)
                    <h2 class="alert alert-red">
                        {{ __('Sorry! Link is expired') }}
                    </h2>
                    <a href="/admin">Login</a>
                @else
                    <p>
                        @if(request('type', 'reset') === 'reset')
                            Reset Password
                        @else
                            Set New Password
                        @endif
                    </p>
                    <form action="{{ route('reset_password') }}" method="post">
                        {{ csrf_field() }}

                        <input type="hidden" value="{{ Request::segment(3) }}" name="token">
                        <div class="form-group form-group-default" id="emailGroup">
                            <label>{{ __('voyager::generic.password') }}</label>
                            <div class="controls position-relative">
                                <input type="password" name="password" id="password"
                                       placeholder="{{ __('voyager::generic.password') }}" class="form-control"
                                       required>
                                <a href="javascript:" class="voyager-eye show-hide-info vhide"></a>
                            </div>
                        </div>

                        <div class="form-group form-group-default" id="emailGroup">
                            <label>{{ __('generic.password_confirmation') }}</label>
                            <div class="controls position-relative">
                                <input type="password" name="password_confirmation" id="password"
                                       placeholder="{{ __('generic.password_confirmation') }}" class="form-control"
                                       required>
                                <a href="javascript:" class="voyager-eye show-hide-info vhide"></a>
                            </div>
                        </div>

                        @section('submit-buttons')
                            <button type="submit"
                                    class="btn btn-primary save"
                                    name="submit">
                                @if(request('type', 'reset') === 'reset')
                                    Reset Password
                                @else
                                    Set New Password
                                @endif
                            </button>
                        @stop
                        @yield('submit-buttons')
                    </form>
                @endif

                <div style="clear:both"></div>

                @if(!$errors->isEmpty())
                    <div class="alert alert-red">
                        <ul class="list-unstyled">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div> <!-- .login-container -->

        </div> <!-- .login-sidebar -->
    </div> <!-- .row -->
    <script type="text/javascript" src="{{ voyager_asset('js/app.js') }}"></script>
    <script>
        $('.show-hide-info').on('click', function() {
            let type = $(this).siblings('input').attr('type');
            if(type === 'password') {
                type = 'text';
            } else {
                type = 'password';
            }
            $(this).toggleClass('vhide');
            $(this).siblings('input').prop('type', type);
        });
    </script>
@stop
