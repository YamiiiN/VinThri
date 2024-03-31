<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;

class GraphController extends Controller
{
    public function ordersPerMonth()
    {
        $orders = Order::selectRaw('MONTHNAME(date) as month, COUNT(*) as total')
                       //->where('status', 'delivered') // Add condition for status
                       ->groupBy('month')
                       ->pluck('total', 'month')
                       ->toArray();

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $months[$monthName] = $orders[$monthName] ?? 0;
        }

        return view('graph.orders_per_month', compact('months'));
    }

    public function customersPerMonth()
    {
        $customers = Customer::selectRaw('MONTHNAME(customers.created_at) as month, COUNT(DISTINCT customers.customer_id) as total')
                             ->join('orders', 'customers.customer_id', '=', 'orders.customer_id')
                             //->where('orders.status', 'delivered')
                             ->groupBy('month')
                             ->pluck('total', 'month')
                             ->toArray();

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $months[$monthName] = $customers[$monthName] ?? 0;
        }

        return view('graph.customers_line_chart', compact('months'));
    }

    public function salesPerMonth()
    {
        $sales = Order::selectRaw('MONTHNAME(date) as month, SUM(order_items.quantity * products.unit_price) as total_sales')
                      ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
                      ->join('products', 'order_items.product_id', '=', 'products.product_id')
                      //->where('orders.status', 'delivered') // Add condition for status
                      ->groupBy('month')
                      ->pluck('total_sales', 'month')
                      ->toArray();

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $months[$monthName] = $sales[$monthName] ?? 0;
        }

        return view('graph.sales_pie_chart', compact('months'));
    }


}
