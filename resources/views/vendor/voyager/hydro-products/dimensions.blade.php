@if($selected_values->count() === 0)
    <p>{{ __('voyager::generic.no_results') }}</p>
@else
    <table class="table table-responsive">
        <thead>
        <tr>
            <th width="10">#</th>
            <th width="10">UOM</th>
            <th width="20">Depth</th>
            <th width="20">Height</th>
            <th width="20">Weight</th>
            <th width="20">Width</th>
        </tr>
        </thead>
        <tbody>
        @foreach($selected_values as $key => $selectedValue)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $selectedValue->uom }}</td>
                <td>{{ $selectedValue->depth }}</td>
                <td>{{ $selectedValue->height }}</td>
                <td>{{ $selectedValue->weight }}</td>
                <td>{{ $selectedValue->width }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
