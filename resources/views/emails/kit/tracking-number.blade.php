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
                    <td style="padding:35px 0 40px;">
                        <table cellpadding="0" cellspacing="0" border="0" width="650" align="center" style="border-collapse: collapse;
                                    min-width: 320px;
                                    max-width: 610px;
                                    width: 100%;
                                    margin: auto;">
                            <!-- Content sec starts here -->

                            <tr>
                                <td align="left" valign="middle"
                                    style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                                    Hi {{ $order->user->first_name }},
                                </td>
                            </tr>


                        <!-- Space Starts -->
                            <tr>
                                <td align="left" valign="middle" height="23" style="font-size: 1px;">&nbsp;</td>
                            </tr>
                            <!-- Space Ends -->

                            <tr>
                                <td align="left" valign="middle"
                                    style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                                    Here is the tracking number for your order of a kit from HGP. Thank you for your
                                    purchase. <br/> <br />

                                    Tracking number: <br> <strong>{!! $order->kit_tracking_number !!}</strong>
                                </td>
                            </tr>
                            <!-- Content sec ends here -->


                            <!-- Space Starts -->
                            <tr>
                                <td align="left" valign="middle" height="33" style="font-size: 1px;">&nbsp;</td>
                            </tr>
                            <!-- Space Ends -->

                            <tr>
                                <td align="left" valign="middle"
                                    style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                                    Happy growing, <br>
                                    The HGP Team
                                </td>
                            </tr>


                        </table>

                    </td>
                </tr>
    <!-- Footer Section Starts -->
    @include('emails.includes.footer_section')
    <!-- Footer Section Ends -->
    </tbody>
</table>

</body>
</html>
