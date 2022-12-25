@if($view === 'add' || $view === 'edit')
       <?php $selected_value = (isset($dataTypeContent->{$row->field}) && !is_null(old($row->field, $dataTypeContent->{$row->field}))) ? old($row->field, $dataTypeContent->{$row->field}) : old($row->field); ?>
       <select class="form-control select2" name="{{ $row->field }}" id="coupon-type">
              <option value="">None</option>
              @foreach(\App\Utils\Constants\DropDown::COUPON_TYPES as $key => $option)
                     <option value="{{ $key }}" @if($selected_value == $key) selected="selected" @endif>{{ $option }}</option>
              @endforeach
       </select>
@else
       {{ \App\Utils\Constants\DropDown::COUPON_TYPES[$content] }}
@endif
