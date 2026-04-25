<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;      // MATCHES YOUR FILENAME
use App\Models\Transactions; 
use App\Models\Users;        
use App\Models\Suppliers;     
use App\Models\Logs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $role = $user->role->role_name;

    // Initialize all keys as 0 or empty to prevent "Undefined Index" errors
    $stats = [
        'total_revenue' => 0, 'staff_count' => 0, 'total_products' => 0, 'low_stock' => 0, 'recent_logs' => [],
        'total_inventory_value' => 0, 'out_of_stock_count' => 0, 'low_stock_count' => 0, 'total_suppliers' => 0, 'recent_stock_changes' => [],
        'my_sales_today' => 0, 'my_transaction_count' => 0, 'my_recent_transactions' => []
    ];

    if ($role === 'Admin') {
        $stats['total_revenue']  = \App\Models\Transactions::sum('total_amount');
        $stats['staff_count']    = \App\Models\Users::count();
        $stats['total_products'] = \App\Models\Products::count();
        $stats['low_stock']      = \App\Models\Products::where('stock_level', '<', 10)->count();
        $stats['recent_logs']    = \App\Models\Logs::with('user')->latest()->take(4)->get();
    } 
    elseif ($role === 'Manager') {
        $stats['total_inventory_value'] = \App\Models\Products::sum(\DB::raw('stock_level * current_price'));
        $stats['out_of_stock_count']    = \App\Models\Products::where('stock_level', 0)->count();
        $stats['low_stock_count']       = \App\Models\Products::where('stock_level', '<=', 10)->count();
        $stats['total_suppliers']       = \App\Models\Suppliers::count();
        $stats['recent_stock_changes']  = \App\Models\Logs::where('action', 'LIKE', '%product%')->latest()->take(4)->get();
    } 
    elseif ($role === 'Cashier') {
        $stats['my_sales_today']       = \App\Models\Transactions::where('user_id', $user->id)->whereDate('created_at', today())->sum('total_amount');
        $stats['my_transaction_count'] = \App\Models\Transactions::where('user_id', $user->id)->whereDate('created_at', today())->count();
        $stats['my_recent_transactions'] = \App\Models\Transactions::where('user_id', $user->id)->latest()->take(5)->get();
    }

    return view('dashboard', compact('stats', 'role'));
}
}