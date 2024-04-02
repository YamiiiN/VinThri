<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;

class GraphController extends Controller
{
    public function index()
    {
        $orders = $this->getOrdersPerMonth();
        $customers = $this->getCustomersPerMonth();
        $sales = $this->getSalesPerMonth();

        return view('graph.graphs', compact('orders', 'customers', 'sales'));
    }

    private function getOrdersPerMonth()
    {
        $orders = Order::selectRaw('MONTHNAME(date) as month, COUNT(*) as total')
                       ->groupBy('month')
                       ->pluck('total', 'month')
                       ->toArray();

        return $this->formatMonths($orders);
    }

    private function getCustomersPerMonth()
    {
        $customers = Customer::selectRaw('MONTHNAME(customers.created_at) as month, COUNT(DISTINCT customers.customer_id) as total')
                             ->join('orders', 'customers.customer_id', '=', 'orders.customer_id')
                             ->groupBy('month')
                             ->pluck('total', 'month')
                             ->toArray();

        return $this->formatMonths($customers);
    }

    private function getSalesPerMonth()
    {
        $sales = Order::selectRaw('MONTHNAME(date) as month, SUM(order_items.quantity * products.unit_price) as total_sales')
                      ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
                      ->join('products', 'order_items.product_id', '=', 'products.product_id')
                      ->groupBy('month')
                      ->pluck('total_sales', 'month')
                      ->toArray();

        return $this->formatMonths($sales);
    }

    private function formatMonths($data)
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $months[$monthName] = $data[$monthName] ?? 0;
        }
        return $months;
    }

}
