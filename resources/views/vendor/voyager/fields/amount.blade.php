@if($view === 'add' || $view === 'edit')
    <input type="number"
           class="form-control"
           name="{{ $row->field }}"
           required
           min="0"
           placeholder="{{ old($row->field, $options->placeholder ?? $row->getTranslatedAttribute('display_name')) }}"
           value="{{ old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '') }}">
@else
    ${{ $content }}
@endif
