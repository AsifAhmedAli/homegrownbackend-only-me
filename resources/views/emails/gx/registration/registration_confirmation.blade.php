<!DOCTYPE html>
<html lang="en" style="-ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%;
                    -webkit-print-color-adjust: exact;"
>
@include('emails.gx.includes.head')
<body style="font-family: 'Open Sans', sans-serif;
                font-size: 15px;
                margin-bottom: -1px !important;
                min-width: 320px;
                margin: 0;
                 "
>
<table style="border-collapse: collapse; width: 100%;">
    <tbody>
    <!-- Top Grey Bar Starts -->
    @include('emails.gx.includes.top-bar')
    <!-- Top Grey Bar Ends -->
    @include('emails.gx.includes.header')
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
{{--                        <h1 style="font-family: 'Open Sans', sans-serif;--}}
{{--                                                font-weight: 600;--}}
{{--                                                font-size: 30px;--}}
{{--                                                line-height: 26px;--}}
{{--                                                margin: 0 0 25px;--}}
{{--                                                color: #000000;"--}}
{{--                            >--}}
{{--                            Thanks for signing up!--}}
{{--                            </h1>--}}
                            <p style="font-family: 'Open Sans', sans-serif;
                                                margin: 0 0 0;
                                                color: #000000;"
                            >
                                {{ $heading }}
                            </p>
                        </td>
                    </tr>
                @endisset

                <tr>
                    <td style="padding: 0;">
                        <x-paragraph :description="$description1"> </x-paragraph>
                        <x-paragraph :description="$description2"> </x-paragraph>
                        {{--company info start --}}
                        @include('emails.gx.includes.footer_company_info')
                        {{--companyinfo end--}}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    @include('emails.gx.includes.footer')
    </tbody>
</table>
</body>
</html>
