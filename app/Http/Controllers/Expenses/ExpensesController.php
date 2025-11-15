<?php

namespace App\Http\Controllers\Expenses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubcategory;

class ExpensesController extends Controller
{
    public function index(){
        $company = Company::first();
        $expenses = Expense::with('category','subcategory','user')->orderByDesc('id')->get();
        $categories = ExpenseCategory::all();
        $subCategory = ExpenseSubcategory::all();
        return view('expenses.expenses', compact('company','categories','subCategory','expenses'));
    }

    public function getSubcategories($categoryId) {
        $subcategories = ExpenseSubcategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    public function create(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:expense_categories,id',
            'subcategory_id' => 'required|exists:expense_subcategories,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:1000',
        ]);

        $data = new Expense();
        $data->title = $request->title;
        $data->category_id = $request->category_id;
        $data->user_id = Auth::guard('admin')->user()->id;
        $data->subcategory_id = $request->subcategory_id;
        $data->amount = $request->amount;
        $data->expense_date = Carbon::now()->format('Y-m-d');
        $data->description = $request->description;
        $data->save();

        return redirect()->back()->with('success', 'Expense added successfully!');
    }

    public function setting(){
        $company = Company::first();
        $categories = ExpenseCategory::all();
        $subCategory = ExpenseSubcategory::with('category')->get();
        return view('expenses.expenses-setting', compact('company','categories','subCategory'));
    }

    public function createCategory(Request $request){
        $request->validate([
            'name' => 'required|string|max:255|unique:expense_categories,name',
            'description' => 'nullable|string|max:1000',
        ]);

        $data = new ExpenseCategory();
        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();

        return redirect()->back()->with('success', 'Expense category added successfully!');
    }

    public function createSubCategory(Request $request){
        $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'name' => 'required|string|max:255|unique:expense_subcategories,name',
            'description' => 'nullable|string|max:1000',
        ]);

        $data = new ExpenseSubcategory();
        $data->category_id = $request->category_id;
        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();
        return redirect()->back()->with('success', 'Expense Sub-category added successfully!');
    }

    public function printExInv($id){
        $company = Company::first();
        $expenses = Expense::where('id', $id)->first();
        if(empty($expenses)){
            return redirect()->back()->with('error', 'Expenses invoice not found. Please try another. Thank You!');
        }
        return view('expenses.print.print-expenses-invoice', compact('company', 'expenses'));
    }
}
