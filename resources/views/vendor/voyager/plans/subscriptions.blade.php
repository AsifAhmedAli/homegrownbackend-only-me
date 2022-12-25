@extends('voyager::master')

@section('page_title', 'Plan Subscriptions')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-bar-chart"></i> Subscriptions for <span class="text-danger">{{ ucwords($plan->name) }}</span> Plan
        </h1>
    </div>
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if(session()->has('success_message'))
                    <div class="alert alert-success">{{ session()->get('success_message') }}</div>
                @endif
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Buyer</th>
                                <th>Price</th>
                                <th>Current Billing Cycle</th>
                                <th>First Bill Date</th>
                                <th>Upcoming Billing</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($subscriptions as $subscription)
                                <x-subscription :subscription="$subscription" />
                            @empty
                                <tr>
                                    <td rowspan="6">No Subscription found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
