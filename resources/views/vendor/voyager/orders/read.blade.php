@extends('vendor.voyager.bread.read')

@section('header_actions')
    @if($hasKits)
    <form action="" method="GET">
        <div class="panel ml-2">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Kit Tracking Number</label>
                        <input type="text" class="form-control" name="kit_tracking_number" value="{{ $dataTypeContent->kit_tracking_number }}" placeholder="Kit Tracking Number" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Kit Order Status</label>

                        <select class="form-control" name="kit_status">
                            @foreach(\App\Kit::STATUES as $index => $status)
                                <option value="{!! $index !!}" @if($dataTypeContent->kit_status == $index) selected @endif>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary save-status">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </form>
    @endif
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }} &nbsp;


        <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            {{ __('voyager::generic.return_to_list') }}
        </a>
    </h1>
    @include('voyager::multilingual.language-selector')
@stop



@section('content')

    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <!-- form start -->
                    <div class="panel-body order-details" style="padding-top:0;">
                        @if($dataTypeContent->tracking_number)
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <strong class="fontweight-700">Order Tracking Number: </strong>
                                    {!! $dataTypeContent->tracking_number  !!}
                                </div>
                            </div>
                        @endif
                        <div class="row @if($dataTypeContent->tracking_number) mt-3 @else mt-3 @endif">

                            <div class="col-md-6">
                                <strong class="fontweight-700">Bill To:</strong> <br>
                                {!! $dataTypeContent->billing_first_name . ' '. $dataTypeContent->billing_last_name !!}<br>
                                @if($dataTypeContent->billing_address_1)
                                    {!! $dataTypeContent->billing_address_1 !!}, <br>
                                @endif
                                @if($dataTypeContent->billing_address_2)
                                    {!! $dataTypeContent->billing_address_2 !!}, <br>
                                @endif
                                {!! $dataTypeContent->billing_city !!}, {!! $dataTypeContent->billing_state !!} <br>
                                {!! $dataTypeContent->billing_address_phone !!}<br>
                                {!! $dataTypeContent->billing_address_email !!} <br>
                                {!! $dataTypeContent->billing_zip !!}

                            </div>

                            <div class="col-md-6">
                                <strong class="fontweight-700">Ship To:</strong> <br>
                                {!! $dataTypeContent->shipping_first_name . ' '. $dataTypeContent->shipping_last_name !!}<br>
                                @if($dataTypeContent->shipping_address_1)
                                    {!! $dataTypeContent->shipping_address_1 !!}, <br>
                                @endif
                                {!! $dataTypeContent->shipping_city !!}, {!! $dataTypeContent->shipping_state !!} <br>
                                {!! $dataTypeContent->shipping_address_phone !!}<br>
                                {!! $dataTypeContent->shipping_address_email !!}
                            </div>

                        </div>

                        <!-- <div class="row mt-3">
                        </div> -->

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <strong class="fontweight-700">Status:</strong>
                                {{ ucwords($dataTypeContent->status) }}
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <strong class="fontweight-700">Payment Method:</strong>
                                {{ ucwords($dataTypeContent->type) }}
                            </div>
                        </div>

                        @if(!is_null($dataTypeContent->coupon_code))
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <strong class="fontweight-700">Coupon Code:</strong>
                                    {!! $dataTypeContent->coupon_code !!}
                                </div>
                            </div>
                        @endif

                        @if(!is_null($dataTypeContent->notes))
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <strong class="fontweight-700">Notes:</strong>
                                    {!! $dataTypeContent->notes !!}
                                </div>
                            </div>
                        @endif

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <table class="table table-responsive table-fixed">
                                    <colgroup>
                                        <col width="51%" />
                                        <col width="16%" />
                                        <col width="16%" />
                                        <col width="17%" />
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>Products</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dataTypeContent->products as $orderProduct)
                                        @if($orderProduct->product)
                                            <tr>
                                                <td>
                                                    <img src="{!! optional($orderProduct->product)->image->url !!}" style="width: 50px">
                                                    {!! $orderProduct->product->name !!}
                                                </td>
                                                <td>{{ $orderProduct->qty }}</td>
                                                <td>${{ number_format($orderProduct->unit_price, 2) }}</td>
                                                <td>${{ number_format($orderProduct->line_total, 2) }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>
                                                    <img src="{!! asset("storage/".$orderProduct->kit->image) !!}" style="width: 50px">
                                                    {!! $orderProduct->kit->name !!}

                                                    @php
                                                        $kitProducts = getKitProducts($orderProduct->order_id, $orderProduct->kit_id);
                                                    @endphp
                                                    @if($kitProducts->count())
                                                        <div class="div-float inc-header text-left" style="background-color: #d7d7d7;padding: 9px 10px 11px; margin-top: 15px;">
                                                            <strong>Included Items</strong>
                                                        </div>
                                                        <table style=" width: 640px; table-layout: fixed;margin-top: 25px; margin-bottom: 20px;">
                                                        <thead>
                                                        <tr>
                                                            <th width="70%">Item</th>
                                                            <th width="25%">SKU</th>
                                                            <th>Qty</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach($kitProducts as $product)
                                                            <tr>
                                                                <td>{{$product->name}}</td>
                                                                <td>{{$product->sku}}</td>
                                                                <td>{{$product->quantity}}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                   @endif
                                                </td>
                                                <td>{{ $orderProduct->qty }}</td>
                                                <td>${{ number_format($orderProduct->unit_price, 2) }}</td>
                                                <td>${{ number_format($orderProduct->line_total, 2) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-right fontweight-700" style="color: #76838f;">Sub Total:</th>
                                            <td>
                                                ${!! number_format($dataTypeContent->sub_total, 2) !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right fontweight-700" style="color: #76838f;">Tax:</th>
                                            <td>${!! number_format($dataTypeContent->tax, 2) !!}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right fontweight-700" style="color: #76838f;">Shipping Charges:</th>
                                            <td>${!! number_format($dataTypeContent->shipping_charges, 2) !!}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right fontweight-700" style="color: #76838f;">Discount:
                                                (<span style="color: #1a3e7d;">Coupon: {{ $dataTypeContent->coupon_code }}</span>)
                                            </th>
                                            <td>${!! number_format($dataTypeContent->discount, 2) !!}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right fontweight-700" style="color: #76838f;">Total:</th>
                                            <td>${!! number_format($dataTypeContent->total, 2) !!}</td>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div><!-- panel-body -->
                </div>
            </div>
        </div>
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_confirm') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('javascript')
    @parent
    <script>

        $('form').validate();

        function statusChange(status) {

            const data = {
                order_id: '{!! $dataTypeContent->id !!}',
                status: status
            }

            $.ajax({
                method: 'post',
                data: data,
                url: '{!! url('/') !!}/api/orders/change_status',
                success:function(response) {
                    toastr.success(response.message, 'Success', {"preventDuplicates": false, "preventOpenDuplicates": false});
                    let row = `<tr>
                                <td>${response.result.status}</td>
                                <td>${response.result.created_at}</td>
                              </tr>`

                    $('.status-table tbody').append(row)

                },
                error: function(response) {
                    let error = response.responseJSON
                    toastr.error(error.errors ? error.errors[0] : error.message, 'Error', {"preventDuplicates": false, "preventOpenDuplicates": false});
                }
            })

        }
    </script>
@stop
