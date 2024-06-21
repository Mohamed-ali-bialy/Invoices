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

                    @if ($errors->any())
                    <div class="alert alert-danger">
    
                        <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    
                                    @endforeach
                                </ul>
                            </div>
                            @endif


                            <h4 class="mt-4">Create New Product 
                            </h4>

                            <form action="{{ route('products.store') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                                </div>
                             
                               
                             
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" id="price" class="form-control" value="{{ old('price') }}">
                                </div>
                                <div class="form-group">
                                    <label for="price">Stock</label>
                                    <input type="text" name="stock" id="stock" class="form-control" value="{{ old('stock') }}">
                                </div>

                                <div class="form-group">
                                    <label for="price">Discount</label>
                                    <input type="text" name="discount" id="discount" class="form-control" value="{{ old('discount') }}">
                                </div>


                                <div class="form-group">
                                    <label for="price">Product Code</label>
                                    <input type="text" name="product_Code" id="product_Code" class="form-control" value="{{ old('product_Code') }}">
                                </div>

                                <div class="form-group">
                                    <label for="status">Status:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="paused">Paused</option>
                                    </select>
                                </div>
                        
                                <div class="form-group">
                                    <label for="manufacturer_id">Manufacturer</label>
                                    <select name="manufacturer_id" id="manufacturer_id" class="form-control">
                                        <option value="">Select Manufacturer</option>
                                        @foreach($manufacturers as $manufacturer)
                                            <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                </div>

                                
                            <div>
                                <a href=""></a>
                                <button type="submit" class="btn btn-primary">Create Product</button>
                            </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

