<div class="form-group">
    <label class="control-label" for="status">Status</label>

    <select name="status" id="status" class="select2">
        <option value="">--- Select Status ---</option>

        @foreach (\App\Utils\Helpers\Helper::reportStatuses() as $name => $label)
            <option value="{{ $name }}" {{ request('status') === $name ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>
