@if($selected_values->count() === 0)
    <p>{{ __('voyager::generic.no_results') }}</p>
@else
    <table class="table table-responsive">
        <thead>
        <tr>
            <th width="10">#</th>
            <th width="10">Site ID</th>
            <th width="50">Name</th>
            <th width="15">At Warehouse</th>
            <th width="15">Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($selected_values as $key => $selectedValue)
            <tr @if($selectedValue->siteId == \App\Hydro\HydroProduct::SITE_ID) class="info" @endif>
                <td>{{ $key + 1 }}</td>
                <td>{{ $selectedValue->siteId }}</td>
                <td>{{ $selectedValue->name }}</td>
                <td>{{ $selectedValue->availPhysicalByWarehouse }}</td>
                <td>{{ $selectedValue->availPhysicalTotal }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
