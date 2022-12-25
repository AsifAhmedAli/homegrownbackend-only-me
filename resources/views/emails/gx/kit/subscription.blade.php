@extends('layouts.email')

@section('title', 'Kit Subscription')

@section('content')
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
                    @isset($heading)
                        <tr>
                            <td style="padding: 0;">
                                <h4 style="font-family: 'Open Sans', sans-serif;
                                                font-weight: 400;
                                                font-size: 21px;
                                                line-height: 26px;
                                                margin: 0 0 20px;
                                                color: #000000;"
                                >
                                    {{ $heading }}
                                </h4>
                            </td>
                        </tr>
                    @endisset

                    <tr>
                        <td style="padding: 0;">
                            <x-paragraph :description="$body"> </x-paragraph>
                            <x-paragraph style="margin-bottom: 0px; margin-top: 35px;" description="Thanks!"> </x-paragraph>
                            <!-- company info start -->
                            @include('emails.gx.includes.footer_company_info')
                            <!-- compnay info end -->
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        @include('emails.gx.includes.footer')
        </tbody>
    </table>
@endsection
