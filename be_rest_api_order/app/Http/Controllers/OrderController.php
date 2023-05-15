<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    //
    public function order()
    {
        try {
            //code...
            $lists = Order::with(['order_item' => function ($qry) {
                $qry->with('product');
            }, 'user'])->paginate(10);
            return response()->json([
                'success' => true,
                'message' => __('validation.success_json'),
                'data' => $lists
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Order error: ', ['order' => $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message'   => $th->getMessage()
            ], 500);
        }
    }

    public function cart(CartRequest $request)
    {

        try {
            //code...
            $arr = [];
            $qty = [];
            foreach ($request->cart as $value) {
                $arr[] = $value['product_id'];
                $qty[] = $value['quantity'];
            }

            $product = Product::whereIn('id', $arr)->pluck('id')->toArray();
            $invalid = array_values(array_diff($arr, $product));

            if (!empty($invalid)) {
                Log::warning('Cart product doesnt exits: ', ['cart' => $invalid]);
                return response()->json([
                    'success' => false,
                    'message' => 'Some product doesnt exits',
                    'data' => $invalid
                ], 400);
            }

            foreach($arr as $key => $value){
                Cart::updateOrCreate([
                    'product_id' => $value,
                    'user_id' => $request->user,
                ],[
                    'user_id' => $request->user,
                    'product_id' => $value,
                    'quantity' => $qty[$key],
                ]);
            }


            Log::info('Cart: ', ['cart' => $arr]);
            return response()->json([
                'success' => true,
                'message' => __('validation.success_json'),
                'data' => Cart::where('user_id', $request->user)->get()
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Cart error: ', ['cart' => $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message'   => $th->getMessage()
            ], 500);
        }
    }

    public function checkout(CartRequest $request)
    {

        try {
            //code...
            $arr = [];
            foreach ($request->cart as $value) {
                $arr[] = $value['product_id'];
            }

            $product = Product::whereIn('id', $arr)->pluck('id')->toArray();
            $invalid = array_values(array_diff($arr, $product));

            if (!empty($invalid)) {
                Log::warning('Cart product doesnt exits: ', ['cart' => $invalid]);
                return response()->json([
                    'success' => false,
                    'message' => 'Some product doesnt exits',
                    'data' => $invalid
                ], 400);
            }

            DB::beginTransaction();
            $now = Carbon::now()->toDateTimeString();

            $trans = Order::create([
                'user_id' => $request->user,
                'total_price' => 0
            ]);

            $lastID_transaction = $trans->id;

            $inputProduct = [];
            $total_price = 0;
            foreach ($request->cart as $key => $value) {
                $currentPrice = Product::select('price')->firstWhere('id', $value['product_id'])->price;
                $inputProduct[$key]['order_id'] = $lastID_transaction;
                $inputProduct[$key]['product_id'] = $value['product_id'];
                $inputProduct[$key]['quantity'] = $value['quantity'];
                $inputProduct[$key]['price'] = $currentPrice;

                $inputProduct[$key]['created_at'] = $now;
                $inputProduct[$key]['updated_at'] = $now;

                $total_price = $total_price + ($value['quantity'] * $currentPrice);
            }

            OrderItem::insert($inputProduct);

            $updateTrans = Order::find($lastID_transaction);
            $updateTrans->update(['total_price' => $total_price]);

            $cart = Cart::where('user_id', $request->user)->whereIn('product_id', $arr);
            if(!$cart->get()->isEmpty()){
                $cart->delete();
            }

            DB::commit();
            Log::info('Checkout: ', ['checkout' => $arr]);
            return response()->json([
                'success' => true,
                'message' => __('validation.success_json'),
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            Log::error('Cart error: ', ['cart' => $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message'   => $th->getMessage()
            ], 500);
        }
    }

    public function summary()
    {
        try {
            //code...
            $productsCount = Product::count();
            $ordersCount = Order::count();

            return response()->json([
                'success' => true,
                'message' => __('validation.success_json'),
                'products_count' => $productsCount,
                'orders_count' => $ordersCount,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Summary error: ', ['summary' => $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message'   => $th->getMessage()
            ], 500);
        }
    }
}
