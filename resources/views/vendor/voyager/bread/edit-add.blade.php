@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                          class="form-edit-add"
                          action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                          method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                    @if($edit)
                        {{ method_field("PUT") }}
                    @endif

                    <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">
                            @if(session()->has('featured_error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('featured_error') }}
                                </div>
                            @endif
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                            @endphp
                            @foreach($dataTypeRows as $row)
                            <!-- GET THE DISPLAY OPTIONS -->
                                @if(\App\Utils\Helpers\Helper::showFormField($row, $dataTypeContent) && \App\Utils\Helpers\Helper::allowedFieldByUser($row) && \App\Utils\Helpers\Helper::showFieldByRole($row))
                                    @php
                                        $display_options = $row->details->display ?? NULL;
                                        if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                            $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                        }
                                    @endphp
                                    @if (isset($row->details->legend) && isset($row->details->legend->text))
                                        <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                    @endif
                                    <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                            {{ $row->slugify }}
                                            <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}
                                                @php
                                                    $dtRow = null;
                                                @endphp
                                                @if(optional($row->details)->column)
                                                    @php
                                                        $dtRow = \TCG\Voyager\Models\DataRow::where('data_type_id', $row->data_type_id)->where('field', optional($row->details)->column)->first();
                                                    @endphp
                                                @endif
                                                @php
                                                    $dtRow = $dtRow ?? $row;
                                                @endphp
                                                @if($dtRow && strpos(optional(optional($dtRow->details)->validation)->rule, 'required') !== FALSE ||
                                                        strpos(optional(optional(optional($dtRow->details)->validation)->add)->rule, 'required') !== FALSE ||
                                                        strpos(optional(optional(optional($dtRow->details)->validation)->edit)->rule, 'required') !== FALSE)
                                                    <span class="glyphicon-asterisk error"></span>
                                                @endif
                                                @if(isset($row->details->info) && !empty($row->details->info))
                                                    <span class="voyager-question"
                                                          aria-hidden="true"
                                                          data-toggle="tooltip"
                                                          data-placement="right"
                                                          title="{{$row->details->info}}"></span>@endif
                                            </label>
                                            @include('voyager::multilingual.input-hidden-bread-edit-add')
                                            @if (isset($row->details->view))
                                                @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                            @elseif ($row->type == 'relationship')
                                                @include('voyager::formfields.relationship', ['options' => $row->details])
                                            @else
                                                {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                            @endif

                                            @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                            @endforeach
                                            @if ($errors->has($row->field))
                                                @foreach ($errors->get($row->field) as $error)
                                                    <span class="help-block">{{ $error }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                @endif
                            @endforeach

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            @if($dataTypeContent instanceof \App\Gx\TicketMessage)
                                @if(request('ticket'))
                                    <input type="hidden" name="ticket_id" value="{{ request('ticket')  }}">
                                @endif
                            @endif
                            @if($dataTypeContent instanceof \App\User)
                                @if(request('source', 'users') !== 'admins')
                                    <input type="hidden" name="role_id" value="{{ \App\Utils\Helpers\Helper::editAddUserRole() }}">
                                @endif
                                <input type="hidden" name="provider" value="{{ \App\Utils\Helpers\Helper::editAddUserProvider() }}">
                                <input type="hidden" name="source" value="{{ request('source', 'users') }}">
                            @endif
                            @section('submit-buttons')
                                <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                            @stop
                            @yield('submit-buttons')
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                          enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                               onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>

                </div>
            </div>
        </div>
        @if($dataTypeContent instanceof \App\Gx\TicketMessage)
            @php
                $ticket = \App\Gx\Ticket::with('messages', 'messages.user')->find(request('ticket'));
            @endphp
            @if($ticket)
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>Ticket ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Submitted</th>
                                <th>Last Updated At</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ $ticket->ticket_number }}</td>
                                <td>{{ $ticket->title }}</td>
                                <td>{{ ucwords($ticket->status) }}</td>
                                <td>{{ ucwords($ticket->priority) }}</td>
                                <td>{{ $ticket->created_at }}</td>
                                <td>{{ $ticket->updated_at }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                    <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th width="5">From</th>
                                    <th width="80">Message</th>
                                    <th width="10">Attachments</th>
                                    <th width="5">Submitted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ticket->messages as $key => $msg)
                                    <tr>
                                        <td>{{ optional($msg->user)->name }}</td>
                                        <td>{{ $msg->message }}</td>
                                        <td>
                                            @php
                                                $attachments = json_decode($msg->attachments);
                                            @endphp
                                            @if(!\App\Utils\Helpers\Helper::empty($attachments) && is_array($attachments) && count($attachments))
                                                <ul>
                                                    @foreach($attachments as $attachment)
                                                        <li><a href="{{ url('storage/' . $attachment->download_link) }}" target="_blank">View</a></li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                No Attachment
                                            @endif
                                        </td>
                                        <td>{{ $msg->created_ago }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
            @endif
        @endif
    </div>

    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop

@section('javascript')
    <script>

        $('.has-error input').on('keyup', function() {
            if($(this).val().length === 0) {
                $(this).siblings('.help-block').hide();
            } else {
                $(this).siblings('.help-block').show();
            }
        });
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
            return function() {
                $file = $(this).siblings(tag);
                params = {
                    slug:   '{{ $dataType->slug }}',
                    filename:  $file.data('file-name'),
                    id:     $file.data('id'),
                    field:  $file.parent().data('field-name'),
                    multi: isMulti,
                    _token: '{{ csrf_token() }}'
                }

                $('.confirm_delete_name').text(params.filename);
                $('#confirm_delete_modal').modal('show');
            };
        }

        $('document').ready(function () {
          /*toggle custom fields*/
          $('input[type=checkbox]').on('change', function () {

            if ($(this).data('ref') != undefined) {
              let fields = $(this).data('ref');
              if (typeof fields !== 'undefined' && fields.length > 0) {
                if ($(this).is(':checked')) {
                  $.each(fields, function (index, field) {
                    $('#' + field).show();
                  })
                } else {
                  $.each(fields, function (index, field) {
                    $('#' + field).hide();
                  })
                }
              }
            }
          });
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                } else if (elt.type != 'date') {
                    elt.type = 'text';
                    $(elt).datetimepicker({
                        format: 'L',
                        extraFormats: [ 'YYYY-MM-DD' ]
                    }).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
            $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $file.parent().siblings('input').show();
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });

            $('[data-toggle="tooltip"]').tooltip();
        });

        $(function(){
            $('.form-edit-add').validate({
                submitHandler: function(form) {
                    $('.save').attr('disabled','disabled').html('<i class="fa fa-spinner"></i> Loading...')
                    form.submit();
                }
            });
        })

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
