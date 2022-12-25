@extends('vendor.voyager.blogs.read')


@section('javascript')
    @parent
    <script>
        $('form').on('submit', function(e) {
            const confirmation = confirm('Are you sure want to change status?')
            if(!confirmation) {
                return false;
            }
            return true;
        })
    </script>
@stop
