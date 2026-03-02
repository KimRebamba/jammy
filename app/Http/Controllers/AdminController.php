<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function accounts()
    {
        $accounts = DB::table('accounts')
            ->select(
                'user_id as ID',
                'username as Username',
                'email as Email',
                'profile_photo_url as Picture',
                'role as Role',
                'is_active as Active'
            )
            ->orderBy('user_id')
            ->get();

        return view('admin.accounts', compact('accounts'));
    }

   public function products()
{
    $products = DB::table('products as p')
        ->leftJoin('brands as b', 'p.brand_id', '=', 'b.brand_id')
        ->leftJoin('categories as c', 'p.category_id', '=', 'c.category_id')
        ->leftJoin('product_photos as pp', 'p.product_id', '=', 'pp.product_id')
        ->where('pp.is_primary', true) 
        ->select(
            'p.product_id as ID',
            'p.product_name as Product',
            'b.brand_name as Brand',
            'c.category_name as Category',
            'p.retail_price as Price',
            'p.stock_level as Stock',
            'pp.photo_url as Image'
        )
        ->get();

    return view('admin.products', compact('products'));
}

public function categories()
{
    $categories = DB::table('categories')
        ->select(
            'category_id as ID',
            'category_name as Category',
            'photo_url as Image',
            'is_active as Active'
        )
        ->get();

    return view('admin.categories', compact('categories'));
}

public function orders()
{
    $orders = DB::table('orders as o')
        ->leftJoin('accounts as a', 'o.user_id', '=', 'a.user_id')
        ->select(
            'o.order_id as ID',
            'a.username as Customer',
            'o.payment_status as Payment',
            'o.order_status as Status',
            'o.delivery_fee as Delivery',
            'o.date_ordered as Date'
        )
        ->get();

    return view('admin.orders', compact('orders'));
}

public function returns()
{
    $returns = DB::table('order_return as r')
        ->leftJoin('orders as o', 'r.order_id', '=', 'o.order_id')
        ->select(
            'r.order_return_id as ID',
            'o.order_id as OrderID',
            'r.reason as Reason',
            'r.cond as Condition',
            'r.return_status as Status',
            'r.refund_amount as Refund'
        )
        ->get();

    return view('admin.returns', compact('returns'));
}

public function reviews()
{
    $reviews = DB::table('product_review as pr')
        ->leftJoin('accounts as a', 'pr.user_id', '=', 'a.user_id')
        ->leftJoin('product_order as po', 'pr.product_order_id', '=', 'po.product_order_id')
        ->leftJoin('products as p', 'po.product_id', '=', 'p.product_id')
        ->select(
            'pr.review_id as ID',
            'a.username as Customer',
            'p.product_name as Product',
            'pr.rating as Rating',
            'pr.is_verified as Verified'
        )
        ->get();

    return view('admin.reviews', compact('reviews'));
}

public function employees()
{
    $employees = DB::table('employees as e')
        ->leftJoin('positions as p', 'e.current_position_id', '=', 'p.position_id')
        ->select(
            'e.emp_id as ID',
            DB::raw("CONCAT(e.first_name,' ',e.last_name) as Name"),
            'p.position_name as Position',
            'e.employment_status as Status',
            'e.hire_date as Hired'
        )
        ->get();

    return view('admin.employees', compact('employees'));
}

public function positions()
{
    $positions = DB::table('positions')
        ->select(
            'position_id as ID',
            'position_name as Position',
            'monthly_rate as Salary'
        )
        ->get();

    return view('admin.positions', compact('positions'));
}

public function expenses()
{
    $expenses = DB::table('expenses')
        ->select(
            'exp_id as ID',
            'expense_type as Type',
            'amount as Amount',
            'status as Status',
            'due_date as Due'
        )
        ->get();

    return view('admin.expenses', compact('expenses'));
}


public function reports()
{
    $totalSales = DB::table('product_order')
        ->select(DB::raw('SUM(quantity * unit_price) as total'))
        ->first();

    $totalExpenses = DB::table('expenses')
        ->where('status','paid')
        ->sum('amount');

    $totalOrders = DB::table('orders')->count();
    $totalProducts = DB::table('products')->count();
    $totalCustomers = DB::table('accounts')
        ->where('role','customer')
        ->count();

    $totalEmployees = DB::table('employees')->count();

    return view('admin.reports', compact(
        'totalSales',
        'totalExpenses',
        'totalOrders',
        'totalProducts',
        'totalCustomers',
        'totalEmployees'
    ));
}

}