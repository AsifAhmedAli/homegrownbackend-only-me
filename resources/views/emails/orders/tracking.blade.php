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
            <td align="left" valign="middle">
                <p style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5; margin-bottom: 3px; margin-top: 5px; margin-left: 20px;">
                    Your Order Tracking {{ str_plural('Number', count($trackingNumbers)) }} {{ count($trackingNumbers) > 1 ? 'are' : 'is' }} {{ \App\Utils\Helpers\Helper::implode(', ', $trackingNumbers) }}
                </p>
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>
