<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="x-ua-compatible" content="IE=edge">

    <title>Your inquiry has been successfully sent</title>

    <style type="text/css">

        /* Basic Email Setters Starts */
        html,body {
            margin:0 !important;
            padding:0 !important;
            height:100% !important;
            width:100% !important;
        }
        * {
            -ms-text-size-adjust:100%;
            -webkit-text-size-adjust:100%;
        }
        table,td {
            mso-table-lspace:0 !important;
            mso-table-rspace:0 !important;
            font-family: 'Lato', sans-serif;
        }
        table {
            border-spacing:0 !important;
            border-collapse:collapse !important;
            table-layout:fixed !important;
            margin:0 auto !important;
        }
        table table table {
            table-layout:auto;
        }
        img {
            -ms-interpolation-mode:bicubic;
        }
        .yshortcuts a {
            border-bottom:none !important;
        }
        a[x-apple-data-detectors] {
            color:inherit !important;
        }
        a {
            transition:all 100ms ease-in;
        }
        .mobilecontent{
            max-height:0px;
            overflow:hidden;
        }
        @media screen and (min-width: 650px) {
            .ftspace, .lrspace{
                max-height:0 !important;
                display:none !important;
                mso-hide:all !important;
                overflow:hidden !important;
            }
        }

        @media screen and (max-width: 649px) {
            .fullTbl{
                width:100%;
            }
            div[class="mobilecontent"] {
                display:block !important;
                max-height:none !important;
            }
            .mobilecontent {
                display:block !important;
                max-height:none !important;
            }
            .hide {
                max-height:0 !important;
                display:none !important;
                mso-hide:all !important;
                overflow:hidden !important;
            }


            .stack-column,
            .stack-column-center,
            .center-ftcontent,
            .tgrey{
                display:block !important;
                width:100% !important;
                max-width:100% !important;
                direction:ltr !important;
            }
            .tgrey{
                text-align: center;
            }
            .tgrey table{
                float: none;
                text-align: center;
            }
            .center-ftcontent td,
            .tgrey td {
                text-align:center;
            }

            /* And center justify these ones. */
            .stack-column-center {
                text-align:center !important;
            }

            /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align:center !important;
                display:block !important;
                margin-left:auto !important;
                margin-right:auto !important;
                float:none !important;
            }

            table.center-on-narrow {
                display:inline-block !important;
            }

            /* Top Grey Bar */
            .greyCell{
                height:50px;
            }
            .tgCell{
                height:25px;
            }

            /* Hero Banner */
            .heroBanner td{
                height: auto!important;
            }

            /* Feature Section */
            .fhtheight{
                height:15px;
            }

            /* Top Category Section */
            .tc-img td{
                height: auto!important;
                padding-bottom:8px;
            }
            .tc-mrow{
                padding-left:11px;
                padding-right:11px;
            }

            /* Disclaimer */
            .whiteCell{
                background-color:#FFF;
            }

            /* Footer */
            .ft-soc td{
                vertical-align:top;
            }

        }

        /* Media Queries */
        @media screen and (max-width: 480px) {


            /* Top Category Section */
            .tc-img td{
                padding-left:8px;
                padding-right:8px;
                padding-bottom:0px;
            }
            .topc-column {
                display:block !important;
                width:100% !important;
                max-width:100% !important;
                direction:ltr !important;
            }
            .topc-column img{
                max-width: 310px!important;
            }
        }
    </style>

</head>


<body style="margin: 0; padding: 0;">

<!-- Google Live Font Link -->
<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet" />

<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family: arial; font-size: 15px; color: #000; margin: 0 auto;">

    <!-- Top Grey Bar Starts -->
    @include('emails.includes.top-gray')
    <!-- Top Grey Bar Ends -->

    <!-- Body Section Starts -->
    <tr>
        <td>

            <table cellpadding="0" cellspacing="0" border="0" width="650" align="center" style="font-family: arial; font-size: 15px; color: #000; margin: 0 auto;" class="fullTbl">

                <!-- Header Section Starts -->
                @include('emails.includes.header_section')
                <!-- Header Section Ends -->


                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" border="0" width="610" align="center" style="font-family: arial; font-size: 15px; color: #000; margin: 0 auto;">
                            <!-- Space Starts -->
                <tr>
                    <td align="left" valign="middle" height="23" style="font-size: 1px;">&nbsp;</td>
                </tr>
                <!-- Space Ends -->

                <tr>
                    <td align="left" valign="middle" >
{{--                       <h1 style="font-size: 25px; font-weight: 700; color:#000000;">Thanks for your message!</h1>--}}
                        <p style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">{!! $body !!}</p>
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
                            @include('emails.includes.footer_company_info')
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                {{--<tr>
                    <td align="left" valign="middle" style="font-size: 1px;">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <td align="left" valign="middle" style="color:#000000; font-size: 16px; font-weight: 400;">
                                    {{setting('site.company_name')}}
                                </td>
                            </tr>

                            <tr>
                                <td align="left" valign="middle" height="3" style="font-size: 1px;">&nbsp;</td>
                            </tr>

                            <tr>
                                <td align="left" valign="middle" style="font-size: 16px; font-weight: 400;line-height: 1.8; color:#000000;">
                                    @if(setting('site.contact_number'))
                                        {{setting('site.contact_number')}}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td align="left" valign="middle" style="font-size: 16px; font-weight: 400;line-height: 1.8; color:#000000;">
                                    @if(setting('site.support_email'))
                                        <x-mail-to style="text-decoration: none" :link="setting('site.support_email')"/>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td align="left" valign="middle" style="color:#000000; font-size: 16px; font-weight: 400;">
                                    @if(setting('site.home_page_link'))
                                        <x-anchor-tag :link="setting('site.home_page_link')"
                                                      :title="setting('site.title')"
                                                      style="text-decoration: none"></x-anchor-tag>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>--}}
                <!-- info section ends here -->

                <!-- Space Starts -->
                <tr>
                    <td align="left" valign="middle" height="18" style="font-size: 1px;">&nbsp;</td>
                </tr>
                <!-- Space Ends -->
                        </table>
                    </td>
                </tr>


            </table>

        </td>
    </tr>
    <!-- Body Section Ends -->


    <!-- Footer Section Starts -->
@include('emails.includes.footer_section')
    <!-- Footer Section Ends -->

</table>

</body>
</html>
