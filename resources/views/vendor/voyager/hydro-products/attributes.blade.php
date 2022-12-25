@if($selected_values->count() === 0)
    <p>{{ __('voyager::generic.no_results') }}</p>
@else
    <table class="table table-responsive">
        <thead>
            <tr>
                <th width="10">#</th>
                <th width="40">Attribute</th>
                <th width="50">Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach($selected_values as $key => $selectedValue)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $selectedValue->attribute }}</td>
                    <td>{{ $selectedValue->value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
