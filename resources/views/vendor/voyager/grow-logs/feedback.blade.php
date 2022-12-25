@extends('voyager::master')

@section('page_title', 'Grow Log Feedback')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-bubble"></i> Feedback
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form" class="form-edit-add" action="{{ route('admin.grow-log.post.feedback', ['growLog' => $growLog->id]) }}" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                        @csrf
                        <div class="panel-body">
                            @if(session()->has('required_feedback'))
                                <div class="alert alert-danger">
                                    {{ session()->get('required_feedback') }}
                                </div>
                            @endif
                            <div class="form-group  col-md-12 ">
                                <label class="control-label">Feedback
                                </label>
                                <textarea class="form-control richTextBox" name="feedback"  aria-hidden="true">@if($logFeedback){{ $logFeedback->feedback }}@endif</textarea>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary save">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('javascript')
    <script>
        tinymce.init({
            menubar: false,
            selector: 'textarea.richTextBox',
            skin_url: $('meta[name="assets-path"]').attr('content') + '?path=js/skins/voyager',
            min_height: 600,
            resize: 'vertical',
            plugins: 'link, image, code, table, textcolor, lists',
            extended_valid_elements: 'input[id|name|value|type|class|style|required|placeholder|autocomplete|onclick]',
            file_browser_callback: function (field_name, url, type, win) {
                if (type == 'image') {
                    $('#upload_file').trigger('click');
                }
            },
            toolbar: 'styleselect bold italic underline | strikethrough | forecolor backcolor | alignleft aligncenter alignright fontsizeselect removeformat | bullist numlist outdent indent | link image table | code',
            convert_urls: false,
            image_caption: true,
            image_title: true,
            formats: {
                removeformat: [
                    {selector: 'blockquote, b,strong,em,i,font,u,strike', remove : 'all', split : true, expand : false, block_expand: true, deep : true},
                    {selector: 'span', attributes : ['style', 'class'], remove : 'empty', split : true, expand : false, deep : true},
                    {selector: '*', attributes : ['style', 'class'], split : false, expand : false, deep : true}
                ]
            },
            init_instance_callback: function (editor) {
                if (typeof tinymce_init_callback !== "undefined") {
                    tinymce_init_callback(editor);
                }
            },
            setup: function (editor) {
                if (typeof tinymce_setup_callback !== "undefined") {
                    tinymce_setup_callback(editor);
                }
            },
            file_browser_callback: function (field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = '{{url('/')}}/laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open(
                    {
                        file: cmsURL,
                        title: 'Filemanager',
                        width: x * 0.8,
                        height: y * 0.8,
                        resizable: "yes",
                        close_previous: "no"
                    }
                );
            }
        });
    </script>
@stop
