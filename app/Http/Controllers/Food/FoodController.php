<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;
use App\Models\FoodCategory;
use App\Models\Food;
use App\Models\Company;

class FoodController extends Controller
{
    public function index(){
        $company = Company::first();
        $foods = Food::with('category')->paginate('12');
        return view('food.food-details', compact('foods','company'));
    }

    public function liveSearch(Request $request) {
        
        $output = "";

        $food = Food::where('name', 'like','%'.$request->search.'%')
                    ->orWhere('id', 'like','%'.$request->search.'%')
                    ->orWhere('sku', 'like','%'.$request->search.'%')
                    ->orWhereHas('category', function($q) use($request) {
                        $q->where('name', 'like', '%'.$request->search.'%');
                    })->get();

        foreach($food as $val) {
            $name = strlen($val->name) > 22 ? substr($val->name, 0, 22) . '...' : $val->name;
            $ingredients = strlen($val->ingredients) > 40 ? substr($val->ingredients, 0, 40) . '...' : $val->ingredients;
            $imagePath = asset('img/food/' . $val->image);
            $link = url('/specific-food-view/'.$val->id);
            $addCart = url('/add-to-cart/'.$val->id);
            $addCartAjax = url('/add-to-cart-ajax/'.$val->id);

            $output .= '
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card h-100 shadow-sm rounded-3">
                    <!-- Image -->
                    <a href="'.$link.'" class="d-block">
                        <img src="'.$imagePath.'" class="card-img-top img-fluid" alt="'.$val->name.'">
                    </a>

                    <!-- Card Body -->
                    <div class="card-body d-flex flex-column">
                        <!-- Name & Price -->
                        <h5 class="card-title mb-1 text-truncate">
                            <a href="'.$link.'" class="text-dark text-decoration-none">'.$name.'</a>
                        </h5>
                        <p class="text-success fw-bold mb-2">৳'.$val->price.'/-</p>

                        <!-- Ingredients -->
                        <p class="card-text text-muted small mb-3 text-truncate">'.$ingredients.'</p>

                        <!-- Buttons -->
                        <div class="mt-auto d-grid gap-2">
                            <a href="'.$addCart.'" class="btn btn-outline-success btn-sm d-flex align-items-center justify-content-center gap-1">
                                <i class="fa-solid fa-cart-plus"></i> Add Cart
                            </a>
                            <a href="'.$addCartAjax.'" class="btn btn-outline-warning btn-sm d-flex align-items-center justify-content-center gap-1 addCartBtn" data-url="'.$addCartAjax.'">
                                <i class="fa-solid fa-cart-plus"></i> Ajax
                            </a>
                        </div>
                    </div>
                </div>
            </div>';
        }

        if ($output == '') {
            $output = '<div class="col-12"><p class="text-center">No food found.</p></div>';
        }
        return response($output);
    }

    public function editFood($id){
        return Food::findOrFail($id);
    }

    public function create(){
        $company = Company::first();
        $categorys = FoodCategory::all();
        $foods = Food::with('category')->get();
        return view('food.crate-food', compact('company', 'foods', 'categorys'));
    }

    public function createFood(Request $request){
        try {
            $data = new Food;

            $data->name = $request->input('txtFoodName','');
            $data->price = $request->input('txtPrice','');
            $data->category_id = $request->input('cbxCategory','');
            $data->stock = $request->input('txtStock','');
            $data->sku = 'SKU-' . time();
            $data->status = $request->input('txtStatus','');
            
            $data->ingredients = $request->input('txtIngredients','');
            $data->remark = $request->input('remark','');

            $request->validate([
                'image' => 'nullable|image|max:5120', // max:5120 = 5MB
            ]);


            if ($request->file('image')) {

                $file = $request->file('image');
                if ($file->isValid()) {
                    $ext = $file->getClientOriginalExtension();
                    $fileName = 'food-' . time() . '.' . $ext;

                    $location = public_path('img/food');

                    if (!file_exists($location)) {
                        mkdir($location, 0755, true);
                    }

                    $file->move($location, $fileName);
                    $data->image = $fileName;
                }
            } 
            $data->save();
            return redirect()->back()->with('success','New food item added successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id){
        try {
            // Validate input
            $request->validate([
                'txtFoodName'    => 'required|string|max:255',
                'txtPrice'       => 'required|numeric|min:0',
                'txtCategory'    => 'required|integer|exists:food_categories,id',
                'txtStock'       => 'required|integer|min:0',
                'txtStatus'      => 'required|in:1,2',
                'txtIngredients' => 'required|string|max:500',
                'image'          => 'nullable|image|max:5120', // max 5MB
            ]);

            // Find food by ID
            $food = Food::findOrFail($id);

            // Update fields
            $food->name        = $request->txtFoodName;
            $food->price       = $request->txtPrice;
            $food->category_id = $request->txtCategory;
            $food->stock       = $request->txtStock;
            $food->status      = $request->txtStatus;
            $food->ingredients = $request->txtIngredients;
            $food->remark      = $request->remark;

            // Handle image upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');

                if ($file->isValid()) {
                    // Delete old image if exists
                    $oldImage = public_path('img/food/'.$food->image);
                    if(File::exists($oldImage)) {
                        File::delete($oldImage);
                    }

                    // Save new image
                    $ext = $file->getClientOriginalExtension();
                    $fileName = 'food-' . time() . '.' . $ext;
                    $file->move(public_path('img/food'), $fileName);
                    $food->image = $fileName;
                }
            }

            $food->save();

            return redirect()->back()->with('success', 'Food item updated successfully.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
