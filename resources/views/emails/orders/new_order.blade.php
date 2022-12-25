<!DOCTYPE html>
<html lang="en" style="-ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%;
                    -webkit-print-color-adjust: exact;"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">

    <style>
        td {
            vertical-align: top;
        }

        @media screen and (max-width: 767px) {
            .order-details {
                width: 100% !important;
            }

            .shipping-address {
                width: 100% !important;
            }

            .billing-address {
                width: 100% !important;
            }
        }
    </style>
</head>

<body style="font-family: 'Open Sans', sans-serif;
                font-size: 15px;
                min-width: 320px;
                color: #555555;
                margin: 0;"
>
<table style="border-collapse: collapse;
    min-width: 320px;
    max-width: 760px;
    width: 100%;
    margin: auto;
   "

>
    <tbody>
    @include('emails.includes.header_section')

    <tr>
        <td style="padding: 30px 0px 10px;">
            <table style="border-collapse: collapse;
                                    min-width: 320px;
                                    max-width: 760px;
                                    width: 100%;
                                    margin: auto;"
            >
                <tbody>
                <tr>
                    <td align="left" valign="middle">
                        @php
                            $customerName = $order->customer_first_name.' '.$order->customer_last_name;
    $customerCardFullName = $order->first_name.' '.$order->last_name;
                            if ($order->is_different_billing){
                                 $shippingFullName = $order->shipping_first_name.' '.$order->shipping_last_name;
                                 $completeShippingAddress = $order->shipping_address_1 .', '.$order->shipping_city.', '.$order->shipping_state.', '.$order->shipping_country;
                            }else {
                              $shippingFullName = $order->billing_first_name.' '.$order->billing_last_name;
                              $completeShippingAddress = $order->billing_address_1 .', '.$order->billing_city.', '.$order->billing_state.', '.$order->billing_country;

                            }
                        @endphp
                        {{--                    <h1 style="font-size: 25px; font-weight: 700; color:#000000; margin-bottom: 30px; margin-left: 20px;">--}}
                        {{--                        Order confirmation @if(($customerName != " ")) for {{$customerName}}--}}
                        {{--                        from {{setting('site.company_name')}} @endif</h1>--}}
                        @if(($customerName != " "))
                            <p style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5; margin-bottom: 3px; margin-left: 20px;">{{ucwords($customerName)}}
                                , success!</p>
                        @endif
                        <p style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5; margin-bottom: 3px; margin-top: 5px; margin-left: 20px;">
                            Your order was received.</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0; width: 50%;">
                        <table style="border-collapse: collapse; width: 100%;">
                            <tbody>

                            <tr>
                                <td style="padding: 20px 0 30px 20px; ">
                                    <table class="order-details"
                                           style="border-collapse: collapse; width: 85%;">
                                        <tbody>
                                        <tr>
                                            <td style="font-family: 'Open Sans', sans-serif;
                                                                            font-weight: 400;
                                                                            font-size: 15px;
                                                                            padding: 4px 0;
                                                                            color: #000000; "
                                            >
                                            <span style="display: block; padding: 4px 0;">
                                                           Order: # {{ $order->order_number }}
                                                        </span>


                                            </td>

                                            <td style="font-family: 'Open Sans', sans-serif;
                                                                            font-weight: 400;
                                                                            font-size: 15px;
                                                                            padding: 4px 0;
                                                                            word-break: break-all;
                                                                            color: #000000;"
                                            >
                                            <span style="display: block; padding: 4px 0; margin-left: 150px;">
                                                          Placed: <span> {{ $order->created_at->toFormattedDateString() }}</span>
                                                        </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 0 20px 0;">
                        <table style="border-collapse: collapse;
                                                    width: 100%;
                                                    border-bottom: 1px solid #000000;"
                        >
                            <tbody>

                            <!-- Order-detail top border starts -->
                            <tr>
                                <td align="left" valign="left">
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">

                                        <tr>
                                            <td align="left" valign="top" height="1px"
                                                style="font-size: 1px; background-color:#000000;">&nbsp;
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="left" valign="top" height="22" style="font-size: 1px;">&nbsp;
                                            </td>
                                        </tr>

                                    </table>

                                </td>
                            </tr>
                            <!-- Order-detail top border ends-->

                            <!-- Order-detail top starts -->
                            <tr>
                                <td align="left" valign="left">
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">

                                        <tr>
                                            <th align="left" valign="top" width="50%"
                                                style="color:#000000; font-size: 18px; font-weight: 700;">
                                            <!-- {!! __(' Your Order') !!} -->Order Summary
                                            </th>

                                            <th align="center" valign="top" width="20%"
                                                style="color:#000000; font-size: 18px; font-weight: 700;">
                                            <!-- {{ __('Price') }}: -->Price
                                            </th>

                                            <th align="center" valign="top" width="10%"
                                                style="color:#000000; font-size: 18px; font-weight: 700;">
                                            <!-- {{ __('Quantity') }}: -->Quantity
                                            </th>

                                            <th align="right" valign="top" width="20%"
                                                style="color:#000000; font-size: 18px; font-weight: 700;">
                                                {{ __('Total') }}
                                            </th>
                                        </tr>

                                    </table>

                                </td>
                            </tr>
                            @foreach ($order->products as $product)
                                <!-- Order-detail top ends-->

                                <!-- Order-detail bottom border starts -->
                                <tr>
                                    <td align="left" valign="left">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">

                                            <tr>
                                                <td align="left" valign="top" height="22" style="font-size: 1px;">
                                                    &nbsp;
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="left" valign="top" height="1px"
                                                    style="font-size: 1px; background-color:#000000;">&nbsp;
                                                </td>
                                            </tr>

                                        </table>

                                    </td>
                                </tr>
                                <!-- Order-detail bottom border ends-->

                                <!-- Space Starts -->
                                <tr>
                                    <td align="left" valign="middle" height="22" style="font-size: 1px;">&nbsp;</td>
                                </tr>
                                <!-- Space Ends -->

                                <!-- Order-detail lower starts -->
                                @if(! is_null($product->hydro_product_id))
                                    <tr>
                                        <td align="left" valign="left">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">

                                                <tr>
                                                    <td align="left" valign="top" width="50%">
                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            <tr>
                                                                <td align="left" valign="top" width="100%">
                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           width="100%">
                                                                        <tr>
                                                                            <td align="left" valign="middle">

                                                                                <img
                                                                                    src="{!! optional($product->product)->image->url !!}"
                                                                                    style="width: 14%; float:left;">

                                                                                <a href="{{ env('WEB_URL') . '/product/' . $product->sku }}"

                                                                                   style="width:84%; margin-left:2%; float: left;  color: #000000; text-decoration: none; "
                                                                                >
                                                                                    {{ $product->product->name }}
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>


                                                            </tr>
                                                        </table>
                                                    </td>

                                                    <td align="center" valign="top" width="20%"
                                                        style="color:#000000; font-size: 14px; font-weight: 700;">
                                                        ${{ number_format($product->unit_price, 2) }}
                                                    </td>

                                                    <td align="center" valign="top" width="10%"
                                                        style="color:#000000; font-size: 14px; font-weight: 700;">
                                                        {{ $product->qty }}
                                                    </td>

                                                    <td align="right" valign="top" width="20%"
                                                        style="color:#000000; font-size: 14px; font-weight: 700;">
                                                        ${{ number_format($product->line_total, 2) }}

                                                    </td>
                                                </tr>

                                            </table>

                                        </td>
                                    </tr>

                                @else
                                    <tr>
                                        <td align="left" valign="left">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">

                                                <tr>
                                                    <td align="left" valign="top" width="50%">
                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            <tr>
                                                                <td align="left" valign="top" width="100%">
                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           width="100%">
                                                                        <tr>
                                                                            <td align="left" valign="middle">

                                                                                <img
                                                                                    src="{!! asset("storage/".$product->kit->image) !!}"
                                                                                    style="width: 14%; float:left;">

                                                                                <a href="{{ env('WEB_URL') . '/kit/' . $product->id }}"

                                                                                   style="width:84%; margin-left:2%; float: left;  color: #000000; text-decoration: none; "
                                                                                >
                                                                                    {{ $product->kit->name }}
                                                                                </a>

                                                                                @php

                                                                                    $kitProducts = getKitProducts($order->id, $product->kit->id);
                                                                                @endphp
                                                                                @if($kitProducts->count())
                                                                                    <div class="div-float inc-header text-left" style="text-align:left; margin-top: 85px; background-color: #d7d7d7;padding: 9px 10px 11px;">
                                                                                        <strong>Included Items</strong>
                                                                                    </div>
                                                                                    <table style="table-layout: fixed;margin-top: 15px; margin-bottom: 20px;">
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
                                                                        </tr>
                                                                    </table>
                                                                </td>


                                                            </tr>
                                                        </table>
                                                    </td>

                                                    <td align="center" valign="top" width="20%"
                                                        style="color:#000000; font-size: 14px; font-weight: 700;">
                                                        ${{ number_format($product->unit_price, 2) }}
                                                    </td>

                                                    <td align="center" valign="top" width="10%"
                                                        style="color:#000000; font-size: 14px; font-weight: 700;">
                                                        {{ $product->qty }}
                                                    </td>

                                                    <td align="right" valign="top" width="20%"
                                                        style="color:#000000; font-size: 14px; font-weight: 700;">
                                                        ${{ number_format($product->line_total, 2) }}

                                                    </td>
                                                </tr>

                                            </table>

                                        </td>
                                    </tr>
                                @endif

                                <!-- Order-detail lower ends-->

                                <!-- Space Starts -->
                            @endforeach
                            <tr style="border-bottom: 1px solid #000000;">
                                <td align="left" valign="middle" height="22" style="font-size: 1px;">&nbsp;</td>
                            </tr>
                            <!-- Space Ends -->

                            </tbody>
                        </table>
                    </td>
                </tr>

                <!-- Space Starts -->

                <tr>
                    <td align="left" valign="middle" height="22" style="font-size: 1px;">&nbsp;</td>
                </tr>
                <!-- Space Ends -->

                <tr>
                    <td style="padding: 0 20px;">
                        <table style="border-collapse: collapse;
                                                    width: 300px;
                                                    margin-top: 10px;
                                                    float: right;"
                        >
                            <tbody>
                            <tr>
                                <td style="font-family: 'Open Sans', sans-serif;
                                                            font-size: 15px;
                                                            font-weight: 400;
                                                            padding: 5px 0;
                                                            color: #000000;"
                                >
                                    {{ __('Subtotal') }}
                                </td>

                                <td style="font-family: 'Open Sans', sans-serif;
                                                            font-size: 15px;
                                                            font-weight: 400;
                                                            padding: 5px 0;
                                                            float: right;
                                                            color: #000000;"
                                >
                                    $ {!! number_format($order->sub_total, 2) !!}
                                </td>
                            </tr>


                            <tr>
                                <td style="font-family: 'Open Sans', sans-serif;
                                                                font-size: 15px;
                                                                font-weight: 400;
                                                                padding: 5px 0; color: #000000;"
                                >
                                    {!! __('Shipping') !!}
                                </td>

                                <td style="font-family: 'Open Sans', sans-serif;
                                                                font-size: 15px;
                                                                font-weight: 400;
                                                                padding: 5px 0;
                                                                float: right; color: #000000;"
                                >
                                    $ {!! number_format($order->shipping_charges, 2) !!}
                                </td>
                            </tr>

                            @if ($order->coupon_code)
                                <tr>
                                    <td style="font-family: 'Open Sans', sans-serif;
                                                            font-size: 15px;
                                                            font-weight: 400;
                                                            padding: 5px 0;
                                                            color: #000000;"
                                    >
                                        {{ __('Discount') }}
                                        (<span style="color: #000000;">Coupon: {{ $order->coupon_code }}</span>)
                                    </td>

                                    <td style="font-family: 'Open Sans', sans-serif;
                                                            font-size: 15px;
                                                            font-weight: 400;
                                                            padding: 5px 0;
                                                            float: right;
                                                            color: #000000;"
                                    >
                                        $ {!! number_format($order->discount, 2) !!}
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td style="font-family: 'Open Sans', sans-serif;
                                                            font-size: 15px;
                                                            font-weight: 400;
                                                            padding: 5px 0;
                                                            color: #000000;"
                                    >
                                        Discount
                                    </td>

                                    <td style="font-family: 'Open Sans', sans-serif;
                                                            font-size: 15px;
                                                            font-weight: 400;
                                                            padding: 5px 0;
                                                            float: right;
                                                            color: #000000;"
                                    >
                                        $ 0.00
                                    </td>
                                </tr>
                            @endif

                            @if ($order->tax)
                                <tr>
                                    <td style="font-family: 'Open Sans', sans-serif;
                                                                font-size: 15px;
                                                                font-weight: 400;
                                                                padding: 5px 0; color: #000000;"
                                    >
                                        {{ $tax->name }}
                                    </td>

                                    <td style="font-family: 'Open Sans', sans-serif;
                                                                font-size: 15px;
                                                                font-weight: 400;
                                                                padding: 5px 0;
                                                                float: right; color: #000000;"
                                    >
                                        ${!! number_format($order->tax, 2) !!}
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td style="font-family: 'Open Sans', sans-serif;
                                                                font-size: 15px;
                                                                font-weight: 400;
                                                                padding: 5px 0; color: #000000;"
                                    >
                                        {!! __('Tax') !!}
                                    </td>

                                    <td style="font-family: 'Open Sans', sans-serif;
                                                                font-size: 15px;
                                                                font-weight: 400;
                                                                padding: 5px 0;
                                                                float: right; color: #000000;"
                                    >
                                        $ 0.00
                                    </td>
                                </tr>
                            @endif



                            </tbody>
                        </table>
                    </td>
                </tr>


                </tbody>
            </table>
        </td>
    </tr>
    <tr >
        <td>
            <table style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; width: 720px; margin: 0 20px;">
                <tbody>
                <tr>
                    <td style="font-family: 'Open Sans', sans-serif;
                                    font-size: 17px;
                                    font-weight: 600;
                                    padding: 10px 0; color: #000000; text-transform: uppercase;"
                    >
                    <!-- {{ __('Total') }} -->
                        <span style="font-family: 'Open Sans', sans-serif;
                                                    font-size: 17px;
                                                    font-weight: 600;
                                                    padding: 10px 0;
                                                    float: left; color: #000000;"> Order Total</span>

                        <span style="font-family: 'Open Sans', sans-serif;
                                                    font-size: 17px;
                                                    font-weight: 600;
                                                    padding: 10px 0;
                                                    float: right; color: #000000;"> $ {!! number_format($order->total, 2) !!} </span>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>

    </tr>
    <tr>
        <td>
            <table style="border-collapse: collapse;
                                        width: 60%;
                                        margin: 0 20px 20px;"
            >
                <tbody>
                <tr>
                    <td style="font-family: 'Open Sans', sans-serif;
                                                font-size: 16px;
                                                font-weight: 400;
                                                color: #000000;
                                                padding: 15px 0 10px;"

                    >
                        <h3>Payment Info</h3>
                        <span style="float: left;" >
                                               @if(isset($order->card_type) && !empty($order->card_type))
                                {{$order->card_type}}
                            @elseif(isset($order->type) && !empty($order->type))
                                {{$order->type}}
                            @endif

                                            </span>

                        <span style="float: right;">
                                                {{ucwords($customerCardFullName)}}
                                            </span>
                    </td>
                </tr>

                <tr>
                    <td style="font-family: 'Open Sans', sans-serif;
                                                font-size: 16px;
                                                font-weight: 400;
                                                color: #000000;
                                                padding: 0;"
                    >
                        @if(isset($order->last_four) && !empty($order->last_four))
                            <span style="float: left;">
                                                Ending: {{$order->last_four}}
                                            </span>
                        @endif

                        <span style="float: right;">
                                                <!-- {{ $order->created_at->toFormattedDateString() }} -->
{{--                                                    Shipping Address--}}
                                            </span>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table style="border-collapse: collapse;
                                        width: 60%;
                                        margin: 0 20px 20px;"
            >
                <tbody>
                <tr>
                    <td style="font-family: 'Open Sans', sans-serif;
                                                font-size: 16px;
                                                font-weight: 400;
                                                color: #000000;
                                                padding: 15px 0 10px;"

                    >
                        <h3>Shipping Address</h3>
                        <span style="float: left;">
                                               {{ucwords($shippingFullName)}}
                                            </span>
                    </td>
                </tr>

                <tr>
                    <td style="font-family: 'Open Sans', sans-serif;
                                                font-size: 16px;
                                                font-weight: 400;
                                                color: #000000;
                                                padding: 0;"
                    >
                                            <span style="float: left;">
                                                {{$completeShippingAddress}}
                                            </span>

                    </td>
                </tr>
                <tr>
                    <td style="font-family: 'Open Sans', sans-serif;
                                                font-size: 16px;
                                                font-weight: 400;
                                                color: #000000;
                                                padding: 0;"
                    ><br>
                        @include("emails.includes.footer_company_info")

                    </td>
                </tr>

                </tbody>
            </table>
        </td>
    </tr>

    <tr>
        <td align="left" valign="middle" height="30" style="font-size: 1px;">&nbsp;
        </td>
    </tr>
    <!-- Space Ends -->
    <tr>
        <td bgcolor="#FFF" style="background-color: #FFF;">

            <table cellpadding="0" cellspacing="0" border="0" width="760" align="center"
                   style="font-family: arial; font-size: 15px; color: #000; margin: 0 auto;" class="fullTbl">

                <tr>
                    <td align="left" valign="top" height="3" bgcolor="#000000"
                        style="font-size:1px; background-color:#dddddd;">&nbsp;
                    </td>
                </tr>

                <tr>
                    <td style="color: #FFF;">

                        <!-- Footer for large Devices Starts -->
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">

                            <!-- Space Starts -->
                            <tr>
                                <td align="left" valign="middle" height="19" style="font-size: 1px;">&nbsp;
                                </td>
                            </tr>
                            <!-- Space Ends -->

                            <!-- Two Column Section Starts -->
                            <tr>

                                <td valign="middle">
                                    <!--[if mso]>
                                    <table border="0" cellspacing="0" cellpadding="0" align="center"
                                           width="650">
                                        <tr>
                                            <td align="left" valign="middle" width="650">
                                    <![endif]-->

                                    <!-- Footer Left Column Starts -->
                                    <div style="display:inline-block; margin:0px -2px; max-width:100%; vertical-align:middle; width:100%;padding-bottom:0px;"
                                         class="center-ftcontent ft-soc">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td height="50" align="center" valign="middle"
                                                    style="font-family: 'Lato', sans-serif; font-weight: normal; font-size: 14px; color: #555555;">
                                                    @if(setting('site.facebook'))
                                                        <a href="{{setting('site.facebook')}}"
                                                           target="_blank"
                                                           style="text-decoration:none; color: #555555;">
                                                            <img src="{{asset('admin-assets/images/facebook.png')}}"
                                                                 style="border:none; outline:none;"
                                                                 alt="Facebook"/>
                                                        </a>
                                                    @endif

                                                    @if(setting('site.twitter'))
                                                        <a href="{{setting('site.twitter')}}"
                                                           target="_blank"
                                                           style="text-decoration:none; color: #555555;">
                                                            <img src="{{asset('admin-assets/images/twitter.png')}}"
                                                                 style="border:none; outline:none;"
                                                                 alt="Twitter"/>
                                                        </a>
                                                    @endif

                                                    @if(setting('site.pinterest'))
                                                        <a href="{{setting('site.pinterest')}}"
                                                           target="_blank"
                                                           style="text-decoration:none; color: #555555;">
                                                            <img src="{{asset('admin-assets/images/pintrest.png')}}"
                                                                 style="border:none; outline:none;"
                                                                 alt="Pintrest"/>
                                                        </a>
                                                    @endif

                                                    @if(setting('site.instagram'))
                                                        <a href="{{setting('site.instagram')}}"
                                                           target="_blank"
                                                           style="text-decoration:none; color: #555555;">
                                                            <img src="{{asset('admin-assets/images/insta.png')}}"
                                                                 style="border:none; outline:none;"
                                                                 alt="Instagram"/>
                                                        </a>
                                                    @endif

                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- Footer Left Column Ends -->

                                    <!--[if mso]>
                                    </td>
                                    </tr>
                                    </table>
                                    <![endif]-->

                                </td>

                            </tr>
                            <!-- Two Column Section Ends -->

                            <!-- Space Starts -->
                            <tr>
                                <td align="left" valign="middle" height="15" style="font-size: 1px;">&nbsp;
                                </td>
                            </tr>
                            <!-- Space Ends -->

                        </table>
                        <!-- Footer for large Devices Ends -->

                    </td>
                </tr>

            </table>

        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
