<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Transactions;
use App\Models\Users;
use App\Models\Logs;
use App\Models\Suppliers;
use App\Models\Categories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // Assuming your User model has a relationship named 'role'
        $role = $user->role->role_name; 

        if ($role === 'Admin') {
            $stats = [
                'total_revenue'  => Transactions::sum('total_amount'),
                'staff_count'    => Users::count(),
                'total_products' => Products::count(),
                'low_stock'      => Products::where('stock_level', '<', 10)->count(),
                'recent_logs'    => Logs::with('user')->latest()->take(4)->get(),
            ];
        } elseif ($role === 'Manager') {
            $stats = [
                // RAW query to multiply stock by price for total warehouse value
                'total_inventory_value' => Products::sum(DB::raw('stock_level * current_price')),
                'out_of_stock_count'    => Products::where('stock_level', 0)->count(),
                'low_stock_count'       => Products::where('stock_level', '<=', 10)->count(),
                'total_suppliers'       => Suppliers::count(),
                'recent_stock_changes'  => Logs::where('action', 'LIKE', '%product%')
                                            ->orWhere('action', 'LIKE', '%stock%')
                                            ->latest()->take(5)->get(),
            ];
        } else {
            // Default to Cashier Logic
            $stats = [
                'my_sales_today' => Transactions::where('user_id', $user->id)
                                    ->whereDate('created_at', Carbon::today())
                                    ->sum('total_amount') ?? 0,
                'my_transaction_count' => Transactions::where('user_id', $user->id)
                                    ->whereDate('created_at', Carbon::today())
                                    ->count(),
                'my_recent_transactions' => Transactions::where('user_id', $user->id)
                                    ->latest()->take(5)->get(),
            ];
        }

        return view('dashboard', compact('stats', 'role'));
    }
}