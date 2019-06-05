<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(Order::with(['product'])->get(), 200);
    }

    public function deliverOrder(Order $order)
    {
        $order->is_delivered = true;
        $order               = $order->save();
        return response()->json([
            'data'    => $order,
            'message' => $order ? 'Giao hàng thành công' : 'Giao hàng thất bại'
        ]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $order = Order::create([
            'product_id' => $request->product_id,
            'user_id'    => $request->user_id,
            'quantity'   => $request->quantity,
            'address'    => $request->address,
        ]);

        return response()->json([
            'status'  => (bool)$order,
            'data'    => $order,
            'message' => $order ? 'Đã tạo đơn hàng ' : ' Tạo đơn hàng thất bại'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
        return response()->json($order, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Order               $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
        $order = $order->update(
            $request->only(['quantity'])
        );
        return response()->json([
            'data'    => $order,
            'message' => $order ? 'Cập nhập số lượng thành công' : ' Cập nhập số lượng thất bại'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
        $order = $order->delete();
        return response()->json([
            'data' => $order,
            'message' => $order ? 'Xóa đơn hàng thành công' : 'Lỗi khi xóa đơn hàng'
         ]);
    }
}
