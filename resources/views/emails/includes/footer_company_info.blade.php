
<p style=" font-size: 16px;"><strong>Homegrown Pros</strong></p>
{{--
@if(setting('site.company_name'))
@endif

@if(setting('site.contact_number'))
<p style="font-size: 16px;">{{setting('site.contact_number')}}</p>
@endif

@if(setting('site.support_email'))
    <p style="font-size: 16px;"><x-mail-to :link="setting('site.support_email')" style="text-decoration: none"/></p>
@endif
<p style="font-size: 16px;">
<x-anchor-tag :link="setting('site.home_page_link')"
              :title="setting('site.title')"
              style="text-decoration: none"></x-anchor-tag>
</p>
--}}
