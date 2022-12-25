<div class="form-group">
    <label class="control-label" for="group">Group By</label>

    <select name="group" id="group" class="select2">
        <option value="">--- Select Group By ---</option>

        @foreach (\App\Utils\Helpers\Helper::reportGroups() as $group => $label)
            <option value="{{ $group }}" {{ request('group') === $group ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>
