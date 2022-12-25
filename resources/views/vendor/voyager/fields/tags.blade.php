@if($view === 'add' || $view === 'edit')
    <input class="tagify" name="{{ $row->field }}" value="{{ \App\Utils\Helpers\Helper::getValue(old($row->field), $dataTypeContent->{$row->field}) }}" placeholder="Write and Enter">
@else
    @foreach(explode(',', $content ?? '') as $tag)
       <div class="badge badge-success">{{ ucwords($tag) }}</div>
    @endforeach
@endif
