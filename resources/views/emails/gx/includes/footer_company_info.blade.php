<x-paragraph style="margin-bottom: 0px; margin-top: 35px;" description="Happy growing!"> </x-paragraph>
<p style="margin-bottom: 10px;">The GrowX Team<p>

{{--@if(setting('gx.company_name'))

@endif--}}

{{--@if(setting('gx.contact_number'))
       <x-paragraph :description="setting('gx.contact_number')"> </x-paragraph>
@endif

@if(setting('gx.support_email'))
    <p>
        <x-mail-to :link="setting('gx.support_email')" style="text-decoration: none;" />
    </p>
@endif
<p>
    <x-anchor-tag :link="setting('gx.home_page_link')"
                  :title="setting('gx.title')"
                  style="text-decoration: none"></x-anchor-tag>
</p>--}}
