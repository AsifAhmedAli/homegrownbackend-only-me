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
                                    max-width: 600px;
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
                                                margin: 0 0 15px;
                                                color: #000000;"
                            >
                                {{ $heading }}
                            </h4>
                        </td>
                    </tr>
                @endisset

                <tr>
                    <td style="padding: 0;">
                        <p>
                            Welcome to the future of personal cannabis cultivation! By signing up with GX you have put yourself ahead of the game: you now have access to the newest and best information and technology about growing cannabis at home!
                        </p>
                        <p>
                            Now that you are on board, make sure to explore the site and its features:
                        <ul>
                            <li>
                                Watch informational videos to answer all of your questions
                            </li>
                            <li>
                                Learn about our mission, and who we are
                            </li>
                            <li>
                                Explore pricing on all of our plans and equipment
                            </li>
                            <li>
                                See social media posts from our team and customers
                            </li>
                            <li>
                                Get in touch with experts 24/7
                            </li>
                        </ul>
                        </p>
                        <p>
                            Thanks to new technologies, it has never been easier to grow your own cannabis, and with help from our staff of experts, GX can get you started at the click of a button.

                        </p>

                        @include("emails.gx.includes.footer_company_info")


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
