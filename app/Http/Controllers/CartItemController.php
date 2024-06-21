<?php

namespace App\Http\Controllers;

use App\Models\Cart_item;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCartItemRequest;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function index()
    {
        $cartItems = Cart_item::all();
        
        return view('cartItems.index', compact('cartItems'));
    }

    
    public function addToCart(Request $request)
    {   

    // Ensure productIds and quantitys arrays are of the same length
    if ($request->productIds && $request->quantitys && count($request->productIds) != count($request->quantitys)) {
        return response()->json([
            'error' => 'Product IDs and quantities arrays must have the same length.'
        ], 400);
    }

    // Iterate over productIds array
    foreach ($request->productIds as $index => $productId) {
        $product = Product::findOrFail($productId);

         // Check if product quantity is zero
         if ($request->quantitys[$index] == 0) {
            $this->destroy($request->cartItemIds[$index]);
            return;
            /*return response()->json([
                'message' => 'Product: ' . $product->name . ' is deleted successfuly.'
            ], 200); // 200 Request
            */
        }

         // Check if product is active
         if ($product->status !== "active") {
            return response()->json([
                'error' => 'Product: ' . $product->name . ' is not active.'
            ], 400); // 400 Bad Request
        }

        // Check if quantity exceeds available stock
        if ($request->quantitys[$index] > $product->stock) {
            return response()->json([
                'error' => 'Quantity exceeds available stock for product: ' . $product->name
            ], 400); // 400 Bad Request
        }

        // Retrieve or create cart for the user
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()], [
            'grand_total' => 0,
            'subtotal' => 0,
            'overall_discount' => 0,
            'net_total' => 0
        ]);

        // Retrieve existing cart item or create a new one
        $existingCartItem = Cart_item::where('cart_id', $cart->id)
            ->where('product_id', $productId)->first();

        // Calculate total price and discounted price
        $totalPrice = $product->price * $request->quantitys[$index];
        $discountAmount = $product->discount; 
        $discountedPrice = $totalPrice - ($totalPrice * ($discountAmount / 100));

        // Update existing cart item or create a new one
        if ($existingCartItem) {
            $existingCartItem->update([
                'quantity' => $request->quantitys[$index],
                //'subtotal' => $totalPrice,
                //'total' => $discountedPrice,
            ]);
        } else {
            Cart_item::create([
                'cart_id' => $cart->id,
                'quantity' => $request->quantitys[$index],
                'product_id' => $productId,
                //'product_name' => $product->name, 
                //'price' => $product->price,
                //'discount' => $product->discount,
                //'subtotal' => $totalPrice,
                'tax' => 0,
                'total' => $discountedPrice,
            ]);
        }
    }

    // Recalculate and update cart totals
    $cartItems = Cart_item::where('cart_id', $cart->id)->get();
    $subtotal = $cartItems->sum('subtotal');
    $cartSubTotal = 0 ;
    $cartTotal = 0 ;

    $transformedItems = $cartItems->map(function ($item) use ( &$cartSubTotal,&$cartTotal){
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
            $subtotal = $item->quantity * $item->product->price,
            $discount = $item->product->discount,
            'subtotal' => $subtotal,
            'total' => ($subtotal)- ($subtotal * ($discount / 100)), // Assuming no other calculations
        ];
    });

    $cart->update([
        'subtotal' => $cartSubTotal,
        'grand_total' => 0,
        'net_total' => $cartTotal,
    ]);
    
    return response()->json([
        'success' => true,
        'message' => 'Products added to cart successfully.',
        'cart_items' => $transformedItems,
        'subtotal' => $cartSubTotal,
        'net_total' => $cartTotal
    ]);
}
    
public function clearCart()
{
    $user_id = Auth::id();

    // Retrieve the cart for the logged-in user
    $cart = Cart::where('user_id', $user_id)->first();

    if ($cart) {
        // Delete all cart items associated with the cart
        Cart_item::where('cart_id', $cart->id)->delete();
        
        // You may also want to reset the cart's total values
        $cart->update([
            'grand_total' => 0,
            'subtotal' => 0,
            'overall_discount' => 0,
            'net_total' => 0
        ]);

        return redirect()->route('carts.index')->with('success', 'Cart cleared successfully.');
    } else {
        return redirect()->route('carts.index')->with('error', 'Cart not found.');
    }
}
/*

public function deleteItemFromCart( $id)
{
    //dd($id);
    // Find the cart item by ID
    $cartItem = Cart_item::findOrFail($id);

    // Delete the cart item
    $cartItem->delete();

    $cart = Cart::firstOrCreate(['user_id' => Auth::id()], [
        'grand_total' => 0,
        'subtotal' => 0,
        'overall_discount' => 0,
        'net_total' => 0
    ]);

    $cart_items = Cart_item::where('cart_id', $cart->id)->get();
    $cartsubTotal = 0;
    $cartTotal = 0;
    foreach ($cart_items as $cart_item) {
        $cartsubTotal += $cart_item->subtotal;
        $cartTotal+=$cart_item->total;
    }

    
    $cart->update(['subtotal' => $cartsubTotal,'net_total'=>$cartTotal]);

    return redirect()->route('carts.index')->with('success', 'Item removed from cart successfully.');
}
*/

public function destroy($id)
{
    // Find the cart item by its ID
    $cartItem = Cart_item::findOrFail($id);

    // Delete the cart item
    $cartItem->delete();

    $cart = Cart::firstOrCreate(['user_id' => Auth::id()], [
        'grand_total' => 0,
        'subtotal' => 0,
        'overall_discount' => 0,
        'net_total' => 0
    ]);

    $cart_items = Cart_item::where('cart_id', $cart->id)->get();
    $cartsubTotal = 0;
    $cartTotal = 0;
    foreach ($cart_items as $cart_item) {
        $cartsubTotal += $cart_item->subtotal;
        $cartTotal+=$cart_item->total;
    }
    $cart->update(['subtotal' => $cartsubTotal,'net_total'=>$cartTotal]);

    return redirect()->route('carts.index')->with('success', 'Item removed from cart successfully.');
}




public function store(StoreCartItemRequest $request)
{    
    dd($request);
    $validatedData = $request->validated();


    $cartItem = new Cart_item($validatedData);
    $cartItem->save();
    return response()->json(['message' => 'Cart item created successfully'], 201);
}

    
}
