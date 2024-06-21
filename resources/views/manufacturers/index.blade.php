<!-- resources/views/manufacturers/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">{{ __('Manufacturers') }}</div>

                    <div class="card-body">
                        <a href="{{ route('manufacturers.create') }}" class="btn btn-primary mb-3">{{ __('Create Manufacturer') }}</a>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <tbody>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        </tr>
                                </thead>
                                    @forelse ($manufacturers as $manufacturer)
                                        <tr>
                                            <td>{{ $manufacturer->id }}</td>
                                            <td>{{ $manufacturer->name }}</td>
                                            <td class="text-right">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('manufacturers.show', $manufacturer) }}" class="btn btn-info">{{ __('Show') }}</a>
                                                    <a href="{{ route('manufacturers.edit', $manufacturer) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                                                    <form action="{{ route('manufacturers.destroy', $manufacturer) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this manufacturer?')">{{ __('Delete') }}</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">{{ __('No manufacturers found.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
