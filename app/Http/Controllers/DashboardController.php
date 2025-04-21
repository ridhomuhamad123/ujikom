<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalProduct = Product::all()->count();
        $totalUser = User::all()->count();
        $totalMember = Member::all()->count();
        $totalPurchase = Purchase::whereDate('created_at', Carbon::today())->count();


        $salesPerDay = Purchase::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(18))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $barLabels = $salesPerDay->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d F Y'))->toArray();
        $barData = $salesPerDay->pluck('total')->toArray();

        $productSales = DB::table('detail_sales')
            ->join('products', 'detail_sales.products_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(detail_sales.quantity) as total'))
            ->groupBy('products.name')
            ->orderByDesc('total')
            ->get();

        $pieLabels = $productSales->pluck('name')->toArray();
        $pieData = $productSales->pluck('total')->toArray();
        return view('dashboard', compact('totalProduct', 'totalUser', 'totalMember', 'totalPurchase', 'barLabels', 'barData', 'pieLabels', 'pieData'));


    }
    }