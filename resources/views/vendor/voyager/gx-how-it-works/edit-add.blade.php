@extends('vendor.voyager.bread.edit-add')

@section('javascript')
    @parent
    <script>
        $('#confirm_delete').on('click', function(){
            $.post('{{ route('media.remove') }}', params, function (response) {
                if ( response
                    && response.data
                    && response.data.status
                    && response.data.status == 200 ) {

                    // toastr.success(response.data.message);
                    $file.parent().siblings('input').show();
                    $file.parent().fadeOut(300, function() { $(this).remove(); })
                    window.location.reload();
                } else {
                    toastr.error("Error removing file.");
                }
            });

            $('#confirm_delete_modal').modal('hide');
        });
    </script>
@endsection
