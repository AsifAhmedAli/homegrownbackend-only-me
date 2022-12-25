@if($selected_values->count() === 0)
    <p>{{ __('voyager::generic.no_results') }}</p>
@else
    <table class="table table-responsive">
        <thead>
        <tr>
            <th width="10">#</th>
            <th width="30">Country</th>
            <th width="30">State Code</th>
            <th width="30">State</th>
        </tr>
        </thead>
        <tbody>
        @foreach($selected_values as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->country }}</td>
                <td>{{ $item->state }}</td>
                <td>{{ $item->stateName }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
