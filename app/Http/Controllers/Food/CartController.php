<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Food;
use App\Models\Stock;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Company;
use App\Models\PaymentMethod;

class CartController extends Controller
{
    public function cartView(){
        $order = Order::count() + 1;
        $company = Company::first();
        $invoice = Carbon::now()->format('Ymd').Auth::guard('admin')->id().$order;
        $cart = Cart::with('food')->where('reg', $invoice)->get();
        $count = Cart::with('food')->where('reg', $invoice)->count();
        $payMathod = PaymentMethod::all();
        return view('food.cart', compact('cart','company','invoice','count','payMathod'));
    }

    public function addCart2(Request $request){
        $data = Food::where('name', 'like','%'.$request->search.'%')
                    ->orWhere('id', 'like','%'.$request->search.'%')
                    ->orWhere('sku', 'like','%'.$request->search.'%')
                    ->orWhereHas('category', function($q) use($request) {
                        $q->where('name', 'like', '%'.$request->search.'%');
                    })->first(); 
        if(!$data){
            return redirect()->back()->with('warning','Food not found. Please try another.');
        }
        if($data->stock <= 0) {
            return redirect()->back()->with('warning','This item is not available right now.');
        }
        
        // generate invoice/reg number
        $order = Order::count() + 1;
        $invoice = Carbon::now()->format('Ymd').Auth::guard('admin')->id().$order;

        $findFood = Cart::where('reg', $invoice)->where('foodId', $data->id)->first();
        if($findFood) {
            return redirect()->back()->with('warning', 'Item already added. If you want more quantity.');
        }

        $cart = new Cart;
        $cart->reg = $invoice; 
        $cart->date = Carbon::now()->format('Y-m-d'); 
        $cart->userId = Auth::guard('admin')->id();
        $cart->foodId = $data->id;
        $cart->price = $data->price;

        $stock = new Stock();
        $stock->date = Carbon::now()->format('Y-m-d');
        $stock->foodId = $data->id;
        $stock->reg = $invoice;
        $stock->stockOut += 1;
        $stock->status = 1;

        $data->stock -= 1;
        // dd($cart, $data, $stock);
        $data->update();
        $stock->save();
        $cart->save();
        return redirect()->back();
    }

    public function addCart($id) {
        $data = Food::where('id', $id)->first(); 
        if(!$data){
            return redirect()->back()->with('warning','Food not found. Please try another.');
        }
        if($data->stock <= 0) {
            return redirect()->back()->with('warning','This item is not available right now.');
        }
        
        // generate invoice/reg number
        $order = Order::count() + 1;
        $invoice = Carbon::now()->format('Ymd').Auth::guard('admin')->id().$order;

        $findFood = Cart::where('reg', $invoice)->where('foodId', $data->id)->first();
        if($findFood) {
            return redirect()->back()->with('warning', 'Item already added. If you want more quantity, go to cart.');
        }

        $cart = new Cart;
        $cart->reg = $invoice; 
        $cart->date = Carbon::now()->format('Y-m-d'); 
        $cart->userId = Auth::guard('admin')->id();
        $cart->foodId = $data->id;
        $cart->price = $data->price;

        $stock = new Stock();
        $stock->date = Carbon::now()->format('Y-m-d');
        $stock->foodId = $data->id;
        $stock->reg = $invoice;
        $stock->stockOut += 1;
        $stock->status = 1;

        $data->stock -= 1;
        // dd($cart, $data, $stock);
        $data->update();
        $stock->save();
        $cart->save();
        return redirect()->back()->with('success', 'Item add to card successfully.');
    }

    public function updateQuantity(Request $request){
        $request->validate([
            'id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $newQty = $request->quantity;

        $cart = Cart::find($request->id);
        
        if (!$cart) {
            return response()->json(['status' => 'error', 'message' => 'Cart item not found'], 404);
        }

        $product = Food::find($cart->foodId);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Food item not found']);
        }

        $availableStock = $product->stock + $cart->quantity;

        if ($newQty > $availableStock) {
            return response()->json(['status' => 'error', 'message' => 'Food stock not available']);
        }

        $oldQty = $cart->quantity;
        $diff = $newQty - $oldQty;

        $stock = Stock::where('foodId', $cart->foodId)
                        ->where('reg', $cart->reg)
                        ->first();
        if (!$stock) {
            return response()->json(['status' => 'error', 'message' => 'Stock record not found for this registration']);
        }

        if($diff > 0) {
            $stock->stockOut += $diff;            
        } elseif ($diff < 0) {
            $adjust = abs($diff);
            if ($stock->stockOut < $adjust) {
                return response()->json(['status' => 'error', 'message' => 'Cannot reduce stock below 0']);
            }
            $stock->stockOut -= $adjust;
        }

        $stock->update();

        $product->stock -= ($newQty - $cart->quantity);
        $product->save();

        $cart->quantity = $newQty;
        $cart->update();

        return response()->json([
            'status' => 'success',
            'quantity' => $cart->quantity,
            'stock' => $product->stock
        ]);
    }

    public function removeToCart($foodId, $invoice){
        $cart = Cart::where('foodId', $foodId)->where('reg', $invoice)->first();
        if(!$cart){
            return redirect()->back()->with('error','Food not found. Please try another.');
        }

        $product = Food::where('id', $cart->foodId)->first();        
        $stock = Stock::where('foodId', $cart->foodId)
                        ->where('reg', $cart->reg)
                        ->first();
        
        if ($product) {
            $txtStock = $cart->quantity;
            $product->stock += $txtStock;
            $product->update();
        }

        if ($stock) {
            $stock->delete();
        }

        $cart->delete();
        return redirect()->back();
    }

    public function editInvoice($reg){
        $company = Company::first();
        $cart = Cart::where('reg', $reg)->get();
        if($cart->isEmpty()){
            return redirect()->back()->with('error', 'This Invoice number wise data not found. Please try another one. Thank You!');
        }
        $count = Cart::with('food')->where('reg', $reg)->count();
        $payMathod = PaymentMethod::all();
        $order = Order::where('reg', $reg)->first();
        return view('food.edit-cart', compact('company', 'cart', 'count','payMathod','order'));
    }

    public function UpdateInvoice(Request $request){
        $reg = $request->input('reg', '');

        $data = Food::where('name', 'like','%'.$request->search.'%')
                    ->orWhere('id', 'like','%'.$request->search.'%')
                    ->orWhere('sku', 'like','%'.$request->search.'%')
                    ->orWhereHas('category', function($q) use($request) {
                        $q->where('name', 'like', '%'.$request->search.'%');
                    })->first();
        
        if(!$data){
            return redirect()->back()->with('warning','Food not found. Please try another.');
        }
        if($data->stock <= 0) {
            return redirect()->back()->with('warning','This item is not available right now.');
        }
        
        // generate invoice/reg number
        $invoice = $reg;

        $findFood = Cart::where('reg', $invoice)->where('foodId', $data->id)->first();
        if($findFood) {
            return redirect()->back()->with('warning', 'Item already added. If you want more quantity.');
        }

        $cart = new Cart;
        $cart->reg = $invoice; 
        $cart->date = Carbon::now()->format('Y-m-d'); 
        $cart->userId = Auth::guard('admin')->id();
        $cart->foodId = $data->id;
        $cart->price = $data->price;

        $stock = new Stock();
        $stock->date = Carbon::now()->format('Y-m-d');
        $stock->foodId = $data->id;
        $stock->reg = $invoice;
        $stock->stockOut += 1;
        $stock->status = 1;

        $data->stock -= 1;
        // dd($cart, $data, $stock);
        $data->update();
        $stock->save();
        $cart->save();
        return redirect()->back();
    }

    public function modifyOrder(Request $request){
        $request->validate([
            'txtInvoice' => 'required',
            'txtSubTotal' => 'required',
        ]);

        $reg = $request->input('txtInvoice', '');
        
        $findReg = Order::where('reg', $reg)->first();
        if($findReg) {
            if($request->input('txtSubTotal', '') <= 0) {
                return redirect()->back()->with('error', 'Your cart is empty. Try again.');
            }        

            $received = $request->input('txtPay', 0);
            $total = $request->input('txtSubTotal', 0);
            $discount = $request->input('txtDiscount', 0);
            $vat = $request->input('txtVAT', 0);
            $payMethod = $request->input('paymentMethods', 0);

            $newVat = $total * $vat / 100;
            $payable = ($total - $discount) + $newVat;
            $dueAmount = $payable - $received;
                        
            if($received < 0) {
                return redirect()->back()->with('warning', 'You must be payment some amount. Unless you can not sale this product. Thanks');
            }

            $order = Order::where('reg', $reg)->first();
            $order->date = Carbon::now()->format('Y-m-d');
            $order->user_id = Auth::guard('admin')->user()->id;
            $order->reg = $reg;
            $order->total = $total;
            $order->discount = $discount;
            $order->vat = $newVat;
            $order->payable = $payable;
            $order->paymentMethod = $payMethod;

            if($received >= $payable) {
                $order->pay = $payable;
                $order->due = 0;
            } else {
                $order->pay = $received;
                $order->due = $dueAmount;
                $request->validate([
                    'txtCustomerName' => 'required',
                    'txtCustomerPhone' => 'required',
                ]);
                $order->customerName = $request->input('txtCustomerName', '');
                $order->customerPhone = $request->input('txtCustomerPhone', '');
            }
            
            // Auto status set
            if ($dueAmount > 0) { // 1 Fully paid and 0 due
                $order->status = 0; // Due
            } else {
                $order->status = 1; // Fully paid
            } 
            
            $order->update();
            
            return redirect()->back()->with('success', 'Order update successfully.')->with('reg', $reg);
        } else {
            return redirect()->back()->with('error', 'This order already taken. Please add product to cart and try again. Thank You!');
        }

       
    }
}
