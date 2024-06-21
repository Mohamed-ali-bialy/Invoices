@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">


                @if ($errors->any())
                    <div class="alert alert-danger">
    
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>                            
                            @endforeach
                            </ul>
                            </div>
                 @endif
                            
                @if($errors->any())
                    <div class="alert alert-danger">
                    {{ $errors->first('error') }}
                    </div>
                    @endif
                <div class="card-header">{{ $product->name }}</div>
                
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $product->name }}</p>
                    <p><strong>Price:</strong> {{ $product->price }}</p>
                    <p><strong>Stock:</strong> {{ $product->stock }}</p>
                    <p><strong>Discount:</strong> {{ $product->discount }}</p>
                    <p><strong>Status:</strong> {{ $product->status }}</p>
                    <p><strong>Manufacturer:</strong>  {{ optional($product->manufacturer)->name ?? 'No Manufacturer' }}</p>
                    <p><strong>Category:</strong> {{ optional($product->category)->name ?? 'No Manufacturer' }}</p>
                    <p><strong>Description:</strong> {{ $product->description }}</p>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">Edit</a>

                    </td>
                    <td>
                        <form action="{{ route('products.destroy', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                        </form>
                    </td>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
