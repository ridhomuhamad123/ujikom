<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Exports\PurchaseExport;
use App\Exports\SalesExport;
use App\Models\DetailPurchase;
use App\Models\Member;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchase = Purchase::all();
        return view('pembelian.index', compact('purchase'));
    }

    public function create()
    {
        $produks = Product::all();
        return view('pembelian.create', compact('produks'));
    }

    public function post(Request $request)
    {
        $products = json_decode($request->input('products'), true);
        return view('pembelian.pilih', compact('products'));
    }

    public function store(Request $request)
    {
        $totalPay = str_replace(['Rp.', '.'], '', $request->total_pay);
        $request->merge(['total_pay' => $totalPay]);

        $request->validate([
            'total_price' => 'required|numeric|min:1',
            'total_pay' => 'required|numeric|min:1',
            'member' => 'required',
            'no_hp' => 'nullable|numeric|min:1',
            'products' => 'required|json',
        ]);

        if ($request->member == "Member" && !empty($request->no_hp)) {
            return redirect()->route('purchases.memberForm', [
                'no_hp' => $request->no_hp,
                'total_price' => $request->total_price,
                'total_pay' => $request->total_pay,
                'products' => $request->products
            ]);
        } else {
            return $this->processPurchase($request, null);
        }
    }

    private function processPurchase(Request $request, $memberId)
    {
        $member = Member::find($memberId);
        $earnedPoint = $request->earned_point ?? 0;
        $pointUsed = $request->point_used ?? 0;

        $purchase = Purchase::create([
            'sale_date' => now(),
            'total_price' => $request->total_price,
            'total_pay' => $request->total_pay,
            'total_return' => $request->total_pay - $request->total_price,
            'member_id' => $memberId,
            'user_id' => Auth::id(),
            'point' => $earnedPoint,
            'point_use' => $pointUsed,
        ]);

        $products = json_decode($request->input('products'), true);
        foreach ($products as $product) {
            DetailPurchase::create([
                'purchases_id' => $purchase->id,
                'products_id' => $product['id'],
                'quantity' => $product['quantity'],
                'sub_total' => $product['subtotal'],
            ]);

            $productModel = Product::find($product['id']);
            if ($productModel) {
                $productModel->stock -= $product['quantity'];
                $productModel->save();
            }
        }

        return redirect()->route('purchases.detailPrint', ['id' => $purchase->id]);
    }

    public function memberForm(Request $request)
    {
        $post = $request->validate([
            'no_hp' => 'required|numeric|min:1',
            'total_price' => 'required|numeric|min:1',
            'total_pay' => 'required|numeric|min:1',
        ]);

        $member = Member::where('no_phone', $post['no_hp'])->first();
        $purchase = Purchase::where('member_id', $member->id ?? null)->latest()->first();
        $products = json_decode($request->products, true);
        // dd($products);

        $newPoint = floor($post['total_price'] / 100);
        $totalPoint = ($member ? $member->poin : 0) + $newPoint;
        // dd($totalPoint);

        return view('pembelian.inputmember', compact('products', 'post', 'member', 'purchase', 'totalPoint'));
    }

    public function storeMember(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'required|numeric|min:1',
            'total_price' => 'required|numeric|min:1',
            'total_pay' => 'required|numeric|min:1',
            'products' => 'required|json',
        ]);

        $member = Member::firstOrCreate(
            ['no_phone' => $request->no_hp],
            ['name' => $request->name, 'point' => 0]
        );

        $totalPrice = $request->total_price;
        $usePoint = $request->check_poin == 'usePoin';
        $earnedPoint = floor($totalPrice / 100);
        $pointUsed = 0;
        $hasPreviousPurchase = Purchase::where('member_id', $member->id)->exists();

        if ($usePoint && $member && $hasPreviousPurchase) {
            $pointUsed = min($member->poin + $earnedPoint, $totalPrice);
            $totalPrice -= $pointUsed;
            $member->poin = 0;
            $member->save();
        } else {
            $member->poin += $earnedPoint;
            $member->save();
        }

        $request->merge([
            'total_price' => $totalPrice,
            'earned_point' => $earnedPoint,
            'point_used' => $pointUsed,
        ]);

        return $this->processPurchase($request, $member->id);
    }

    public function detailPrint($id) {
        $purchase = Purchase::with(['member', 'user', 'details.product'])->findOrFail($id);

        return view('pembelian.detail-print', compact('purchase'));
    }

    public function lihat(Request $request, $id)
    {
        $purchase = Purchase::with(['member', 'user', 'details.product', ])->find($id);
        // dd($purchase->details->toArray());
        return view('pembelian.detail', compact('purchase'));
    }

    public function exportPdf($id)
    {
        $sales = Purchase::with(['member', 'user', 'details.product'])->findOrFail($id);
        // dd($sales);  
        $pdf = Pdf::loadView('pdf.export-sale', compact('sales'));
        $filename = 'Bukti_Penjualan_' . ($sales->member ? $sales->member->name : 'NON-MEMBER') . '.pdf';
        return $pdf->stream($filename);
    }   

    public function export_excel()
    {
        return (new PurchaseExport)->download('sales'.Carbon::now()->timestamp.'.xlsx');
    }


}