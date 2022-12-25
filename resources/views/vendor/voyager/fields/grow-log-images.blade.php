<br>
@if(isset($dataTypeContent->{$row->field}))
    <?php $images = json_decode($dataTypeContent->{$row->field}); ?>
    @if($images != null)
        @foreach($images as $image)
            <div class="img_settings_container" data-field-name="{{ $row->field }}" style="float:left;padding-right:15px;">
                <a href="#" class="voyager-x remove-multi-image" style="position: absolute;"></a>
                <a class="example-image-link" href="{{ Voyager::image( $image->download_link ) }}" data-lightbox="example-set" >
                    <img class="example-image" src="{{ Voyager::image( $image->download_link ) }}" data-file-name="{{ $image->download_link }}" data-id="{{ $dataTypeContent->getKey() }}" style="max-width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:5px;">
                </a>
            </div>
        @endforeach
    @endif
@endif
<div class="clearfix"></div>
<input @if($row->required == 1 && !isset($dataTypeContent->{$row->field})) required @endif type="file" name="{{ $row->field }}[]" multiple="multiple" accept="image/*">
