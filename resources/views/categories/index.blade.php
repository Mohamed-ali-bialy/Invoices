<!-- resources/views/categories/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">{{ __('Categories') }}</div>

                    <div class="card-body">
                        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">{{ __('Create Category') }}</a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td class="text-right">
                                            <div class="d-flex justify-content-end">
                                                <a href="{{ route('categories.show', $category) }}" class="btn btn-info">{{ __('Show') }}</a>
                                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary ml-2">{{ __('Edit') }}</a>
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger ml-2" onclick="return confirm('Are you sure you want to delete this category?')">{{ __('Delete') }}</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">{{ __('No categories found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
