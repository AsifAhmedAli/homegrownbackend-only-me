<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}">
<head>
   @include('admin.layout.unauthorized_layout.head')
</head>
<body class="login">
<div class="container-fluid">
    @yield('content')
</div> <!-- .container-fluid -->
@yield('javascript')
</body>
</html>
