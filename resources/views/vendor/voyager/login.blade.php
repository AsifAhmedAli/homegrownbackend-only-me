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
                            <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn" src="{{ voyager_asset('images/logo-icon-light.png') }}" alt="Logo Icon">
                        @else
                            <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn" src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
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

                @if(Session::has('message') && Session::get('alert-type') != 'error')
                    <div class="alert alert-success">
                        {!! Session::get('message') !!}
                    </div>
                @endif

                <p>{{ __('voyager::login.signin_below') }}</p>

                <form action="{{ route('voyager.login') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group form-group-default" id="emailGroup">
                        <label>{{ __('voyager::generic.email') }}</label>
                        <div class="controls">
                            <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="{{ __('voyager::generic.email') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group form-group-default" id="passwordGroup">
                        <label>{{ __('voyager::generic.password') }}</label>
                        <div class="controls position-relative">
                            <input type="password" name="password" placeholder="{{ __('voyager::generic.password') }}" class="form-control" required>
                            <a href="javascript:" class="voyager-eye show-hide-info vhide"></a>
                        </div>
                    </div>

                    <div class="form-group" id="rememberMeGroup">
                        <div class="controls">
                            <a href="{!! route('forgot_password') !!}">{{ __('generic.forgot_password') }}</a>
                        </div>
                    </div>

                    <div class="form-group" id="rememberMeGroup">
                        <div class="controls">
                            <input type="checkbox" name="remember" value="1"><span class="remember-me-text">{{ __('voyager::generic.remember_me') }}</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-block login-button">
                        <span class="signingin hidden"><span class="voyager-refresh"></span> {{ __('voyager::login.loggingin') }}...</span>
                        <span class="signin">{{ __('voyager::generic.login') }}</span>
                    </button>

                </form>

                <div style="clear:both"></div>

                @if(Session::has('message') && Session::get('alert-type') == 'error')
                    <div class="alert alert-red">
                        {!! Session::get('message') !!}
                    </div>
                @endif


                @if(isset($errors) && !$errors->isEmpty())
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
@stop
@section('javascript')
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
<script>
    var btn = document.querySelector('button[type="submit"]');
    var form = document.forms[0];
    var email = document.querySelector('[name="email"]');
    var password = document.querySelector('[name="password"]');
    btn.addEventListener('click', function(ev){
        if (form.checkValidity()) {
            btn.querySelector('.signingin').className = 'signingin';
            btn.querySelector('.signin').className = 'signin hidden';
        } else {
            ev.preventDefault();
        }
    });
    email.focus();
    document.getElementById('emailGroup').classList.add("focused");

    // Focus events for email and password fields
    email.addEventListener('focusin', function(e){
        document.getElementById('emailGroup').classList.add("focused");
    });
    email.addEventListener('focusout', function(e){
        document.getElementById('emailGroup').classList.remove("focused");
    });

    password.addEventListener('focusin', function(e){
        document.getElementById('passwordGroup').classList.add("focused");
    });
    password.addEventListener('focusout', function(e){
        document.getElementById('passwordGroup').classList.remove("focused");
    });

</script>
@stop

