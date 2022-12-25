<!DOCTYPE html>
<html lang="en" style="-ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%;
                    -webkit-print-color-adjust: exact;"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet">
</head>

<body style="font-family: 'Open Sans', sans-serif;
                font-size: 15px;
                min-width: 320px;
                margin: 0;"
>
<table style="border-collapse: collapse; width: 100%;">
    <tbody>

    <!-- <tr>
        <td style="padding: 0;">
            <table style="border-collapse: collapse; width: 100%;">
                <tbody>
                <tr>
                    <td style="background: #000000; text-align: center; height:35px">

                    </td>
                </tr>

                <tr>
                    <td text-align: center;
                    ">
                    @if (is_null($logo))
                            <h5 style="font-size: 30px;
                                                    line-height: 36px;
                                                    margin: 0;
                                                    padding: 30px 15px;
                                                    text-align: center;"
                            >
                                <a href="{{ env('WEB_URL') }}" style="font-family: 'Open Sans', sans-serif;
                                                                                    font-weight: 400;
                                                                                    color: #000000;
                                                                                    text-decoration: none;"
                                >
                                    {{ setting('site.title') }}
                                </a>
                            </h5>
                    @else
                        <div style="display: block;
                                                        height: 64px;
                                                        /*width: 200px;*/
                                                        /* width: 100%; */
                                                        text-align: center;
                                                        padding: 30px 15px 0; "
                        >
                            <a href="{{ env('WEB_URL') }}" style="font-family: 'Open Sans', sans-serif;
                                                                                    font-weight: 400;
                                                                                    color: #000000;
                                                                                    text-decoration: none;"
                            ><img src="{{Voyager::image($logo)}}"
                                  alt="{{setting('site.title')}}"
                                  style="border:none; outline:none; max-width: 100%;"/>
                            </a>
                        </div>
                        @endif
                        </td>
                </tr>

                </tbody>
            </table>
        </td>
    </tr> -->
      <!-- Header Section Starts -->
      @include('emails.includes.header_section')
                <!-- Header Section Ends -->

    <tr>
        <td style="padding: 40px 15px;">
            <table style="border-collapse: collapse;
                                    min-width: 320px;
                                    max-width: 610px;
                                    width: 100%;
                                    margin: auto;"
            >
                @isset($firstName)
                    <tr>
                        <td style="padding: 0;">

                            <p style="font-family: 'Open Sans', sans-serif;
                                                line-height: 26px;
                                                margin: 0 0 20px;
                                                color: #000000;">
                                Hi {{ $firstName }},
                            </p>
                        </td>
                    </tr>
                @endisset

                @isset($heading)
                    <tr>
                        <td style="padding: 0;">
{{--                            <h1 style="font-family: 'Open Sans', sans-serif;--}}
{{--                                font-weight: 600;--}}
{{--                                font-size: 30px;--}}
{{--                                line-height: 26px;--}}
{{--                                margin: 0 0 25px;--}}
{{--                                color: #000000;">--}}
{{--                                                Thanks for signing up!--}}
{{--                            </h1>--}}
                            <h4 style="font-family: 'Open Sans', sans-serif;
                                                font-weight: 400;
                                                font-size: 21px;
                                                line-height: 26px;
                                                margin: 0 0 20px;
                                                color: #000000;"
                            >
                                {!! $heading !!}
                            </h4>
                        </td>
                    </tr>
                @endisset

                <tr>
                    <td style="padding: 0;">
                                    <p style="font-family: 'Open Sans', sans-serif;
                                                font-weight: 400;
                                                font-size: 16px;
                                                line-height: 26px;
                                                color: #000000;
                                                display: block;
                                                margin-bottom: 10px;
                                                margin-top: 0;"
                                    >
                                        {{ $description1 }}
                                    </p>
                        <p style="font-family: 'Open Sans', sans-serif;
                                                font-weight: 400;
                                                font-size: 16px;
                                                line-height: 26px;
                                                color: #000000;
                                                display: block;
                                                margin-bottom: 10px;
                                                margin-top: 0;"
                        >
                                        {{ $description2 }}
                        </p>
                        <p style="font-family: 'Open Sans', sans-serif;
                                                font-weight: 400;
                                                font-size: 16px;
                                                line-height: 26px;
                                                color: #000000;
                                                display: block;
                                                margin-bottom: 0;
                                                margin-top: 35px;"
                        >
                        {{--Thanks!--}}
                        </p>


                       @include('emails.includes.footer_company_info')

                    </td>
                </tr>
            </table>
        </td>
    </tr>

{{--    <tr>--}}
{{--        <td style="padding: 15px 0; background: #000000; text-align: center;">--}}
{{--                        <span style="font-family: 'Open Sans', sans-serif;--}}
{{--                                    font-weight: 400;--}}
{{--                                    font-size: 16px;--}}
{{--                                    line-height: 26px;--}}
{{--                                    display: inline-block;--}}
{{--                                    color: white;--}}
{{--                                    padding: 0 15px;"--}}
{{--                        >--}}
{{--                            &copy; {{ date('Y') }}--}}
{{--                            <a target="_blank" href="{{ env('WEB_URL') }}" style="text-decoration: none; color: white;">--}}
{{--                                {{ setting('site.title') }}.--}}
{{--                            </a>--}}
{{--                            All Rights Reserverd--}}
{{--                        </span>--}}
{{--        </td>--}}
{{--    </tr>--}}
    @include('emails.includes.footer_section')
    </tbody>
</table>
</body>
</html>
