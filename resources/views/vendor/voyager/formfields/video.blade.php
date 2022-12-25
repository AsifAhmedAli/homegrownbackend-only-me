@if(isset($dataTypeContent->{$row->field}))
    @if(json_decode($dataTypeContent->{$row->field}) !== null)
        @foreach(json_decode($dataTypeContent->{$row->field}) as $file)
            <div data-field-name="{{ $row->field }}">
                <a class="fileType" target="_blank"
                   style="display: none"
                   href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}"
                   data-file-name="{{ $file->original_name }}" data-id="{{ $dataTypeContent->getKey() }}">
                    <img src="{!! \App\Utils\Helpers\Helper::getImageIcon($file->original_name) !!}" style="width:24px"> {{ $file->original_name ?: '' }}
                </a>
                <video width="600" height="340" controls>
                    <source src="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" type="video/mp4">
                    <source src="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" type="video/ogg">
                    Your browser does not support the video tag.
                </video>
                <a href="javascript:void(0)" class="voyager-x remove-multi-file btn btn-danger" style="width:600px">Remove</a>
            </div>
        @endforeach
    @else
        @if($dataTypeContent->{$row->field})
        <div data-field-name="{{ $row->field }}">
            <a class="fileType" target="_blank"
               href="{{ Storage::disk(config('voyager.storage.disk'))->url($dataTypeContent->{$row->field}) }}"
               data-file-name="{{ $dataTypeContent->{$row->field} }}" data-id="{{ $dataTypeContent->getKey() }}">>
                Download
            </a>
            <a href="javascript:void(0)" class="voyager-x remove-single-file btn btn-danger" style="width:600px">Remove</a>
        </div>
        @endif
    @endif
@endif
@php
    $fieldValue = json_decode($dataTypeContent->{$row->field})
@endphp
<input @if($row->required == 1 && !isset($dataTypeContent->{$row->field})) required @endif
        type="file"
       name="{{ $row->field }}" id="files"
       @if(!property_exists($row->details, 'single')) multiple="multiple" @endif
       @if( is_countable($fieldValue) && count($fieldValue) && property_exists($row->details, 'single'))
       style="display:none" @endif
       accept="video/mp4"
>

<input type="hidden" value="{{$dataTypeContent->{$row->field} }}" id="old_video_url" name="old_{{ $row->field }}">


@push('javascript')
    <script>
       $(document).ready(function() {
           $('#files').on('change', function(e) {
              if (e.target.files[0].type !== 'video/mp4') {
                  alert('MP4 video file is required');
                  $(this).val('')
              }
           })
       })
    </script>
@endpush
