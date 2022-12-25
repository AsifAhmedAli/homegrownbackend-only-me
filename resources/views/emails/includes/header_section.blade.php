<tr>
    <td>
        <table cellpadding="0" cellspacing="0" border="0" width="100%">

            <!-- Logo Starts -->
            <tr>
                <td align="center" valign="middle">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">

                        <!-- Space Starts -->
                        <tr>
                            <td height="10" align="center" valign="middle"
                                style="font-size: 1px;">&nbsp;
                            </td>
                        </tr>
                        <!-- Space Ends -->

                    @if(!is_null(setting('site.logo')))
                        <!-- Logo Image Starts -->
                            <tr>
                                <td height="53" align="center" valign="middle"
                                    style="font-family: 'Lato', sans-serif; font-weight: bold; font-size: 20px; color: #0a0c3b;">
                                    <a href="{{setting('site.home_page_link')? setting('site.home_page_link'): '/'}}"
                                       style="text-decoration:none; color: #0a0c3b;">
                                        <img src="{{Voyager::image(setting('site.logo'))}}"
                                             alt="HGP"
                                             style="border:none; outline:none; max-width: 100%;"/>
                                    </a>
                                </td>
                            </tr>
                            <!-- Logo Image Ends -->
                        @else
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
                    @endif

                    <!-- Space Starts -->
                        <tr>
                            <td height="10" align="center" valign="middle"
                                style="font-size: 1px;">&nbsp;
                            </td>
                        </tr>
                        <!-- Space Ends -->

                        <!-- Bottom Full Width Border Starts -->
                        <tr>
                            <td align="left" valign="top" height="3" bgcolor="#dddddd"
                                style="font-size:1px; background-color:#dddddd;">&nbsp;
                            </td>
                        </tr>
                        <!-- Bottom Full Width Border Ends -->

                    </table>
                </td>
            </tr>
            <!-- Logo Ends -->

            <!-- Menu Section Starts -->
            <tr>
                <td align="center" valign="middle">

                    <!-- Menu Section for large devices Starts -->
                    <table cellpadding="0" cellspacing="0" border="0" width="100%"
                           class="hide">

                        <!-- Space Starts -->
                        <tr>
                            <td height="17" style="font-size: 1px;">&nbsp;</td>
                        </tr>
                        <!-- Space Ends -->

                        <!-- Menu Starts -->
                        <tr>
                            <td align="center">
                                @if(setting('site.home_page_link'))
                                    <a href="{{setting('site.home_page_link')? setting('site.home_page_link'): env('WEB_URL') }}"
                                       style="font-family: 'Lato', sans-serif; font-weight: normal; font-size: 14px; color: #545454; text-decoration: none;">Home</a>
                                @endif
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    @if(setting('site.about_us_page_link'))
                                        <a href="{{setting('site.about_us_page_link')? setting('site.about_us_page_link') : env('WEB_URL') }}"
                                           style="font-family: 'Lato', sans-serif; font-weight: normal; font-size: 14px; color: #545454; text-decoration: none;">About Us</a>
                                    @endif
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                @if(setting('site.contact_us_page_link'))
                                    <a href="{{setting('site.contact_us_page_link')? setting('site.contact_us_page_link') : env('WEB_URL') }}"
                                       style="font-family: 'Lato', sans-serif; font-weight: normal; font-size: 14px; color: #545454; text-decoration: none;">Contact us</a>
                                @endif
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    @if(setting('site.home_page_link'))
                                        <a href="{{setting('site.home_page_link')? setting('site.home_page_link') : env('WEB_URL') }}"
                                           style="font-family: 'Lato', sans-serif; font-weight: normal; font-size: 14px; color: #545454; text-decoration: none;">Shop</a>
                                    @endif
                            </td>
                        </tr>
                        <!-- Menu Ends -->

                        <!-- Space Starts -->
                        <tr>
                            <td height="20" style="font-size: 1px;">&nbsp;</td>
                        </tr>
                        <!-- Space Ends -->

                    </table>
                    <!-- Menu Section for large devices Ends -->


                </td>
            </tr>
            <!-- Menu Section Ends -->

        </table>
    </td>
</tr>
