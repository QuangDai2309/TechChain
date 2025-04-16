<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Lấy danh sách đơn hàng
    public function index()
    {
        $orders = Order::with('user', 'orderItems.product')->get();
        return response()->json($orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request)
{

    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:orders,email',
            'address' => 'required',
            'phone' => 'required',
            'cart' => 'required|array',
            'cart.*.product_id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1'
        ]);

        $total = 0;

        foreach ($request->cart as $item) {
            $product = Product::find($item['product_id']);
            $total += ($product->price * (1 - $product->discount / 100)) * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => auth()->id() ?? null,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'total' => $total,
        ]);

        foreach ($request->cart as $item) {
            $product = Product::find($item['product_id']);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'discount' => $product->discount,
            ]);
        }
        return response()->json(['message' => 'Đặt hàng thành công'], 200);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTrace()
        ], 500);
    }
}




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Lấy chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with('user', 'orderItems.product')->findOrFail($id);
        return response()->json($order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Cập nhật trạng thái đơn hàng
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status; // Trạng thái mới
        $order->save();

        return response()->json(['message' => 'Cập nhật trạng thái đơn hàng thành công!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
