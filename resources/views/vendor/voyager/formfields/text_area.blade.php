<textarea @if($row->required == 1) required @endif
@if(isset($options->maxlength)) maxlength="{{ $options->maxlength }}" @endif
class="form-control" name="{{ $row->field }}" rows="{{ $options->display->rows ?? 5 }}">{{ strip_tags(old($row->field, $dataTypeContent->{$row->field} ?? strip_tags(optional($options)->default) ?? '')) }} </textarea>
