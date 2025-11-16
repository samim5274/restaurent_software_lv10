<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Auth;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Company;
use App\Models\DueCollection;

class KitchenController extends Controller
{
    public function index(){
        $company = Company::first();
        $order = Order::orderByDesc('id')->paginate(15);
        return view('kitchen.kitchen-details', compact('order','company'));
    }

    public function orderItem($reg){
        $company = Company::first();
        $food = Cart::where('reg', $reg)->with('food')->get();
        if(empty($food)){
            return redirect()->back()->with('error', 'Order items not found. Please try another. Thank You!');
        }
        $order = Order::where('reg', $reg)->first();
        $dueCollection = DueCollection::where('reg', $reg)->get();
        return view('kitchen.cart-view', compact('food','company','order','dueCollection'));
    }

    public function updateStatus(Request $request, $reg){
        $food = Order::where('reg', $reg)->first();
        if(!$food){
            return redirect()->back()->with('error', 'Order items not found. Please try another. Thank You!');
        }
        $food->kitchen = $request->input('cbxStatus', '0');
        $food->update();
        return redirect()->back()->with('success', 'Order food item status updated. Thank You!');
    }
}
