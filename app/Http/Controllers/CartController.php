<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Cart_item;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use Maatwebsite\Excel\Facades\Excel;
 

class CartController extends Controller
{


    public function index()
    {
        $userId = Auth::id();
        $cart = Cart::where('user_id', Auth::id())->firstOrCreate(
            ['user_id' => Auth::id()], 
            ['grand_total' => '0','subtotal' => '0','overall_discount' => '0','net_total' => '0'] ,       
        );          
        $cart_items = Cart_item::where('cart_id',$cart->id)->get();
        //dd($cart_items);
        
        $cartDetails = $this->calculateCartDetails($cart_items);


        $cartSubTotal= 0;
        $cartTotal=0;

        $transformedItems = $cart_items->map(function ($item) use ( &$cartSubTotal,&$cartTotal) {
            $subtotal = $item->quantity * $item->product->price;
            $discount = $item->product->discount;
            $cartSubTotal+=$subtotal;
            $cartTotal+=($subtotal)- ($subtotal * ($discount / 100));
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'subtotal' => $subtotal,
                'total' => ($subtotal)- ($subtotal * ($discount / 100)), // Assuming no other calculations
                'cartSubTotal'=>$cartSubTotal,
                'cartTotal'=>$cartTotal,
            ];
        });
       // $transformedItems =  $this->calculateCartDetails($cart_items);
        return view('carts.show', compact('cart','transformedItems'));
    }

    private function calculateCartDetails($cartItems)
    {
        $totalQuantity = 0;
        $cartSubTotal = 0;
        $cartTotal = 0;
        
    
        // Process each cart item
        $items = $cartItems->map(function ($item) use (&$totalQuantity, &$cartSubTotal, &$cartTotal) {
            $subtotal = $item->quantity * $item->product->price;
            $total = $subtotal-($subtotal*($item->product->discount/100));
    
            // Accumulate totals
            $totalQuantity += $item->quantity;
            $cartSubTotal += $subtotal;
            $cartTotal += $total;
    
            return [
                'id' => $item->id,
                'product_name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'subtotal' => $subtotal,
                'total' => $total
            ];
        });
    
        return [
            'items' => $items,
            'totalQuantity' => $totalQuantity,
            'cartSubTotal' => $cartSubTotal,
            'cartTotal' => $cartTotal
        ];
    }

    public function create()
    {
        return view('carts.create');
    }

    public function store(StoreCartRequest $request)
    {
        $userId = Auth::id();
        $request->request->add(['user_id' => $userId]);

        $validatedData = $request->validated();
        Cart::create($validatedData);
        return redirect()->route('carts.index')->with('success', 'Cart created successfully.');
    }

    public function show()
{
    
   // Get the current user's cart
   $cart = Cart::where('user_id', Auth::id())->first();

   // Get cart items associated with the cart
   $cartItems = $cart->items;

   dd($cartItems);
   // Pass cart items to the view
   return view('cart.show', compact('cartItems'));
}




    public function edit(Cart $cart)
    {
        return view('carts.edit', compact('cart'));
    }

    public function update(UpdateCartRequest $request, Cart $cart)
    {
        
        $userId = Auth::id();
        $request->request->add(['user_id' => $userId]);

        
        $validatedData = $request->validated();

        $cart->update($validatedData);

        return redirect()->route('carts.index')->with('success', 'Cart updated successfully.');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return redirect()->route('carts.index')->with('success', 'Cart deleted successfully.');
    }
}
