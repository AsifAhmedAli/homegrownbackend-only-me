@php
    $prices = $price->whole_sale_prices;
@endphp
@if($prices->count())
    <table class="table table-responsive">
        <thead>
        <tr>
            <th width="10">#</th>
            <th width="25">Your Price</th>
            <th width="25">Price</th>
            <th width="20">Qty Start</th>
            <th width="20">Qty End</th>
        </tr>
        </thead>
        <tbody>
        @foreach($prices as $key => $priceItem)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>${{ $priceItem->yourPrice }}</td>
                <td>${{ $priceItem->price }}</td>
                <td>{{ $priceItem->qtyStart }}</td>
                <td>
                    @if($priceItem->qtyEnd)
                        {{ $priceItem->qtyEnd }}
                    @else
                        Unlimited
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
