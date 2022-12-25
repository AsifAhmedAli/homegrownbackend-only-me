@php
       $edit = !is_null($dataTypeContent->getKey());
@endphp
<input @if($row->required == 1) required @endif
@if(isset($options->required)) required @endif
       @if(isset($options->min)) min="{{ $options->min }}" @endif
       @if($edit && isset($options->readonly)) readonly @endif
       @if(isset($options->max)) max="{{ $options->max }}" @endif
       @if(isset($options->maxlength)) maxlength="{{ $options->maxlength }}" @endif
       @if(isset($options->size)) size="{{ $options->size }}" @endif
       @if($row->required == 1) required @endif type="text" class="form-control" name="{{ $row->field }}"
       placeholder="{{ old($row->field, $options->placeholder ?? $row->getTranslatedAttribute('display_name')) }}"
       {!! isBreadSlugAutoGenerator($options) !!}
       value="{{ old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '') }}">
