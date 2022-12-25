<tr>
    <td>
        <table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-collapse: collapse;
                                    min-width: 320px;
                                    max-width: 650px;
                                    width: 100%;
                                    margin: auto;">

            <!-- Logo Starts -->
            <tr>
                <td align="center" valign="middle">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">

                        <!-- Space Starts -->
                        <!-- <tr>
                            <td height="10" align="center" valign="middle"
                                style="font-size: 1px;">&nbsp;
                            </td>
                        </tr> -->
                        <!-- Space Ends -->
                    @if(setting('gx.logo'))
                        <!-- Logo Image Starts -->
                            <tr>
                                <td height="53" align="center" valign="middle"
                                    style="font-family: 'Lato', sans-serif; font-weight: bold; font-size: 20px; color: #0a0c3b;">
                                    <a href="{{ setting('gx.home_page_link')}}"
                                       style="text-decoration:none; color: #0a0c3b;">
                                        <img src="{{Voyager::image(setting('gx.logo'))}}"
                                             alt="{{ setting('gx.title')}}"
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
                                <a href="{{ env('WEB_URL_GX') }}" style="font-family: 'Open Sans', sans-serif;
                                                                                    font-weight: 400;
                                                                                    color: #000000;
                                                                                    text-decoration: none;"
                                >
                                    {{ setting('gx.title') }}
                                </a>
                            </h5>
                    @endif

                        <!-- Bottom Full Width Border Starts -->
                        <tr>
                            <td align="left" valign="top" height="3" bgcolor="#57B2AB"
                                style="font-size:1px; background-color:#57B2AB;">&nbsp;
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
                                <x-anchor-tag :link="setting('gx.home_page_link')"
                                              :title="setting('gx.home_page_title')"
                                              style="font-family: 'Lato', sans-serif; font-weight: normal; font-size: 14px; color: #545454; text-decoration: none;"></x-anchor-tag>
                                <x-anchor-tag :link="setting('gx.how_it_works_page_link')"
                                              :title="setting('gx.how_it_works_page_title')"
                                              style="font-family: 'Lato', sans-serif; font-weight: normal; font-size: 14px; color: #545454; text-decoration: none;"></x-anchor-tag>
                                <x-anchor-tag :link="setting('gx.features_page_link')"
                                              :title="setting('gx.feature_page_title')"
                                              style="font-family: 'Lato', sans-serif; font-weight: normal; font-size: 14px; color: #545454; text-decoration: none;"></x-anchor-tag>
                                <x-anchor-tag :link="setting('gx.pricing_page_link')"
                                              :title="setting('gx.pricing_page_title')"
                                              style="font-family: 'Lato', sans-serif; font-weight: normal; font-size: 14px; color: #545454; text-decoration: none;"></x-anchor-tag>
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
