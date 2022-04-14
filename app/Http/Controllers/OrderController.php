<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Products;
use App\Models\OrderProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\IngredientLackMail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all()->toArray();
        return $products;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $products = $request->products;
        $price = $request->price;
        $ids = '';

        foreach ($products as $key => $value) {
            if (!$ids) {
                $ids = $key;
            } else {
                $ids = $ids . ', ' . $key;
            }
        }

        $order = new Order();
        $order->order_price = $price;
        $order->products_ids = $ids;
        $order->save();

        foreach ($products as $key => $value) {
            $orderProduct = new OrderProducts();
            $orderProduct->order_id = $order->id;
            $orderProduct->products_id = intval($key);
            $orderProduct->product_quantity = intval($value);
            $orderProduct->save();

            $product = DB::table('products')->select('cheese_weight', 'beef_weight', 'onion_weight')->where('id', intval($key))->first();
            $cheeseWeight = $product->cheese_weight * intval($value);
            $beefWeight = $product->beef_weight * intval($value);
            $onionWeight = $product->onion_weight * intval($value);
    
            $cheese =  DB::table('ingredients')->where('ingredient_name', 'cheese')->decrement('remaining_quantity', $cheeseWeight);
            $beef =  DB::table('ingredients')->where('ingredient_name', 'beef')->decrement('remaining_quantity', $beefWeight);
            $onion =  DB::table('ingredients')->where('ingredient_name', 'onion')->decrement('remaining_quantity', $onionWeight);

            $lackedItems = array();
            $cheeseRemaining = intval((DB::table('ingredients')->select('remaining_quantity')->where('ingredient_name', 'cheese')->first())->remaining_quantity);

            if ($cheeseRemaining <= 2500) {
                array_push($lackedItems, 'cheese');
            }

            $beefRemaining = intval((DB::table('ingredients')->select('remaining_quantity')->where('ingredient_name', 'beef')->first())->remaining_quantity);

            if ($beefRemaining <= 10000) {
                array_push($lackedItems, 'beef');
            }

            $onionRemaining = intval((DB::table('ingredients')->select('remaining_quantity')->where('ingredient_name', 'onion')->first())->remaining_quantity);

            if ($onionRemaining <= 500) {
                array_push($lackedItems, 'onion');
            }

            if (sizeof($lackedItems)) {
                $items = implode(',', $lackedItems);
                Mail::to('mhd.nawaiseh@outlook.com')->send(new IngredientLackMail($items));
            }
        }

        return response()->json([
            'message'=>'Order Saved Successfully!!',
            'order'=> $order
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->fill($request->post())->save();
        return response()->json([
            'message'=>'Order Updated Successfully!!',
            'order'=>$order
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json([
            'message'=>'Order Deleted Successfully!!'
        ]);
    }
}
