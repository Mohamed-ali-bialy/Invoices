<!-- resources/views/carts/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Cart') }}</div>

                    <div class="card-body">
                        <form action="{{ route('carts.update', $cart) }}" method="POST">
                            @csrf
                            @method('PUT')

                            

                            <div class="form-group">
                                <label for="grand_total">{{ __('Grand Total') }}</label>
                                <input type="text" name="grand_total" id="grand_total" class="form-control" placeholder="{{ __('Enter Grand Total') }}" value="{{ $cart->grand_total }}">
                            </div>

                            <div class="form-group">
                                <label for="subtotal">{{ __('Subtotal') }}</label>
                                <input type="text" name="subtotal" id="subtotal" class="form-control" placeholder="{{ __('Enter Subtotal') }}" value="{{ $cart->subtotal }}">
                            </div>

                            <div class="form-group">
                                <label for="overall_discount">{{ __('Overall Discount') }}</label>
                                <input type="text" name="overall_discount" id="overall_discount" class="form-control" placeholder="{{ __('Enter Overall Discount') }}" value="{{ $cart->overall_discount }}">
                            </div>

                            <div class="form-group">
                                <label for="net_total">{{ __('Net Total') }}</label>
                                <input type="text" name="net_total" id="net_total" class="form-control" placeholder="{{ __('Enter Net Total') }}" value="{{ $cart->net_total }}">
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
