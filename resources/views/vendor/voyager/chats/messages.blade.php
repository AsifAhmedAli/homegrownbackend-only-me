@foreach($messages as $message)
    <div class="@if($message->sender == Auth::id()) receiver @else sender @endif">
        <div class="avatar">
            @if($message->senderUser->avatar)
                <img src="/storage/{{ $message->senderUser->avatar }}" class="w-50">
            @else
                <img src="/storage/users/default.png" class="w-50">
            @endif
        </div>
        <div class="message-bubble">
            {!! $message->message !!}
            @if(count($message->attachments))
                <br />
                @foreach($message->attachments as $attachment)
                    <a href="/storage{!! $attachment->file  !!}" target="_blank"><i class="fa fa-paperclip"></i> {!! $attachment->filename !!}</a> <br />
                @endforeach
            @endif
            <span class="message-date-time">{!! $message->created_at !!}</span>
        </div>
    </div>
@endforeach
