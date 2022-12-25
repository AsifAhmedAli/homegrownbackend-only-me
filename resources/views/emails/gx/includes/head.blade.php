<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <title>{{ $title ?? 'Reset Password' }}</title>
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
