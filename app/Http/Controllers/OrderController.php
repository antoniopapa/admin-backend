<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @OA\Get(path="/orders",
     *   security={{"bearerAuth":{}}},
     *   tags={"Orders"},
     *   @OA\Response(response="200",
     *     description="Order Collection",
     *   )
     * )
     */
    public function index()
    {
        \Gate::authorize('view', 'orders');

        $order = Order::paginate();

        return OrderResource::collection($order);
    }

    /**
     * @OA\Get(path="/orders/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Orders"},
     *   @OA\Response(response="200",
     *     description="User",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="Order ID",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *        type="integer"
     *     )
     *   )
     * )
     */
    public function show($id)
    {
        \Gate::authorize('view', 'orders');

        return new OrderResource(Order::find($id));
    }

    /**
     * @OA\Get(path="/export",
     *   security={{"bearerAuth":{}}},
     *   tags={"Orders"},
     *   @OA\Response(response="200",
     *     description="Order Export",
     *   )
     * )
     */
    public function export()
    {
        \Gate::authorize('view', 'orders');

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=orders.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $callback = function () {
            $orders = Order::all();
            $file = fopen('php://output', 'w');

            //Header Row
            fputcsv($file, ['ID', 'Name', 'Email', 'Order Title', 'Price', 'Quantity']);

            //Body
            foreach ($orders as $order) {
                fputcsv($file, [$order->id, $order->name, $order->email, '', '', '']);

                foreach ($order->orderItems as $orderItem) {
                    fputcsv($file, ['', '', '', $orderItem->product_title, $orderItem->price, $orderItem->quantity]);
                }
            }

            fclose($file);
        };

        return \Response::stream($callback, 200, $headers);
    }
}
