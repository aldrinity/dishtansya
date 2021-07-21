<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Validator;



class OrderController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
    }


    public function order(Request $request){

        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $product_id = $request->product_id;

        $product = Product::find($product_id);

        if(!$product){
            return response()->json([
                'message' => 'Product id does not exist',           
            ], 400);
        }

        if($product->available_stock < $request->quantity){
            return response()->json([
                'message' => 'Failed to order this product due to unavailability of the stock',           
            ], 400);
        }


        $product->available_stock -= $request->quantity;
        $product->save();

        return response()->json([
            'message' => 'You have successfully ordered this product',
        ], 201);


    }



}
