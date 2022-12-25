@if(isset($dataTypeContent->{$row->field}))
    @if(json_decode($dataTypeContent->{$row->field}) !== null)
        @foreach(json_decode($dataTypeContent->{$row->field}) as $file)
            <div data-field-name="{{ $row->field }}">
                <a class="fileType" target="_blank"
                   href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}"
                   data-file-name="{{ $file->original_name }}" data-id="{{ $dataTypeContent->getKey() }}">
                    <img src="{!! \App\Utils\Helpers\Helper::getImageIcon($file->original_name) !!}" style="width:24px"> {{ $file->original_name ?: '' }}
                </a>
                <a href="javascript:void(0)" class="voyager-x remove-multi-file" ></a>
            </div>
        @endforeach
    @else
        <div data-field-name="{{ $row->field }}">
            <a class="fileType" target="_blank"
               href="{{ Storage::disk(config('voyager.storage.disk'))->url($dataTypeContent->{$row->field}) }}"
               data-file-name="{{ $dataTypeContent->{$row->field} }}" data-id="{{ $dataTypeContent->getKey() }}">>
                Download
            </a>
            <a href="javascript:void(0)" class="voyager-x remove-single-file"></a>
        </div>
    @endif
@endif
@php
    $fieldValue = json_decode($dataTypeContent->{$row->field})
@endphp
<input @if($row->required == 1 && !isset($dataTypeContent->{$row->field})) required @endif
        type="file"
       name="{{ $row->field }}[]" id="files" onchange="validateFile();"
       @if(!property_exists($row->details, 'single')) multiple="multiple" @endif
       @if( is_countable($fieldValue) && count($fieldValue) && property_exists($row->details, 'single'))
       style="display:none" @endif
>
