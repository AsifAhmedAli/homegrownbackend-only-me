<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="x-ua-compatible" content="IE=edge">

    <title>Thank you for Registeration</title>

    <style type="text/css">

        /* Basic Email Setters Starts */
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table, td {
            mso-table-lspace: 0 !important;
            mso-table-rspace: 0 !important;
            font-family: 'Lato', sans-serif;
        }

        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        table table table {
            table-layout: auto;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        .yshortcuts a {
            border-bottom: none !important;
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
        }

        a {
            transition: all 100ms ease-in;
        }

        .mobilecontent {
            max-height: 0px;
            overflow: hidden;
        }

        @media screen and (min-width: 650px) {
            .ftspace, .lrspace {
                max-height: 0 !important;
                display: none !important;
                mso-hide: all !important;
                overflow: hidden !important;
            }
        }

        @media screen and (max-width: 649px) {
            .fullTbl {
                width: 100%;
            }

            div[class="mobilecontent"] {
                display: block !important;
                max-height: none !important;
            }

            .mobilecontent {
                display: block !important;
                max-height: none !important;
            }

            .hide {
                max-height: 0 !important;
                display: none !important;
                mso-hide: all !important;
                overflow: hidden !important;
            }


            .stack-column,
            .stack-column-center,
            .center-ftcontent,
            .tgrey {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }

            .tgrey {
                text-align: center;
            }

            .tgrey table {
                float: none;
                text-align: center;
            }

            .center-ftcontent td,
            .tgrey td {
                text-align: center;
            }

            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }

            /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }

            table.center-on-narrow {
                display: inline-block !important;
            }

            /* Top Grey Bar */
            .greyCell {
                height: 50px;
            }

            .tgCell {
                height: 25px;
            }

            /* Hero Banner */
            .heroBanner td {
                height: auto !important;
            }

            /* Feature Section */
            .fhtheight {
                height: 15px;
            }

            /* Top Category Section */
            .tc-img td {
                height: auto !important;
                padding-bottom: 8px;
            }

            .tc-mrow {
                padding-left: 11px;
                padding-right: 11px;
            }

            /* Disclaimer */
            .whiteCell {
                background-color: #FFF;
            }

            /* Footer */
            .ft-soc td {
                vertical-align: top;
            }

        }

        /* Media Queries */
        @media screen and (max-width: 480px) {


            /* Top Category Section */
            .tc-img td {
                padding-left: 8px;
                padding-right: 8px;
                padding-bottom: 0px;
            }

            .topc-column {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }

            .topc-column img {
                max-width: 310px !important;
            }
        }
    </style>

</head>


<body style="margin: 0; padding: 0;">

<!-- Google Live Font Link -->
<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i"
      rel="stylesheet"/>

<table cellpadding="0" cellspacing="0" border="0" width="100%"
       style="font-family: arial; font-size: 15px; color: #000; margin: 0 auto;">

    <!-- Top Grey Bar Starts -->
    @include('emails.includes.top-gray')
    <!-- Top Grey Bar Ends -->

    <!-- Body Section Starts -->
    <tr>
        <td>

            <table cellpadding="0" cellspacing="0" border="0" width="650" align="center"
                   style="font-family: arial; font-size: 15px; color: #000; margin: 0 auto;" class="fullTbl">

                <!-- Header Section Starts -->
                     @include('emails.includes.header_section')
                <!-- Header Section Ends -->


                <!-- Space Starts -->
                <tr>
                    <td align="left" valign="middle" height="29" style="font-size: 1px;">&nbsp;</td>
                </tr>
                <!-- Space Ends -->
                <tr>
                    <td align="center" valign="middle" height="100" style="font-size: 1px;">
                        <img src="https://growxai.org/storage/Giveaway/WhatsApp%20Image%202023-01-23%20at%2011.30.30%20PM.jpeg" height="100"/>            
                    </td>
                </tr>

                <!-- Sub Division Section Starts -->
                <tr>
                    <td align="left" valign="middle">

                        <table cellpadding="0" cellspacing="0" border="0" width="650" align="center"
                               style="font-family: arial; font-size: 15px; color: #000; margin: 0 auto;"
                               class="fullTbl">
                            <tr>
                                <td align="left" valign="top" width="550">

                                    <table cellpadding="0" cellspacing="0" border="0" width="500"
                                           align="center"
                                           style="font-family: arial; font-size: 15px; color: #000; margin: 0 0 0 20px!important;"
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
                                                    margin: 0px 0px 10px;"> Hi {{ $name }},</p>
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
                                                Lets Growww!
            <br><br><br>
            Thank you for registering in our launch day MambaLine giveaway. Congratulations, you are now officially eligible to win our game changing, trailblazing, MambaLine GrowKit. Not only that, but you now have multiple chances to win weekly prizes from some of the dopest companies in the industry. Together we are changing the game. We would wish you luck, but here at HomeGrown Pros, we believe you can grow your own.
            <br><br>
            WANT TO DOUBLE YOUR CHANCES TO WIN? 
            <br>
            <br>
            It’s easy…
            <br>
            <br>
            Share any of our social media giveaway post on Instagram @homegrownpros.io and tag 3 growers or wannabe growers for one (1) extra entry into our MambaLine giveaway. 
            <br>
            <br>
            Hey, Thanks again for your registration. We look forward to guiding you on your grow journey.
            <br>
            <br>
            Happiness and Growth, 
            <br>
            <br>
            Your HomeGrown Team. 💚
            <br><a href="https://homegrownpros.io/">homegrownpros.io</a>
            <br>
            <br>
            <br>
            Need the Mambaline <a href='https://calendly.com/hgpros/growpro-consultation-free-clone'>GrowKit now</a>? Secure yours with as little as $500 down, and be first in line in your cannabis state.
            <br>
            <br>
            <br>
            Need our team of GrowPros we are here to help you on your grow journey. <a href='https://calendly.com/hgpros/growpro-consultation-free-clone'>Click here</a> to schedule your a free GrowPro consultation to see what Growkit line and grow method is right for you and get max Early Bird Specials. (Update link to calendly) 
            <br>
            <br>
            <br>
            ***Must email a screenshot of your share and tags to <a href='mailto:I.shared@thehomegrownpros.com'>I.shared@thehomegrownpros.com</a> to be credited with one (1) additional entry. It’s that easy, show us some love and double your chances.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="middle"
                                                style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                                                <br>&nbsp;
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <td align="left" valign="middle"
                                                style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                                                Need the <a href="{{ env('WEB_URL').'/kit/6' }}" style="text-decoration: none;">Mambaline GrowKit</a>  now? Secure yours with as little as $500 down, and be first in line in your cannabis state.
                                            </td>
                                        </tr> -->
                                        <!-- <tr>
                                            <td align="left" valign="middle"
                                                style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                                                <br>&nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="middle"
                                                style="font-size: 16px; font-weight: 400; color:#000000; line-height: 1.5;">
                                                If you need our team of GrowPros we are here to help you on your grow journey. <a href="{{ env('WEB_URL').'/contact-us' }}" style="text-decoration: none;">Click here</a> to schedule your GrowPro consultation to see what Growkit line is right for you.    
                                            </td>
                                        </tr> -->

                                        <!-- Space Starts -->
                                        <tr>
                                            <td align="left" valign="middle" height="25"
                                                style="font-size: 1px;">&nbsp;
                                            </td>
                                        </tr>
                                        <!-- Space Ends -->

                                        <tr>
                                            <td align="left" valign="middle">

                                                
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="left" valign="middle">
                                                
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="left" valign="middle">
                                            </td>
                                        </tr>

                                        <!-- Space Starts -->
                                        <tr>
                                            <td align="left" valign="middle" height="12"
                                                style="font-size: 1px;">&nbsp;
                                            </td>
                                        </tr>
                                        <!-- Space Ends -->




                                        <!-- Space Starts -->
                                        <tr>
                                            <td align="left" valign="middle" height="12"
                                                style="font-size: 1px;">&nbsp;
                                            </td>
                                        </tr>
                                        <!-- Space Ends -->


                                        <!-- Space Starts -->
                                        <tr>
                                            <td align="left" valign="middle" height="22"
                                                style="font-size: 1px;">&nbsp;
                                            </td>
                                        </tr>
                                        <!-- Space Ends -->

                                    </table>

                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>


                <!-- Sub Division Section Ends -->


                <!-- Space Starts -->
                <tr>
                    <td align="left" valign="middle" height="18" style="font-size: 1px;">&nbsp;</td>
                </tr>
                <!-- Space Ends -->


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
