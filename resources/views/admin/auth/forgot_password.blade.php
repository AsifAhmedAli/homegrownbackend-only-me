@extends('admin.layout.unauthorized_layout.layout')

@section('content')
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

                <p>{{ __('generic.forgot_password') }} <span class="glyphicon-asterisk"></span></p>

                <form action="" method="post">
                        {{ csrf_field() }}

                        <div class="form-group form-group-default" id="emailGroup">
                            <label>{{ __('voyager::generic.email') }}</label>
                            <div class="controls">
                                <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="{{ __('voyager::generic.email') }}" class="form-control" required>
                            </div>
                        </div>

                    @section('submit-buttons')
                        <button type="submit"
                                class="btn btn-primary save" name="submit">{{ __('generic.forgot_password') }}</button>
                    @stop
                    @yield('submit-buttons')
                </form>

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
@stop
