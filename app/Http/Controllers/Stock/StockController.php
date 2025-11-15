<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Auth;
use App\Models\Company;
use App\Models\Food;
use App\Models\Stock;

class StockController extends Controller
{
    public function index(){
        $foods = Food::where('stock', '<=', 50)->paginate(15);
        $company = Company::first();
        return view('stock.food-stock', compact('foods','company'));
    }

    public function liveSearch(Request $request){
        $output = "";

        $food = Food::where('name', 'like','%'.$request->search.'%')
                    ->orWhere('id', 'like','%'.$request->search.'%')
                    ->orWhere('sku', 'like','%'.$request->search.'%')
                    ->orWhereHas('category', function($q) use($request) {
                        $q->where('name', 'like', '%'.$request->search.'%');
                    })->get();

        foreach($food as $key => $val) {

            $imagePath = asset('img/food/' . $val->image);
            $link = url('/specific-food-view/'.$val->id);

            $ingredients = strlen($val->ingredients) > 40 
                            ? substr($val->ingredients, 0, 40) . '...' 
                            : $val->ingredients;

            $output .= '
                <tr>
                    <td>'.($key+1).'</td>

                    <!-- Image -->
                    <td>
                        <img src="'.$imagePath.'" width="60" height="45"
                            style="object-fit:cover; border-radius:5px;">
                    </td>

                    <!-- Name -->
                    <td class="fw-bold">
                        <a href="'.$link.'" class="text-dark text-decoration-none">
                            '.$val->name.'
                        </a>
                    </td>

                    <!-- Price -->
                    <td class="text-success fw-bold">
                        ৳'.$val->price.'
                    </td>

                    <!-- Stock -->
                    <td class="fw-bold">
                        '.$val->stock.'
                    </td>

                    <!-- Ingredients -->
                    <td style="max-width:220px;">
                        <span class="text-muted small d-inline-block text-truncate"
                            style="max-width:220px;">
                            '.$ingredients.'
                        </span>
                    </td>

                    <!-- Action -->
                    <td>
                        <a href="'.$link.'"
                        class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-pen-to-square"></i> View
                        </a>
                    </td>
                </tr>
            ';
        }

        if ($output == '') {
            $output = '<tr>
                        <td colspan="7" class="text-center py-3 text-muted">
                            No food found.
                        </td>
                    </tr>';
        }

        return response($output);
    }

    public function insert(Request $request){
        $request->validate([
            'txtFoodId' => 'required|integer|exists:food,id',
            'txtStock' => 'required|integer|min:1',
        ]);

        $food = Food::where('id', $request->txtFoodId)->first();
        if(empty($food)){
            return redirect()->back()->with('error', 'Food not found. Please try another one. Thanks!');
        }

        $food->stock += $request->txtStock;
        $food->remark = "Stock inserted date of " . Carbon::now()->format('Y-m-d');

        $data = new Stock();
        $data->date = Carbon::now()->format('Y-m-d');
        $data->foodId = $request->txtFoodId;
        $data->stockIn = $request->txtStock;
        $data->remark = "Stock In";
        $data->save();
        $food->update();
        return redirect()->back()->with('success', 'Product stock inserted successfully.');
    }
}
