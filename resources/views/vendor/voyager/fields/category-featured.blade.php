@if($view === 'add' || $view === 'edit')
    @if(!$dataTypeContent->is_root)
        <br>
        <?php $checked = false; ?>
        @if(isset($dataTypeContent->{$row->field}) || old($row->field))
          <?php $checked = old($row->field, $dataTypeContent->{$row->field}); ?>
        @else
          <?php $checked = isset($options->checked) &&
                           filter_var($options->checked, FILTER_VALIDATE_BOOLEAN) ? true: false; ?>
        @endif

        <?php $class = $options->class ?? "toggleswitch"; ?>

        @if(isset($options->on) && isset($options->off))
            <input type="checkbox" name="{{ $row->field }}" class="{{ $class }}"
                   data-on="{{ $options->on }}" {!! $checked ? 'checked="checked"' : '' !!}
                   data-off="{{ $options->off }}">
        @else
            <input type="checkbox" name="{{ $row->field }}" class="{{ $class }}"
                   @if($checked) checked @endif>
        @endif
    @endif

@else
    @if(!$data->is_root)
        @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
            @if($data->{$row->field})
                <span class="label label-info">{{ $row->details->on }}</span>
            @else
                <span class="label label-primary">{{ $row->details->off }}</span>
            @endif
        @else
            {{ $data->{$row->field} }}
        @endif
    @endif
@endif
