<!DOCTYPE html>
<html lang="en" style="-ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%;
                    -webkit-print-color-adjust: exact;"
>
@include('emails.gx.includes.head')
<body style="font-family: 'Open Sans', sans-serif;
                font-size: 15px;
                margin-bottom: -1px !important;
                min-width: 320px;
                margin: 0;
                 "
>
<table style="border-collapse: collapse; width: 100%;">
    <tbody>
    <!-- Top Grey Bar Starts -->
    @include('emails.gx.includes.top-bar')
    <!-- Top Grey Bar Ends -->
    @include('emails.gx.includes.header')
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
                       <p>
                           You have successfully registered account,
                           <a href="<?= $web_url . '/account/verify?token=' . $token . '&email=' . $email?>">Click Here</a> to verify your account.
                       </p>
                        <p>
                            Happy growing!<br>
                        @if(setting('gx.company_name'))
                            {{setting('gx.company_name')}} Team
                        @endif
                        </p>


                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @include('emails.gx.includes.footer')
    </tbody>
</table>
</body>
</html>
