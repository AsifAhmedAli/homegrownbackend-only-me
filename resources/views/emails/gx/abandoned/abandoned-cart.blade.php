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
                <tr>
                     <td align="left" valign="middle"
                         style="font-size: 25px; font-weight: 700; color:#000000;">Forgot Something?
                    </td>
                </tr>


                <!-- Space Starts -->
                <tr>
                    <td align="left" valign="middle" height="23" style="font-size: 1px;">&nbsp;</td>
                </tr>
                <!-- Space Ends -->


                <tr>
                    <td align="left" valign="middle" style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                    We noticed you left something in your cart. Would you like to complete your purchase?
                    </td>
                </tr>
                <!-- Content sec ends here -->
                <tr>

                    <td style="font-family: 'Open Sans', sans-serif;
                                                    font-size: 16px;
                                                    font-weight: 400;
                                                    color: #000000;
                                                    padding: 15px 0 10px;"

                        >
                                                <span style="float: left;" >
                                                [Item/Product Name]

                                                </span>

                            <span style="float: left; margin-left: 125px;">
                            Price $00.00
                                                </span>
                        </td>
                </tr>

                <!-- Space Starts -->
                <tr>
                    <td align="left" valign="middle" height="20" style="font-size: 1px;">&nbsp;</td>
                </tr>
                <!-- Space Ends -->


                <tr>
                    <td align="left" valign="middle">
                        <a href="{{ $user['link'] }}" style="font-size: 18px; font-weight: 700; color: #57B2AB; background-color: #FFF; border: 2px solid #57B2AB; text-transform: uppercase; text-decoration: none; width: 228px; float: left; text-align: center;padding: 13px 0px;">RESUME YOUR ORDER</a>
                    </td>
                </tr>


                <!-- Space Starts -->
                <tr>
                    <td align="left" valign="middle" height="18" style="font-size: 1px;">&nbsp;</td>
                </tr>
                <!-- Space Ends -->


                <!-- Space Starts -->
                <tr>
                    <td align="left" valign="middle" height="33" style="font-size: 1px;">&nbsp;</td>
                </tr>
                <!-- Space Ends -->



                 <!-- info section starts here -->

                <tr>
                    <td align="left" valign="middle" style="color:#000000; font-size: 16px; font-weight: 400;">
                        @include("emails.gx.includes.footer_company_info")
                    </td>
                </tr>
                {{-- <tr>
                    <td align="left" valign="middle" style="font-size: 1px;">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <td align="left" valign="middle" style="color:#000000; font-size: 16px; font-weight: 400;">
                                    {{setting('gx.company_name')}}
                                </td>
                            </tr>

                            <tr>
                                <td align="left" valign="middle" height="3" style="font-size: 1px;">&nbsp;</td>
                            </tr>

                            <tr>
                                <td align="left" valign="middle" style="font-size: 16px; font-weight: 400;line-height: 1.8; color:#000000;">
                                    @if(setting('gx.contact_number'))
                                        {{setting('gx.contact_number')}}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td align="left" valign="middle" style="font-size: 16px; font-weight: 400;line-height: 1.8; color:#000000;">
                                    @if(setting('gx.support_email'))
                                        <x-mail-to style="text-decoration: none;" :link="setting('gx.support_email')"/>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td align="left" valign="middle" style="color:#000000; font-size: 16px; font-weight: 400;">
                                    @if(setting('gx.home_page_link'))
                                        <x-anchor-tag :link="setting('gx.home_page_link')"
                                                      :title="setting('gx.title')"
                                                      style="text-decoration: none"></x-anchor-tag>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>--}}
                <!-- info section ends here -->

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
