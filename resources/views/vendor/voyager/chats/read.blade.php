@extends('vendor.voyager.bread.read')

@section('css')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <style>

        #messages {
            height: 300px;
            /* max-width: 400px; */
            overflow-y: auto;
            padding: 10px;
            border-top: 2px solid #eaeaea;
            background: #f9f9f9;
        }
        .sender .avatar {
            margin-left: 10px;
        }
        .sender img  {
            width: 32px;
        }
        .sender .message-bubble {
            display: block;
            max-width: 60%;
            background: #c2edfd;
            margin-left: 60px;
            padding: 10px 20px;
            border-radius: 10px;
        }

        .message-date-time {
            display: block;
            font-size: 12px;
            color: #a09c9c;
        }

        .receiver {
            float: right;
        }
        .receiver .avatar {
            margin-right: 10px;
            float: right;
        }
        .receiver img  {
            width: 32px;
        }
        .receiver .message-bubble {
            display: block;
            /* max-width: 60%; */
            background: #c2edfd;
            margin-right: 20px;
            padding: 10px 20px;
            border-radius: 10px;
            float: right;
        }

        .send-btn {
            float: left;
            margin: 0;
        }

        .textInput {
            width: 94.9%;
            float: left;
        }

        .sender, .receiver {
            width: 100%;
            margin: 10px 0;
        }

        .rounded {
            height: 30px;
            border-radius: 4px;
            padding: 4px;
        }

        .in1 {
            width: 120px;
        }

        .in2 {
            width: 350px;
        }

        i {
            margin: 0 8px;
        }

        .filename-container {
            margin: 20px 20px 0 0;
        }

        .filename {
            display: inline-block;
            padding: 0 10px;
            margin-right: 10px;
            background-color: #ccc;
            border: 1px solid black;
            border-radius: 15px;
            height: 20px;
            line-height: 20px;
            text-align: center;
            font-weight: 700;
            font-size: 12px;
            font-family: 'verdana', sans-serif;
        }

        .hide {
            display: none;
        }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }} &nbsp;
        @php
            $instance = get_class($dataTypeContent);
            $canDelete = true;
            if(defined("{$instance}::EXCLUDE_ACTIONS")) {
              $excludeActions = $instance::EXCLUDE_ACTIONS;
              $canDelete = !in_array(\TCG\Voyager\Actions\DeleteAction::class, $excludeActions);
            }
        @endphp

        @if($canDelete)
            @can('delete', $dataTypeContent)
                @if($isSoftDeleted)
                    <a href="{{ route('voyager.'.$dataType->slug.'.restore', $dataTypeContent->getKey()) }}" title="{{ __('voyager::generic.restore') }}" class="btn btn-default restore" data-id="{{ $dataTypeContent->getKey() }}" id="restore-{{ $dataTypeContent->getKey() }}">
                        <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.restore') }}</span>
                    </a>
                @else
                    <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete" data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
                        <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
                    </a>
                @endif
            @endcan
        @endif

    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <td>Customer</td>
                                <td><img src="/storage/{!! $dataTypeContent->customer->avatar !!}" style="width: 64px"> {!! $dataTypeContent->customer->name !!}</td>
                            </tr>
                            <tr>
                                <td>Created At</td>
                                <td>{!! $dataTypeContent->created_at !!}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 0;">
                            <div class="chat-area" id="messages">
                            @include('voyager::chats.messages', ['messages' => $dataTypeContent->messages])
                            </div>
                            <div class="text-input clip-upload">
                                <input type="text" class="form-control textInput" id="inputText" placeholder="Enter a message...">
                                <button type="button" class="btn btn-success send-btn" data-chat-id="{{ $dataTypeContent->id }}" id="sendBtn">Send</button>
                                <label for="file-input">
                                    <i class="fa fa-paperclip fa-lg" aria-hidden="true"></i>
                                </label>
                                <input type="file" multiple class="file-input hide" name="file-input" id="file-input" accept="image/*,application/pdf,application/vnd.ms-excel">
                                <div class="filename-container"></div>

                                <audio id="message-alert">
                                    <source src="{!! asset('/alerts/alert.mp3') !!}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop

@section('javascript')
    @parent
    <script type="text/javascript">

        $(document).ready(function() {
            scrollToBottom()
        })

        function scrollToBottom() {
            $("#messages").scrollTop($("#messages")[0].scrollHeight);
        }

        function getAllMessages() {
            const chatID = '{!! request()->segment(3) !!}'
            $.get('/admin/chat/messages/' + chatID + '/get', function(response) {
                $('#messages').empty().html(response);
                scrollToBottom()
            })
        }



        function playAudio() {
            {{--const audio = new Audio("{!! asset('/alerts/alert.mp3') !!}");--}}
            {{--audio.play();--}}
            const audioSrc = document.getElementById('message-alert');
            audioSrc.play();
        }

        $(function() {

            const socket = io('{!! config('services.socket_url') !!}');
            socket.emit('join', 'room-{!! request()->segment(3) !!}')
            socket.on('room_joined', (response) => {
                // console.log('response', response)
            })

            socket.on('receive-message', (result) => {
               // console.log('result', result)
                if (result.sender !== {!! auth()->id() !!}) {
                //    playAudio();
                };
                getAllMessages()
            })

            let fileArray = [];

            $.get('/admin/chat/message/{!! request()->segment(3)!!}/read-messages', function(response) {
                console.log('response', response)
            });

            $('#sendBtn').on('click', function (e) {
                e.preventDefault();
                const text = $('#inputText')
                const chatID = $(this).data('chat-id')
                const Btn = $(this);
                if(text.val() === '' && !fileArray.length) {
                    alert('Please enter a text..')
                    return false;
                }

                let formData = new FormData();
                formData.append('message', text.val())
                if(fileArray.length) {
                    for(let i = 0; i < fileArray.length; i++) {
                        formData.append('files[]', fileArray[i])
                    }
                    formData.append('totalFiles', fileArray.length)
                }

                $.ajax({
                    method: 'POST',
                    url: `/admin/chat/message/${chatID}/add`,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function() {
                        Btn.attr('disabled', true)
                    },
                    success: function(response) {
                        Btn.attr('disabled', false)
                        text.val('')
                        socket.emit('new-message', response.result);
                        fileArray = [];
                        getAllMessages()
                        emptyPreviewFiles();
                    },
                    error: function (error) {
                        Btn.attr('disabled', false)
                    }
                })
            })
            $('.file-input').change(function(e) {
                const files = e.target.files
                for(let i = 0; i < files.length; i++) {
                    fileArray.push(files[i])
                }
                emptyPreviewFiles()
                for(let i = 0; i < fileArray.length; i++) {
                    $('.filename-container').append("<span  class='filename'>" + fileArray[i].name + " <i class='voyager-trash removeFile' data-file-id=" + i + "></i></span>").show();
                }
            })


            function emptyPreviewFiles() {
                $('.filename-container').empty();
            }
            $(document.body).on('click', '.removeFile', function(e) {
                e.preventDefault();
                const index = $(this).data('file-id')
                fileArray.splice(index, 1)
                $(this).parent().remove();
            })
        });
    </script>
@stop
