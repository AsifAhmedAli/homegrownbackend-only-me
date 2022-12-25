@if($selected_values->count() === 0)
    <p>{{ __('voyager::generic.no_results') }}</p>
@else
    <table class="table table-responsive">
        <thead>
        <tr>
            <th width="10">#</th>
            <th width="10">Factor</th>
            <th width="5">Numerator</th>
            <th width="5">Denominator</th>
            <th width="10">Inner Offset</th>
            <th width="10">Outer Offset</th>
            <th width="10">Rounding</th>
            <th width="5">From Symbol</th>
            <th width="5">From Decimal of Precision</th>
            <th width="10">From Name</th>
            <th width="5">To Symbol</th>
            <th width="5">To Decimal of Precision</th>
            <th width="10">To Name</th>
        </tr>
        </thead>
        <tbody>
        @foreach($selected_values as $key => $selectedValue)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $selectedValue->factor }}</td>
                <td>{{ $selectedValue->numerator }}</td>
                <td>{{ $selectedValue->denominator }}</td>
                <td>{{ $selectedValue->inneroffset }}</td>
                <td>{{ $selectedValue->outeroffset }}</td>
                <td>{{ $selectedValue->rounding }}</td>
                <td>{{ $selectedValue->fromsymbol }}</td>
                <td>{{ $selectedValue->fromdecimalofprecision }}</td>
                <td>{{ $selectedValue->fromname }}</td>
                <td>{{ $selectedValue->tosymbol }}</td>
                <td>{{ $selectedValue->todecimalofprecision }}</td>
                <td>{{ $selectedValue->toname }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
