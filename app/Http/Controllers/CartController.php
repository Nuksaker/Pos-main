<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartList()
    {
        $cartItems = \Cart::getContent();

        return view('page.shop.index', compact('cartItems'));
    }




    public function addToCart(Request $request)
    {
        $item = Product::find($request);
        if ($request->ajax()) {
            if (count($item) === 0) {
                // session()->flash('empty', 'Product is Added to Cart Successfully !');
                return response()->json([
                    'status' => 'empty',
                ]);
            } else {
                \Cart::add([
                    'id' => $item[0]->id,
                    'name' => $item[0]->name,
                    'price' => $item[0]->priceP,
                    'quantity' => 1,
                    'attributes' => array(
                        'image' => "nil",
                    ),
                ]);
                // session()->flash('success', 'Product is Added to Cart Successfully !');
                $cartItems = \Cart::getContent();
                // dd($cartItems);
                $total = \Cart::getTotal();
                $token = $request->session()->token();
                $token = csrf_token();
                return response()->json([
                    'status' => 'success',
                    'data' => $cartItems,
                    'total' =>  $total,
                    'token' => $token,
                ], 201);
            }
        }
    }

    public function updateCart(Request $request)
    {
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity,
                ],
            ]
        );

        session()->flash('success', 'Item Cart is Updated Successfully !');

        return redirect()->route('shopP');
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('delete', 'Item Cart Remove Successfully !');

        return redirect()->route('shopP');
    }

    public function clearAllCart()
    {
        \Cart::clear();

        session()->flash('delete', 'All Item Cart Clear Successfully !');

        return redirect()->route('shopP');
    }
}
