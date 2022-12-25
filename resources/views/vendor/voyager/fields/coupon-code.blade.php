@if($view === 'add' || $view === 'edit')
       <input @if($row->required == 1) required @endif type="text" id="coupon-code" class="form-control" name="{{ $row->field }}"
       placeholder="{{ old($row->field, $options->placeholder ?? $row->getTranslatedAttribute('display_name')) }}"
       {!! isBreadSlugAutoGenerator($options) !!}
       value="{{ old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '') }}">
       <a href="javascript:" id="generate-code">Generate Code</a>
@else
       {{ $content }}
@endif
