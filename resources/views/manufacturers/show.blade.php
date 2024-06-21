<!-- resources/views/manufacturers/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Manufacturer Details') }}</div>

                    <div class="card-body">
                        <p><strong>{{ __('Id') }}:</strong> {{ $manufacturer->id }}</p>
                        <p><strong>{{ __('Name') }}:</strong> {{ $manufacturer->name }}</p>

                        <a href="{{ route('manufacturers.edit', $manufacturer) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
