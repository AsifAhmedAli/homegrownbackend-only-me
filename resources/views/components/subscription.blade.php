<tr>
    <td>{{ $subscription->id }}</td>
    <td>{{ $customer->email  }}</td>
    <td>${{ $subscription->price }}</td>
    <td>{{ $subscription->currentBillingCycle }}</td>
    <td>{{ $subscription->firstBillingDate  }}</td>
    <td>
        @if(!$isCanceled)
            {{ $subscription->nextBillingDate  }}
        @endif
    </td>
    <td><x-status :status="$subscription->status" /></td>
    <td class="no-sort no-click bread-actions">
        @if(!$isCanceled)
            <button class="btn btn-sm btn-danger pull-right delete goTo" data-url="{{ route('admin.subscription.cancel', ['id' => $subscription->id]) }}" style="padding: 5px 10px !important; font-size: 12px !important;">
                <i class="voyager-x"></i> <span class="hidden-xs hidden-sm">Cancel</span>
            </button>
        @endif
    </td>
</tr>
