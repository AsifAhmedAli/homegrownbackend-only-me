<tr>
    <td align="left" valign="middle" style="font-size: 1px;">
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td align="center" valign="middle" style="color:#000000; font-size: 16px; font-weight: 700;">
                    GROW Team
                </td>
            </tr>

            <tr>
                <td align="center" valign="middle" height="3" style="font-size: 1px;">&nbsp;</td>
            </tr>

            <tr>
                <td align="center" valign="middle" style="font-size: 16px; font-weight: 400;line-height: 1.8; color:#000000;">
                    @if(isset($settings['site.email']) && !empty($settings['site.email']))
                        <a href="mailto:{{$settings['site.email']}}" style="color:#000000;">
                            {{$settings['site.email']}}
                        </a>
                    @endif
                </td>
            </tr>

            <tr>
                <td align="center" valign="middle" style="color:#000000; font-size: 16px; font-weight: 400;">
                    @if(isset($settings['site.contact_number']) && !empty($settings['site.contact_number']))
                        {{$settings['site.contact_number']}}
                    @endif
                </td>
            </tr>
        </table>
    </td>
</tr>
