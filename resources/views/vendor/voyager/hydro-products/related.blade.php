@if($selected_values->count() === 0)
    <p>{{ __('voyager::generic.no_results') }}</p>
@else
    <table class="table table-responsive">
        <thead>
        <tr>
            <th width="10">#</th>
            <th width="70">SKU</th>
            <th width="20">Relation</th>
        </tr>
        </thead>
        <tbody>
        @foreach($selected_values as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->sku }}</td>
                <td>
                    @if($item->relation === 'disco')
                        <x-label.no text="Discontinued" />
                    @else
                        {{ $item->relation }}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
