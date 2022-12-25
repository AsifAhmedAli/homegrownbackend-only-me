<!DOCTYPE html>
<html>

@include('emails.gx.includes.head')
<body style="margin: 0; padding: 0;">

<!-- Google Live Font Link -->
<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet" />

<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family: arial; font-size: 15px; color: #000; margin: 0 auto;">

    <!-- Top Grey Bar Starts -->
    @include('emails.gx.includes.top-bar')
    <!-- Top Grey Bar Ends -->

    <!-- Body Section Starts -->
    <tr>
        <td>

            <table cellpadding="0" cellspacing="0" border="0" width="650" align="center" style="font-family: arial; font-size: 15px; color: #000; margin: 0 auto;" class="fullTbl">

                <!-- Header Section Starts -->
            @include('emails.gx.includes.header')
                <!-- Header Section Ends -->


                <!-- Space Starts -->
                <tr>
                    <td align="left" valign="middle" height="29" style="font-size: 1px;">&nbsp;</td>
                </tr>
                <!-- Space Ends -->


                <!-- Content sec starts here -->
{{--                <tr>--}}
{{--                    <td align="left" valign="middle"--}}
{{--                        style="font-size: 25px; font-weight: 700; color:#000000;">Reset Your Password--}}
{{--                    </td>--}}
{{--                </tr>--}}
                <tr>

                    <td align="left" valign="middle"
                        style="font-size: 18px; font-weight: 400; color:#000000;">
                        Hi {{$userFullName}},</td>
                </tr>

                <!-- Space Starts -->
                <tr>
                    <td align="left" valign="middle" height="23" style="font-size: 1px;">&nbsp;</td>
                </tr>
                <!-- Space Ends -->


                <tr>
                    <td align="left" valign="middle" style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                        {!! __('generic.mail.gx.forgot_password.body') !!}
                    </td>
                </tr>
                <!-- Content sec ends here -->


                <!-- Space Starts -->
                <tr>
                    <td align="left" valign="middle" height="20" style="font-size: 1px;">&nbsp;</td>
                </tr>
                <!-- Space Ends -->


                <tr>
                    <td align="left" valign="middle">
                        <a href="{{ $user['link'] }}" style="font-size: 18px; font-weight: 700; color: #57B2AB; background-color: #FFF; border: 2px solid #57B2AB; text-transform: uppercase; text-decoration: none; width: 228px; float: left; text-align: center;padding: 13px 0px;">RESET PASSWORD</a>
                    </td>
                </tr>


                <!-- Space Starts -->
                <tr>
                    <td align="left" valign="middle" height="18" style="font-size: 1px;">&nbsp;</td>
                </tr>
                <!-- Space Ends -->


                <tr>
                    <td align="left" valign="middle"
                        style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                        {!! __('generic.mail.gx.forgot_password.body2') !!}
                        {{--<a href="mailto:{{setting('gx.support_email')}}"
                           style="text-decoration: none; color: #000000">{{setting('gx.support_email')}}</a>.--}}
                    </td>
                </tr>
                <!-- Space Starts -->
                <tr>
                    <td align="left" valign="middle" height="33" style="font-size: 1px;">&nbsp;</td>
                </tr>
                <!-- Space Ends -->

                <!-- Thankyou text starts here -->
                <tr>
                    <td align="left" valign="middle" style="color:#000000; font-size: 16px; font-weight: 400;">Happy growing!</td>
                </tr>
                <!-- Thankyou text starts here -->



                <tr>
                    <td align="left" valign="middle" style="color:#000000; font-size: 16px; font-weight: 400;"><strong>The {{setting('gx.company_name')}} Team</strong></td>
                </tr>

            </table>

        </td>
    </tr>
    <!-- Body Section Ends -->
    <!-- Footer Section Starts -->
    @include('emails.gx.includes.footer')
    <!-- Footer Section Ends -->

</table>

</body>
</html>
