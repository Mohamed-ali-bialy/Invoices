<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart_item;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\HeadingRowImport;




class ProductController extends Controller
{
    
    public function export()
    {
        $products = Product::where('status', 'active')->get()->toArray();
        
        return Excel::download(new ProductsExport($products), 'products_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function import() 
    {
        $headings = Excel::import(new HeadingRowImport, request()->file('file'));
        //todo validations on headings 
        //dd($headings);
        
        //Excel::queueImport(new ProductsImport, request()->file('file'));
        
        $import = Excel::import(new ProductsImport, request()->file('file'));
        
        dd($import);

       /* foreach ($import->failures() as $failure) {
            $failure->row(); // row that went wrong
            $failure->attribute(); // either heading key (if using heading row concern) or column index
            $failure->errors(); // Actual error messages from Laravel validator
            $failure->values(); // The values of the row that has failed.
       }*/

        //return redirect('/productsManagement')->with('success', 'All good!');
    }



    public function management()
    {
      
        $products = Product::paginate(10);
        $cartItems = Cart_item::all();
       // dd($products);
        return view('products.management', compact('cartItems','products'));
    }


    public function index()
    {
        $products = Product::paginate(10);
        $cartItems = Cart_item::all();
       // dd($products);
        return view('products.index', compact('cartItems','products'));
    }


    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        $manufacturers=Manufacturer::all();
        return view('products.create',  compact('categories', 'manufacturers'));
        //return view('products.create');
    }

    public function store(StoreProductRequest  $request)
    {
        //dd($request->all());
        $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:1',
        'stock' => 'required|integer',
        'discount' => 'required|numeric|max:100', // Ensure discount is less than or equal to 100
        'status' => 'required|in:active,inactive,paused',
        'manufacturer_id' => 'nullable|exists:manufacturers,id',
        'product_Code'=>'required|integer|unique:products,product_Code',
        'category_id' => 'nullable|exists:categories,id',
        'description' => 'nullable|string',
        ]);

        //dd($request->validated());
        Product::create($request->validated());
        

        return redirect()->route('productsManagemnet')
                         ->with('success','Product created successfully.');
    }

    public function show(Product $product)
    {
        //return "show function ";
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all(); // Fetch all categories
        $manufacturers=Manufacturer::all();
        return view('products.edit', compact('product', 'categories', 'manufacturers'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            // Add more validation rules as needed
        ]);

        $product->update($request->all());

        return redirect()->route('productsManagemnet')
                         ->with('success','Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('productsManagemnet')
                         ->with('success','Product deleted successfully');
    }
}
