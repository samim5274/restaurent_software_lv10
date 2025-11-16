<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Auth;
use App\Models\Admin;
use App\Models\PaymentMethod;
use App\Models\Order;
use App\Models\Company;
use App\Models\DueCollection;

class SaleReportController extends Controller
{
    public function index(){
        $company = Company::first();
        $today = now()->toDateString();

        $orders = Order::whereDate('date', $today)->get();


        $totals = [
            'totalAmount'   => $orders->sum('total'),
            'totalDiscount' => $orders->sum('discount'),
            'totalVat'      => $orders->sum('vat'),
            'totalPayable'  => $orders->sum('payable'),
            'totalPaid'     => $orders->sum('pay'),
            'totalDue'      => $orders->sum('due'),
        ];
        return view('order.report.total-sale-report', compact('company', 'orders') + $totals);
    }

    public function filterSaleReport(Request $request){
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $start = $request->start_date;
        $end = $request->end_date;

        $company = Company::first();
        $orders = Order::whereBetween('date', [$start , $end])->get();

        $totals = [
            'totalAmount'   => $orders->sum('total'),
            'totalDiscount' => $orders->sum('discount'),
            'totalVat'      => $orders->sum('vat'),
            'totalPayable'  => $orders->sum('payable'),
            'totalPaid'     => $orders->sum('pay'),
            'totalDue'      => $orders->sum('due'),
        ];

        if($request->has('print')){
            return view('order.report.print.total-sale-report-print', compact('company', 'start','end', 'orders') + $totals);
        }

        return view('order.report.total-sale-report', compact('company', 'orders') + $totals);
    }

    public function userTotalSale(){
        $company = Company::first();
        $today = now()->toDateString();
        $users = Admin::all();
        $orders = Order::whereDate('date', $today)->with('user')->get();

        $totals = [
            'totalAmount'   => $orders->sum('total'),
            'totalDiscount' => $orders->sum('discount'),
            'totalVat'      => $orders->sum('vat'),
            'totalPayable'  => $orders->sum('payable'),
            'totalPaid'     => $orders->sum('pay'),
            'totalDue'      => $orders->sum('due'),
        ];
        return view('order.report.user-total-sale-report', compact('company', 'orders','users') + $totals);
    }

    public function filterUserReport(Request $request){
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'user_id'    => 'required|integer',
        ]);

        $start = $request->start_date;
        $end   = $request->end_date;
        $user  = $request->user_id;

        $company = Company::first();
        $users = Admin::all();

        $orders = Order::where('user_id', $user)
                    ->whereBetween('date', [$start, $end])
                    ->orderBy('date', 'ASC')->with('user')
                    ->get();

        $totalAmount  = $orders->sum('total');
        $totalDiscount = $orders->sum('discount');
        $totalVat      = $orders->sum('vat');
        $totalPayable  = $orders->sum('payable');
        $totalPaid     = $orders->sum('pay');
        $totalDue      = $orders->sum('due');

        if ($request->print == 1) {
            return view('order.report.print.user_total_sale_print', compact(
                'orders',
                'company',
                'start',
                'end',
                'totalAmount',
                'totalDiscount',
                'totalVat',
                'totalPayable',
                'totalPaid',
                'totalDue'
            ));
        }

        return view('order.report.user-total-sale-report', compact(
            'orders',
            'company',
            'start',
            'end',
            'totalAmount',
            'totalDiscount',
            'totalVat',
            'totalPayable',
            'totalPaid',
            'totalDue',
            'users'
        ));
    }

    public function paymentSaleReport(){
        $company = Company::first();
        $today = now()->toDateString();

        $paymentMathods = PaymentMethod::all();
        $orders = Order::whereDate('date', $today)->with('user','payment')->get();


        $totals = [
            'totalAmount'   => $orders->sum('total'),
            'totalDiscount' => $orders->sum('discount'),
            'totalVat'      => $orders->sum('vat'),
            'totalPayable'  => $orders->sum('payable'),
            'totalPaid'     => $orders->sum('pay'),
            'totalDue'      => $orders->sum('due'),
        ];
        return view('order.report.paymentMathod-total-sale-report', compact('company', 'orders','paymentMathods') + $totals);
    }

    public function paymentSaleFilter(Request $request){
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
            'pay_id'     => 'required|integer',
        ]);

        $start = $request->start_date;
        $end   = $request->end_date;
        $payId = $request->pay_id;

        $company = Company::first();
        $paymentMathods = PaymentMethod::all();
        
        $orders = Order::where('paymentMethod', $payId)
                ->whereBetween('date', [$start, $end])
                ->orderBy('date', 'ASC')->with('user','payment')
                ->get();

        $totalAmount   = $orders->sum('total');
        $totalDiscount = $orders->sum('discount');
        $totalVat      = $orders->sum('vat');
        $totalPayable  = $orders->sum('payable');
        $totalPaid     = $orders->sum('pay');
        $totalDue      = $orders->sum('due');

         if ($request->print == 1) {
            return view('order.report.print.payment_mathod_total_sale_print', compact(
                'orders',
                'company',
                'start',
                'end',
                'totalAmount',
                'totalDiscount',
                'totalVat',
                'totalPayable',
                'totalPaid',
                'totalDue'
            ));
        }

        // Preview page
        return view('order.report.paymentMathod-total-sale-report', compact(
            'orders',
            'company',
            'start',
            'end',
            'totalAmount',
            'totalDiscount',
            'totalVat',
            'totalPayable',
            'totalPaid',
            'totalDue',
            'paymentMathods'
        ));
    }
}
