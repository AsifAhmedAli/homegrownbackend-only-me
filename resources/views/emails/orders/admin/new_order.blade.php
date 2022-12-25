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
        <td style="padding: 30px 0px 10px;">
            <table style="border-collapse: collapse;
                                    min-width: 320px;
                                    max-width: 760px;
                                    width: 100%;
                                    margin: auto;"
            >
                <tbody>
                <tr>
                    <td align="left" valign="middle">

                        <p style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5; margin-bottom: 3px; margin-left: 20px;">Hi HGP Admin,</p>

                        <p style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5; margin-bottom: 3px; margin-top: 5px; margin-left: 20px;">
                            A customer order has been received. Please visit the site for further details.
                        </p>
                    </td>
                </tr>

                </tbody>
            </table>
        </td>
    </tr>

    <tr>
        <td align="left" valign="middle" height="30" style="font-size: 1px;">&nbsp;
        </td>
    </tr>
    <!-- Space Ends -->
    <tr>
        <td bgcolor="#FFF" style="background-color: #FFF;">

            <table cellpadding="0" cellspacing="0" border="0" width="760" align="center"
                   style="font-family: arial; font-size: 15px; color: #000; margin: 0 auto;" class="fullTbl">

                <tr>
                    <td align="left" valign="top" height="3" bgcolor="#000000"
                        style="font-size:1px; background-color:#dddddd;">&nbsp;
                    </td>
                </tr>

                <tr>
                    <td style="color: #FFF;">

                        <!-- Footer for large Devices Starts -->
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">

                            <!-- Space Starts -->
                            <tr>
                                <td align="left" valign="middle" height="19" style="font-size: 1px;">&nbsp;
                                </td>
                            </tr>
                            <!-- Space Ends -->

                            <!-- Two Column Section Starts -->
                            <tr>

                                <td valign="middle">
                                    <!--[if mso]>
                                    <table border="0" cellspacing="0" cellpadding="0" align="center"
                                           width="650">
                                        <tr>
                                            <td align="left" valign="middle" width="650">
                                    <![endif]-->

                                    <!-- Footer Left Column Starts -->
                                    <div style="display:inline-block; margin:0px -2px; max-width:100%; vertical-align:middle; width:100%;padding-bottom:0px;"
                                         class="center-ftcontent ft-soc">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td height="50" align="center" valign="middle"
                                                    style="font-family: 'Lato', sans-serif; font-weight: normal; font-size: 14px; color: #555555;">
                                                    @if(setting('site.facebook'))
                                                        <a href="{{setting('site.facebook')}}"
                                                           target="_blank"
                                                           style="text-decoration:none; color: #555555;">
                                                            <img src="{{asset('admin-assets/images/facebook.png')}}"
                                                                 style="border:none; outline:none;"
                                                                 alt="Facebook"/>
                                                        </a>
                                                    @endif

                                                    @if(setting('site.twitter'))
                                                        <a href="{{setting('site.twitter')}}"
                                                           target="_blank"
                                                           style="text-decoration:none; color: #555555;">
                                                            <img src="{{asset('admin-assets/images/twitter.png')}}"
                                                                 style="border:none; outline:none;"
                                                                 alt="Twitter"/>
                                                        </a>
                                                    @endif

                                                    @if(setting('site.pinterest'))
                                                        <a href="{{setting('site.pinterest')}}"
                                                           target="_blank"
                                                           style="text-decoration:none; color: #555555;">
                                                            <img src="{{asset('admin-assets/images/pintrest.png')}}"
                                                                 style="border:none; outline:none;"
                                                                 alt="Pintrest"/>
                                                        </a>
                                                    @endif

                                                    @if(setting('site.instagram'))
                                                        <a href="{{setting('site.instagram')}}"
                                                           target="_blank"
                                                           style="text-decoration:none; color: #555555;">
                                                            <img src="{{asset('admin-assets/images/insta.png')}}"
                                                                 style="border:none; outline:none;"
                                                                 alt="Instagram"/>
                                                        </a>
                                                    @endif

                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- Footer Left Column Ends -->

                                    <!--[if mso]>
                                    </td>
                                    </tr>
                                    </table>
                                    <![endif]-->

                                </td>

                            </tr>
                            <!-- Two Column Section Ends -->

                            <!-- Space Starts -->
                            <tr>
                                <td align="left" valign="middle" height="15" style="font-size: 1px;">&nbsp;
                                </td>
                            </tr>
                            <!-- Space Ends -->

                        </table>
                        <!-- Footer for large Devices Ends -->

                    </td>
                </tr>

            </table>

        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
