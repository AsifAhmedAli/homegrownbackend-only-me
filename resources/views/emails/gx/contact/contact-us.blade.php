<!DOCTYPE html>
<html>

@include('emails.gx.includes.head')
<body style="margin: 0; padding: 0;">

<!-- Google Live Font Link -->
<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i"
      rel="stylesheet"/>

<table cellpadding="0" cellspacing="0" border="0" width="100%"
       style="font-family: arial; font-size: 15px; color: #000; margin: 0 auto;">

    <!-- Top Grey Bar Starts -->
    @include('emails.gx.includes.top-bar')
    <!-- Top Grey Bar Ends -->

    <!-- Body Section Starts -->
    <tr>
        <td>

            <table cellpadding="0" cellspacing="0" border="0" width="650" align="center"
                   style="font-family: arial;  color: #000; margin: 0 auto;" class="fullTbl">

                <!-- Header Section Starts -->
                     @include('emails.gx.includes.header')
                <!-- Header Section Ends -->

                <!-- Sub Division Section Starts -->
                <tr>
                    <td align="left" valign="middle" style="padding: 40px 0px;">

                        <table cellpadding="0" cellspacing="0" border="0" width="650" align="center"
                               style="font-family: arial; font-size: 15px; color: #000;"
                               class="fullTbl">
                            <tr>
                                <!-- <td align="left" valign="top" width="50">&nbsp;</td> -->
                                <td align="left" valign="top" width="610">

                                    <table cellpadding="0" cellspacing="0" border="0" width="610"
                                           align="center"
                                           style="font-family: arial; font-size: 15px; color: #000;"
                                           class="fullTbl">

                                        <tr>
                                            <td align="left" valign="middle"
                                                >
{{--                                                <h1 style="font-family: 'Open Sans', sans-serif;--}}
{{--                                                    font-weight: 600;--}}
{{--                                                    font-size: 30px;--}}
{{--                                                    line-height: 26px;--}}
{{--                                                    margin: 0 0 10px;--}}
{{--                                                    color: #000000;">Customer Query Notification</h1>--}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="middle">
                                                <p style="font-family: 'Open Sans', sans-serif;
                                                    font-weight: 400;
                                                    font-size: 16px;
                                                    line-height: 26px;
                                                    color: #000000;
                                                    display: block;
                                                    margin: 0px 0px 10px;">{{setting('gx.company_name')}} Admin,</p>
                                            </td>
                                        </tr>


                                        <!-- Space Starts -->
                                        <tr>
                                            <td align="left" valign="middle" height="25"
                                                style="font-size: 1px;">&nbsp;
                                            </td>
                                        </tr>
                                        <!-- Space Ends -->

                                        <tr>
                                            <td align="left" valign="middle"
                                                style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                                                {!! $body !!}
                                            </td>
                                        </tr>

                                        <!-- Space Starts -->
                                        <tr>
                                            <td align="left" valign="middle" height="25"
                                                style="font-size: 1px;">&nbsp;
                                            </td>
                                        </tr>
                                        <!-- Space Ends -->

                                        <tr>
                                            <td align="left" valign="middle">
                                                <x-paragraph :description="$query->name" style="font-family: 'Open Sans', sans-serif;
                                                    font-weight: 400;
                                                    font-size: 15px;
                                                    line-height: 26px;
                                                    color: #000000;
                                                    display: block;
                                                    margin: 0px 0px 10px;"> </x-paragraph>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="left" valign="middle">
                                                <p style="font-family: 'Open Sans', sans-serif;
                                                    font-weight: 400;
                                                    font-size: 15px;
                                                    line-height: 26px;
                                                    color: #000000;
                                                    display: block;
                                                    margin: 0px 0px 10px;"> <x-mail-to :link="$query->email" style="text-decoration: none"/></p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="left" valign="middle">
                                                <x-paragraph :description="$query->message" style="font-family: 'Open Sans', sans-serif;
                                                    font-weight: 400;
                                                    font-size: 15px;
                                                    line-height: 26px;
                                                    color: #000000;
                                                    display: block;
                                                    margin: 0px 0px 10px;"> </x-paragraph>

                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>

                <!-- Sub Division Section Ends -->
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
