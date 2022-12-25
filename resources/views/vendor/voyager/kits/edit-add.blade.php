<style>
    .select2-selection {
        height: 35px !important;
        border: 1px solid #e4eaec !important;
    }
</style>
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
                                        @if(property_exists($row->details, 'validation')
                                            && (
                                                  ( is_string($row->details->validation->rule)
                                                    && strpos($row->details->validation->rule, 'required') !== FALSE
                                                  )
                                                  || (
                                                    is_array($row->details->validation->rule)
                                                    && in_array('required',$row->details->validation->rule)
                                                  )
                                            )
                                        )
                                            <span class="glyphicon-asterisk text-danger"></span>
                                        @endif
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
                            @endforeach

                                <hr>
                                <h4>Products</h4>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="append-products">
                                    @php
                                        $prodQuantity = '';
                                    @endphp
                                    @if(isset($products))
                                        @foreach($products as $product)
                                            <tr>
                                                <td>{{$product->sku}}</td>
                                                <td class="quantity-row">
                                                    <p class="quantity-column">{{$product->pivot->quantity}}</p>
                                                    <input style="display: none;" id="{{$product->sku}}" type="number" class="quantity-field" value="{{$product->pivot->quantity}}">
                                                </td>
                                                <td><button type="button" data-sku="{{$product->sku}}" class="delete-row btn btn-danger"><i class="voyager-trash"></i></button></td>
                                            </tr>
                                            @php
                                                $prodQuantity .= '<input id="qty-'.$product->sku.'" type="hidden" name="quantity[]" value="'.$product->pivot->quantity.'">';
                                                $prodQuantity .= '<input id="product-'.$product->sku.'" class="products_ids" type="hidden" name="products[]" value="'.$product->id.'">';
                                            @endphp
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>

                                <hr>
                                <!--here are products with quantity--->
                                <div class="d-none kit_quantities">
                                   @php
                                     echo $prodQuantity
                                   @endphp
                                </div>

                                <h4>Add products</h4>

                            <div class="form-group col-md-5">
                                <label class="control-label" for="name">Products</label>
                                <select class="form-control select2 kit_products">
                                    <option value="">Select product</option>
                                    @foreach(getProducts() as $key => $product)
                                        <option value="{{$key}}">{{$product}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-5">
                                <label class="control-label" for="name">Quantity</label>
                                <input type="number" class="form-control kit_product_quantity">
                            </div>

                                <div class="form-group col-md-2">
                                    <button style="margin-top: 25px;" type="button" class="btn btn-success add_kit_product">Add</button>
                                </div>

                        </div><!-- panel-body -->

                        <div class="panel-footer">
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


<!--  remove products  -->
    <div class="modal modal-danger fade" tabindex="-1" id="delete_product" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }}?</h4>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-danger pull-right delete-confirm" data-dismiss="modal" value="{{ __('voyager::generic.delete_confirm') }}">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@stop

@section('javascript')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script>

        $('.select2').select2();

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
                $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });


        $(document).ready(function () {

          $(".add_kit_product").click(function () {

              let qty = $(".kit_product_quantity").val();
              let prod = $(".kit_products").val();
              let prodName = $(".kit_products option:selected").text();

              if (validate(prod)) {
                  let html = '<input id="qty-' + prodName + '" type="hidden" name="quantity[]" value="' + qty + '">';
                  html += '<input class="products_ids" type="hidden" name="products[]" value="' + prod + '">';

                  $(".kit_quantities").append(html)
                  let table = '<tr>';
                  table += '<td>' + prodName + '</td>';
                  table += '<td class="quantity-row"><p class="quantity-column">' + qty + '</p><input style="display: none;" id="' + prodName + '" type="number" class="quantity-field" value="' + qty + '"></td>';
                  table += '<td><button type="button" data-sku="'+prodName+'" class="delete-row btn btn-danger"><i class="voyager-trash"></i></button></td>';
                  table += '</tr>';
                  $(".append-products").append(table)
              }
          });

          function validate(prod_id) {
              $(".qty-msg").remove();
              $(".prod-msg").remove();
              if($(".kit_products").val() == '' && $(".kit_product_quantity").val() == '') {
                  $(".kit_products").parent('div').append('<span class="prod-msg text text-danger">This field is required.</span>');
                  $(".kit_product_quantity").parent('div').append('<span class="qty-msg text text-danger">This field is required.</span>');
                  return false;
              }
              if($(".kit_products").val() == '') {
                  $(".kit_products").parent('div').append('<span class="prod-msg text text-danger">This field is required.</span>');
                  return false;
              }
              if($(".kit_product_quantity").val() == '') {
                  $(".kit_product_quantity").parent('div').append('<span class="qty-msg text text-danger">This field is required.</span>');
                  return false;
              }
              var prod_ids = $(".products_ids").map(function(idx, elem) {
                  return $(elem).val();
              }).get();

             if (prod_ids.includes(prod_id)) {
                  toastr.error('This product is already exist.');
                  return false
             } else {
                 return true;
             }
          }


          $(document).on('click', '.quantity-row', function () {
             $(this).find('.quantity-column').hide();
             $(this).find('.quantity-field').show();
          });

          $(document).on("keyup", ".quantity-field",function () {
             $("#qty-"+ $(this).attr('id')).val($(this).val());
          });

          var $this;
            $(document).on("click", ".delete-row",function () {
                $this = $(this);
                $('#delete_product').modal('show');
            });

            $(".delete-confirm").click(function () {
                $("#qty-" + $this.data('sku')).remove();
                $("#product-" + $this.data('sku')).remove();
                $this.parents('tr').remove();
            });

        });

    </script>
@stop
