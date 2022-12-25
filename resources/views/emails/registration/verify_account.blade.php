<!DOCTYPE html>
<html lang="en" style="-ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%;
                    -webkit-print-color-adjust: exact;"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet">
</head>

<body style="font-family: 'Open Sans', sans-serif;
                font-size: 15px;
                margin-bottom: -1px !important;
                min-width: 320px;
                margin: 0;
                 "
>
<table style="border-collapse: collapse; width: 100%;">
    <tbody
    @include('emails.includes.header_section')
    <tr>
        <td style="padding: 40px 15px;">
            <table style="border-collapse: collapse;
                                    min-width: 320px;
                                    max-width: 600px;
                                    width: 100%;
                                    margin: auto;"
            >
                @isset($heading)
                    <tr>
                        <td style="padding: 0;">
                            <h4 style="font-family: 'Open Sans', sans-serif;
                                                font-weight: 400;
                                                font-size: 21px;
                                                line-height: 26px;
                                                margin: 0 0 15px;
                                                color: #000000;"
                            >
                                {{ $heading }}
                            </h4>
                        </td>
                    </tr>
                @endisset

                <tr>
                    <td style="padding: 0;">
                                    <span style="font-family: 'Open Sans', sans-serif;
                                                font-weight: 400;
                                                font-size: 16px;
                                                line-height: 26px;
                                                color: #000000;
                                                display: block;"
                                    >
                                        <p>
                           You have successfully registered account,
                                            <a href="<?= $web_url . '/account/verify?token=' . $token . '&email=' . $email?>">Click Here</a> to verify your account.
                       </p>
                                    </span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @include('emails.includes.footer_section')
    </tbody>
</table>
</body>
</html>
