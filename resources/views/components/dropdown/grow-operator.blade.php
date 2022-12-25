<select class="form-control select2-ajax select2-hidden-accessible" name="{{ $name }}" data-get-items-route="{{ route('admin.user.grow-operator.search') }}" data-method="edit" tabindex="-1" aria-hidden="true">
    <option value="">None</option>
    @if($value)
        <option selected value="{{ $value }}">{{ $valueName }}</option>
    @endif
</select>
