@if($view === 'add' || $view === 'edit')
    <input type="number"
           class="form-control"
           name="{{ $row->field }}"
           required
           min="0"
           placeholder="{{ old($row->field, $options->placeholder ?? $row->getTranslatedAttribute('display_name')) }}"
           value="{{ old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '') }}">
@else
    @if($view === 'read')
        @php $tempData = $dataTypeContent @endphp
    @endif
    @if($view === 'browse')
        @php $tempData = $data @endphp
    @endif
    @if($tempData->type === \App\Utils\Constants\DropDown::PERCENT_SITE_WIDE || $tempData->type === \App\Utils\Constants\DropDown::PERCENT_CATEGORY || $tempData->type === \App\Utils\Constants\DropDown::PERCENT_PRODUCT)
        {{ $content }}%
    @else
        ${{ $content }}
    @endif
@endif
