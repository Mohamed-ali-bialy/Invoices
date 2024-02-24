@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <h4 class="mt-4">Your Invoices</h4>

                    @if ($invoices->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Invoice ID</th>
                                    <th>Seller Name</th>
                                    <th>Invoice Number</th>
                                    <th>Shipment Number</th>
                                    <th>Invoice Amount</th>
                                    <th>Status</th>
                                    <!-- Add more columns as needed -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->id }}</td>
                                        <td>{{ $invoice->seller_name }}</td>
                                        <td>{{ $invoice->seller_invoice_number }}</td>
                                        <td>{{ $invoice->shipment_number }}</td>
                                        <td>{{ $invoice->invoice_amount }}</td>
                                        <td>{{ $invoice->status }}</td>
                                        <!-- Add more columns as needed -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $invoices->render('custom_pagination') }}

                    @else
                        <p>You have no invoices.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
