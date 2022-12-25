@php
    $items = $family->items;
@endphp
@if($items->count())
    <table class="table table-responsive">
        <thead>
        <tr>
            <th width="10">#</th>
            <th width="50">SKU</th>
            <th width="10">Is Root</th>
            <th width="30">Unit Size</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->sku }}</td>
                <td>
                    @if($item->isDefault)
                        <x-label.yes />
                    @else
                        <x-label.no />
                    @endif
                </td>
                <td>
                    {{ $item->unitSize }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
