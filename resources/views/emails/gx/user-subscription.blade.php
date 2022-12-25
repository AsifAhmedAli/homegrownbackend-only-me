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
                <!-- <tr>
                    <td align="left" valign="middle" height="29" style="font-size: 1px;">&nbsp;</td>
                </tr> -->
                <!-- Space Ends -->


                <tr>
                    <td style="padding:35px 0 40px;">
                        <table cellpadding="0" cellspacing="0" border="0" width="650" align="center" style="border-collapse: collapse;
                                    min-width: 320px;
                                    max-width: 610px;
                                    width: 100%;
                                    margin: auto;">
                            <!-- Content sec starts here -->
                            <tr>
                                <td align="left" valign="middle" style="font-size: 25px; font-weight: 700; color:#000000; ">
                                </td>
                            </tr>
                            @if(($first_name != ""))
                            <tr>
                                <td align="left" valign="middle" style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                                    Dear {{$first_name}},
                                </td>
                            </tr>
                            @endif

                            <!-- Space Starts -->
                            <tr>
                                <td align="left" valign="middle" height="23" style="font-size: 1px;">&nbsp;</td>
                            </tr>
                            <!-- Space Ends -->

                            <tr>
                                <td align="left" valign="middle" style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                                    Your subscription with GrowX is now active!
                                </td>
                            </tr>

                            <tr>
                                <td align="left" valign="middle" style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                                    Download the app from the app store to get started and access incredible features like:
                                    <ul>
                                        <li>Your own Grow Log to track your plant’s progress</li>
                                        <li>Personalized weekly updates in your Grow Tracker for best results</li>
                                        <li>A Grow Master you can video chat with for specific questions about your plant</li>
                                        <li>24/7 access to all the answers you need</li>
                                        <li>So much more</li>
                                    </ul>
                                </td>
                            </tr>
                            <!-- Content sec ends here -->


                            <!-- Space Starts -->
                            <tr>
                                <td align="left" valign="middle" height="33" style="font-size: 1px;">&nbsp;</td>
                            </tr>
                            <!-- Space Ends -->

                            <!-- info section starts here -->
                            <tr>
                                <td align="left" valign="middle" style="font-size: 1px;">
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tr>
                                            <td align="left" valign="middle" style="color:#000000; font-size: 16px; font-weight: 400;">
                                                Happy growing,
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="middle" height="5" style="font-size: 1px;">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td align="left" valign="middle" style="color:#000000; font-size: 16px; font-weight: 400;">
                                                The GX Team
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                            <!-- info section ends here -->

                        </table>

                    </td>
                </tr>
                <!-- Body Section Ends -->


                <!-- Footer Section Starts -->
            @include('emails.gx.includes.footer')
            <!-- Footer Section Ends -->

            </table>
        </td>
    </tr>
</table>

</body>
</html>
