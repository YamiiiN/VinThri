<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;

class GraphController extends Controller
{
    public function ordersPerMonth()
    {
        $ordersPerMonth = Order::selectRaw('MONTH(date) as month, COUNT(*) as total')
        ->where('status', 'delivered') // Add condition for status
                                ->groupBy('month')
                                ->pluck('total', 'month')
                                ->toArray();
                                return view('graph.orders_per_month', compact('ordersPerMonth'));
    }

    public function customersPerMonth()
    {
        $customersPerMonth = Customer::selectRaw('MONTH(customers.created_at) as month, COUNT(DISTINCT customers.customer_id) as total')
            ->join('orders', 'customers.customer_id', '=', 'orders.customer_id')
            ->where('orders.status', 'delivered')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        return view('graph.customers_line_chart', compact('customersPerMonth'));
    }

    public function salesPerMonth()
    {
        $salesPerMonth = Order::selectRaw('MONTH(date) as month, SUM(order_items.quantity * products.unit_price) as total_sales')
                              ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
                              ->join('products', 'order_items.product_id', '=', 'products.product_id')
                            ->where('orders.status', 'delivered') // Add condition for status
                              ->groupBy('month')
                              ->pluck('total_sales', 'month')
                              ->toArray();

        return view('graph.sales_pie_chart', compact('salesPerMonth'));
    }

}
