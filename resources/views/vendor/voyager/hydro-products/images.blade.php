@if($selected_values->count() === 0)
    <p>{{ __('voyager::generic.no_results') }}</p>
@else
    <table class="table table-responsive">
        <thead>
        <tr>
            <th width="10">#</th>
            <th width="50">Name</th>
            <th width="10">Is Default</th>
            <th width="30">URL</th>
        </tr>
        </thead>
        <tbody>
        @foreach($selected_values as $key => $selectedValue)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $selectedValue->docName }}</td>
                <td>
                    @if($selectedValue->isDefault)
                        <x-label.yes />
                    @else
                        <x-label.no />
                    @endif
                </td>
                <td><a target="_blank" href="{{ $selectedValue->url }}">View Image</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
