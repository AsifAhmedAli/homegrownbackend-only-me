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
                           @if(isset($first_name) && $first_name != "")
                            <tr>
                                <td align="left" valign="middle" style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                                    Hi {{$first_name}},
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
                                    Success! Your order was received by GX. Find the details of your order below.
                                </td>
                            </tr>
                            <!-- Content sec ends here -->


                            <!-- Space Starts -->
                            <tr>
                                <td align="left" valign="middle" height="33" style="font-size: 1px;">&nbsp;</td>
                            </tr>
                            <!-- Space Ends -->

                            <tr>
                                <td align="left" valign="middle" style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                                   Thank You!
                                </td>
                            </tr>



                        </table>

                    </td>
                </tr>
                <!-- Body Section Ends -->

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
                                            <th align="left" valign="top" width="20%"
                                                style="color:#000000; font-size: 18px; font-weight: 700;">
                                            Image
                                            </th>

                                            <th align="left" valign="top" width="20%"
                                                style="color:#000000; font-size: 18px; font-weight: 700;">
                                           Name
                                            </th>

                                            <th align="left" valign="top" width="20%"
                                                style="color:#000000; font-size: 18px; font-weight: 700;">
                                               Size
                                            </th>

                                            <th align="left" valign="top" width="20%"
                                                style="color:#000000; font-size: 18px; font-weight: 700;">
                                                Price
                                            </th>
                                        </tr>

                                    </table>

                                </td>
                            </tr>
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

                                    <tr>
                                        <td align="left" valign="left">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">

                                                <tr>
                                                    <td align="left" valign="top" width="20%">
                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            <tr>
                                                                <td align="left" valign="top" width="100%">
                                                                    <table cellpadding="0" cellspacing="0" border="0"
                                                                           width="100%">
                                                                        <tr>
                                                                            <td align="left" valign="middle">

                                                                                <img
                                                                                    src="{!! asset("storage/".$userKit->image) !!}"
                                                                                    style="width: 50%; float:left;">

                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>


                                                            </tr>
                                                        </table>
                                                    </td>

                                                    <td align="left" valign="top" width="20%"
                                                        style="color:#000000; font-size: 14px; font-weight: 700;">
                                                       {{@$userKit->name}}
                                                    </td>

                                                    <td align="left" valign="top" width="20%"
                                                        style="color:#000000; font-size: 14px; font-weight: 700;">
                                                        {{@$userKit->size}}
                                                    </td>

                                                    <td align="left" valign="top" width="20%"
                                                        style="color:#000000; font-size: 14px; font-weight: 700;">
                                                        $ {{@number_format($userKit->price,2, '.', ',')}}

                                                    </td>
                                                </tr>

                                            </table>

                                        </td>
                                    </tr>


                                <!-- Order-detail lower ends-->

                                <!-- Space Starts -->

                            <tr style="border-bottom: 1px solid #000000;">
                                <td align="left" valign="middle" height="22" style="font-size: 1px;">&nbsp;</td>
                            </tr>
                            <!-- Space Ends -->

                            </tbody>
                        </table>
                    </td>
                </tr>


                <!-- Footer Section Starts -->
            @include('emails.gx.includes.footer')
            <!-- Footer Section Ends -->

            </table>

</body>
</html>
