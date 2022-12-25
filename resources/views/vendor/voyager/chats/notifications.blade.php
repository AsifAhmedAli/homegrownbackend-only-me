@if(count($notifications))
    @foreach($notifications as $notification)
        <li class="profile-img">
            {!! $notification->notification !!}
            <span class="date-time">{!! $notification->created_at !!}</span>
        </li>
    @endforeach
@endif
