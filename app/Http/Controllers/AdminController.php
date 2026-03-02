<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        return view('admin.accounts.index', compact('accounts'));
    }

    public function accountsCreate()
    {
        return view('admin.accounts.create');
    }

    public function accountsStore(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:50|unique:accounts,username',
            'password' => 'required|string|min:4',
            'email' => 'required|email|max:100|unique:accounts,email',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'role' => 'required|in:customer,admin',
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'profile_photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'is_active' => 'nullable|boolean',
        ]);

        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo_url')) {
            $file = $request->file('profile_photo_url');
            $filename = uniqid('profile_', true) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profiles'), $filename);
            $profilePhotoPath = 'images/profiles/' . $filename;
        }

        DB::table('accounts')->insert([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
            'address' => $data['address'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'role' => $data['role'],
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'profile_photo_url' => $profilePhotoPath,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/accounts')->with('success', 'Account created successfully');
    }

    public function accountsShow($id)
    {
        $account = DB::table('accounts')->where('user_id', $id)->first();
        if (!$account) {
            return redirect('/admin/accounts')->with('error', 'Account not found');
        }
        return view('admin.accounts.show', compact('account'));
    }

    public function accountsEdit($id)
    {
        $account = DB::table('accounts')->where('user_id', $id)->first();
        if (!$account) {
            return redirect('/admin/accounts')->with('error', 'Account not found');
        }
        return view('admin.accounts.edit', compact('account'));
    }

    public function accountsUpdate(Request $request, $id)
    {

        if(session('user')->id == $id && $request->input('is_active') == false){
            return redirect('/admin/accounts')->with('error', 'Cannot deactivate currently logged in account');
        }

        $account = DB::table('accounts')->where('user_id', $id)->first();
        if (!$account) {
            return redirect('/admin/accounts')->with('error', 'Account not found');
        }

        $data = $request->validate([
            'username' => 'required|string|max:50|unique:accounts,username,' . $id . ',user_id',
            'password' => 'nullable|string|min:4',
            'email' => 'required|email|max:100|unique:accounts,email,' . $id . ',user_id',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'role' => 'required|in:customer,admin',
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'profile_photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'is_active' => 'nullable|boolean',
        ]);

        $profilePhotoPath = $account->profile_photo_url;
        if ($request->hasFile('profile_photo_url')) {
            $file = $request->file('profile_photo_url');
            $filename = uniqid('profile_', true) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profiles'), $filename);
            $profilePhotoPath = 'images/profiles/' . $filename;
        }

        $update = [
            'username' => $data['username'],
            'email' => $data['email'],
            'address' => $data['address'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'role' => $data['role'],
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'profile_photo_url' => $profilePhotoPath,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'updated_at' => now(),
        ];

        if (!empty($data['password'])) {
            $update['password'] = Hash::make($data['password']);
        }

        DB::table('accounts')->where('user_id', $id)->update($update);

        return redirect('/admin/accounts')->with('success', 'Account updated successfully');
    }

    public function accountsDelete($id)
    {
        if(session('user')->id == $id){
            return redirect('/admin/accounts')->with('error', 'Cannot delete currently logged in account');
        }

        DB::table('accounts')->where('user_id', $id)->delete();
        return redirect('/admin/accounts')->with('success', 'Account deleted successfully');
    }

    public function products()
    {
        $products = DB::table('products as p')
            ->leftJoin('brands as b', 'p.brand_id', '=', 'b.brand_id')
            ->leftJoin('categories as c', 'p.category_id', '=', 'c.category_id')
            ->leftJoin('product_photos as pp', function ($join) {
                $join->on('p.product_id', '=', 'pp.product_id')
                    ->where('pp.is_primary', true);
            })
            ->select(
                'p.product_id as ID',
                'p.product_name as Product',
                'b.brand_name as Brand',
                'c.category_name as Category',
                'p.retail_price as Price',
                'p.stock_level as Stock',
                'pp.photo_url as Image'
            )
            ->orderBy('p.product_id')
            ->get();

        return view('admin.products.index', compact('products'));
    }

    public function productsCreate()
    {
        $brands = DB::table('brands')->orderBy('brand_name')->get();
        $categories = DB::table('categories')->orderBy('category_name')->get();
        return view('admin.products.create', compact('brands', 'categories'));
    }

    public function productsStore(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|string',
            'brand_id' => 'nullable|exists:brands,brand_id',
            'category_id' => 'nullable|exists:categories,category_id',
            'model' => 'nullable|string',
            'retail_price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'stock_level' => 'required|integer',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $productId = DB::table('products')->insertGetId([
            'product_name' => $data['product_name'],
            'brand_id' => $data['brand_id'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'model' => $data['model'] ?? null,
            'retail_price' => $data['retail_price'],
            'cost_price' => $data['cost_price'],
            'description' => $data['description'] ?? null,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'stock_level' => $data['stock_level'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $photoPath = null;
        if ($request->hasFile('photo_url')) {
            $file = $request->file('photo_url');
            $filename = uniqid('product_', true) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $filename);
            $photoPath = 'images/products/' . $filename;
        }

        if ($photoPath !== null) {
            DB::table('product_photos')->insert([
                'product_id' => $productId,
                'photo_url' => $photoPath,
                'is_primary' => 1,
                'sort_order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('/admin/products')->with('success', 'Product created successfully');
    }

    public function productsShow($id)
    {
        $product = DB::table('products as p')
            ->leftJoin('brands as b', 'p.brand_id', '=', 'b.brand_id')
            ->leftJoin('categories as c', 'p.category_id', '=', 'c.category_id')
            ->leftJoin('product_photos as pp', function ($join) {
                $join->on('p.product_id', '=', 'pp.product_id')
                    ->where('pp.is_primary', true);
            })
            ->where('p.product_id', $id)
            ->select(
                'p.*',
                'b.brand_name',
                'c.category_name',
                'pp.photo_url as primary_photo'
            )
            ->first();

        if (!$product) {
            return redirect('/admin/products')->with('error', 'Product not found');
        }

        return view('admin.products.show', compact('product'));
    }

    public function productsEdit($id)
    {
        $product = DB::table('products')->where('product_id', $id)->first();
        if (!$product) {
            return redirect('/admin/products')->with('error', 'Product not found');
        }

        $primaryPhoto = DB::table('product_photos')
            ->where('product_id', $id)
            ->where('is_primary', true)
            ->first();

        $brands = DB::table('brands')->orderBy('brand_name')->get();
        $categories = DB::table('categories')->orderBy('category_name')->get();

        return view('admin.products.edit', compact('product', 'primaryPhoto', 'brands', 'categories'));
    }

    public function productsUpdate(Request $request, $id)
    {
        $product = DB::table('products')->where('product_id', $id)->first();
        if (!$product) {
            return redirect('/admin/products')->with('error', 'Product not found');
        }

        $data = $request->validate([
            'product_name' => 'required|string',
            'brand_id' => 'nullable|exists:brands,brand_id',
            'category_id' => 'nullable|exists:categories,category_id',
            'model' => 'nullable|string',
            'retail_price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'stock_level' => 'required|integer',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        DB::table('products')->where('product_id', $id)->update([
            'product_name' => $data['product_name'],
            'brand_id' => $data['brand_id'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'model' => $data['model'] ?? null,
            'retail_price' => $data['retail_price'],
            'cost_price' => $data['cost_price'],
            'description' => $data['description'] ?? null,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'stock_level' => $data['stock_level'],
            'updated_at' => now(),
        ]);

        $photoUrl = null;
        if ($request->hasFile('photo_url')) {
            $file = $request->file('photo_url');
            $filename = uniqid('product_', true) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $filename);
            $photoUrl = 'images/products/' . $filename;
        }

        if ($photoUrl !== null && $photoUrl !== '') {
            $primaryPhoto = DB::table('product_photos')
                ->where('product_id', $id)
                ->where('is_primary', true)
                ->first();

            if ($primaryPhoto) {
                DB::table('product_photos')
                    ->where('product_photo_id', $primaryPhoto->product_photo_id)
                    ->update([
                        'photo_url' => $photoUrl,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('product_photos')->insert([
                    'product_id' => $id,
                    'photo_url' => $photoUrl,
                    'is_primary' => 1,
                    'sort_order' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect('/admin/products')->with('success', 'Product updated successfully');
    }

    public function productsDelete($id)
    {
        $hasOrders = DB::table('product_order')->where('product_id', $id)->exists();
        if ($hasOrders) {
            return redirect('/admin/products')->with('error', 'Cannot delete product that has been ordered');
        }

        DB::table('products')->where('product_id', $id)->delete();
        return redirect('/admin/products')->with('success', 'Product deleted successfully');
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
            ->orderBy('category_id')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function categoriesCreate()
    {
        return view('admin.categories.create');
    }

    public function categoriesStore(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|string|unique:categories,category_name',
            'description' => 'nullable|string',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'is_active' => 'nullable|boolean',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo_url')) {
            $file = $request->file('photo_url');
            $filename = uniqid('category_', true) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/categories'), $filename);
            $photoPath = 'images/categories/' . $filename;
        }

        DB::table('categories')->insert([
            'category_name' => $data['category_name'],
            'description' => $data['description'] ?? null,
            'photo_url' => $photoPath,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/categories')->with('success', 'Category created successfully');
    }

    public function categoriesShow($id)
    {
        $category = DB::table('categories')->where('category_id', $id)->first();
        if (!$category) {
            return redirect('/admin/categories')->with('error', 'Category not found');
        }
        return view('admin.categories.show', compact('category'));
    }

    public function categoriesEdit($id)
    {
        $category = DB::table('categories')->where('category_id', $id)->first();
        if (!$category) {
            return redirect('/admin/categories')->with('error', 'Category not found');
        }
        return view('admin.categories.edit', compact('category'));
    }

    public function categoriesUpdate(Request $request, $id)
    {
        $category = DB::table('categories')->where('category_id', $id)->first();
        if (!$category) {
            return redirect('/admin/categories')->with('error', 'Category not found');
        }

        $data = $request->validate([
            'category_name' => 'required|string|unique:categories,category_name,' . $id . ',category_id',
            'description' => 'nullable|string',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'is_active' => 'nullable|boolean',
        ]);

        $photoPath = $category->photo_url;
        if ($request->hasFile('photo_url')) {
            $file = $request->file('photo_url');
            $filename = uniqid('category_', true) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/categories'), $filename);
            $photoPath = 'images/categories/' . $filename;
        }

        DB::table('categories')->where('category_id', $id)->update([
            'category_name' => $data['category_name'],
            'description' => $data['description'] ?? null,
            'photo_url' => $photoPath,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'updated_at' => now(),
        ]);

        return redirect('/admin/categories')->with('success', 'Category updated successfully');
    }

    public function categoriesDelete($id)
    {
        DB::table('categories')->where('category_id', $id)->delete();
        return redirect('/admin/categories')->with('success', 'Category deleted successfully');
    }

    public function orders()
    {
        $orders = DB::table('orders as o')
            ->leftJoin('accounts as a', 'o.user_id', '=', 'a.user_id')
            ->leftJoin('product_order as po', 'o.order_id', '=', 'po.order_id')
            ->leftJoin('products as p', 'po.product_id', '=', 'p.product_id')
            ->select(
                'o.order_id as ID',
                'a.username as Customer',
                'o.payment_status as Payment',
                'o.order_status as Status',
                'o.delivery_fee as Delivery',
                'o.date_ordered as Date',
                DB::raw('GROUP_CONCAT(CONCAT(p.product_name, " x", po.quantity) SEPARATOR ", ") as Items')
            )
            ->groupBy('o.order_id', 'a.username', 'o.payment_status', 'o.order_status', 'o.delivery_fee', 'o.date_ordered')
            ->orderBy('o.order_id')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function ordersShow($id)
    {
        $order = DB::table('orders as o')
            ->leftJoin('accounts as a', 'o.user_id', '=', 'a.user_id')
            ->where('o.order_id', $id)
            ->select('o.*', 'a.username')
            ->first();

        if (!$order) {
            return redirect('/admin/orders')->with('error', 'Order not found');
        }

        $items = DB::table('product_order as po')
            ->leftJoin('products as p', 'po.product_id', '=', 'p.product_id')
            ->where('po.order_id', $id)
            ->select('p.product_name', 'po.quantity', 'po.unit_price')
            ->get();

        return view('admin.orders.show', compact('order', 'items'));
    }

    public function ordersEdit($id)
    {
        $order = DB::table('orders')->where('order_id', $id)->first();
        if (!$order) {
            return redirect('/admin/orders')->with('error', 'Order not found');
        }
        return view('admin.orders.edit', compact('order'));
    }

    public function ordersUpdate(Request $request, $id)
    {
        $order = DB::table('orders')->where('order_id', $id)->first();
        if (!$order) {
            return redirect('/admin/orders')->with('error', 'Order not found');
        }

        $data = $request->validate([
            'payment_status' => 'required|in:pending,paid,refunded',
            'order_status' => 'required|in:pending,processing,shipped,completed,cancelled,requested_refund,returned',
            'payment_option' => 'nullable|string',
            'delivery_fee' => 'required|numeric',
        ]);

        DB::table('orders')->where('order_id', $id)->update([
            'payment_status' => $data['payment_status'],
            'order_status' => $data['order_status'],
            'payment_option' => $data['payment_option'] ?? null,
            'delivery_fee' => $data['delivery_fee'],
            'updated_at' => now(),
        ]);

        return redirect('/admin/orders')->with('success', 'Order updated successfully');
    }

    public function ordersDelete($id)
    {
        DB::table('orders')->where('order_id', $id)->delete();
        return redirect('/admin/orders')->with('success', 'Order deleted successfully');
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
            ->orderBy('r.order_return_id')
            ->get();

        return view('admin.returns.index', compact('returns'));
    }

    public function returnsShow($id)
    {
        $return = DB::table('order_return as r')
            ->leftJoin('orders as o', 'r.order_id', '=', 'o.order_id')
            ->leftJoin('accounts as a', 'o.user_id', '=', 'a.user_id')
            ->where('r.order_return_id', $id)
            ->select('r.*', 'o.order_id', 'a.username')
            ->first();

        if (!$return) {
            return redirect('/admin/returns')->with('error', 'Return not found');
        }

        return view('admin.returns.show', compact('return'));
    }

    public function returnsEdit($id)
    {
        $return = DB::table('order_return')->where('order_return_id', $id)->first();
        if (!$return) {
            return redirect('/admin/returns')->with('error', 'Return not found');
        }
        return view('admin.returns.edit', compact('return'));
    }

    public function returnsUpdate(Request $request, $id)
    {
        $return = DB::table('order_return')->where('order_return_id', $id)->first();
        if (!$return) {
            return redirect('/admin/returns')->with('error', 'Return not found');
        }

        $data = $request->validate([
            'return_status' => 'required|in:requested,approved,rejected,processed',
        ]);

        DB::table('order_return')->where('order_return_id', $id)->update([
            'return_status' => $data['return_status'],
            'updated_at' => now(),
        ]);

        return redirect('/admin/returns')->with('success', 'Return status updated successfully');
    }

    public function returnsDelete($id)
    {
        DB::table('order_return')->where('order_return_id', $id)->delete();
        return redirect('/admin/returns')->with('success', 'Return deleted successfully');
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
            ->orderBy('pr.review_id')
            ->get();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function reviewsShow($id)
    {
        $review = DB::table('product_review as pr')
            ->leftJoin('accounts as a', 'pr.user_id', '=', 'a.user_id')
            ->leftJoin('product_order as po', 'pr.product_order_id', '=', 'po.product_order_id')
            ->leftJoin('products as p', 'po.product_id', '=', 'p.product_id')
            ->where('pr.review_id', $id)
            ->select('pr.*', 'a.username', 'p.product_name')
            ->first();

        if (!$review) {
            return redirect('/admin/reviews')->with('error', 'Review not found');
        }

        return view('admin.reviews.show', compact('review'));
    }

    public function reviewsEdit($id)
    {
        $review = DB::table('product_review')->where('review_id', $id)->first();
        if (!$review) {
            return redirect('/admin/reviews')->with('error', 'Review not found');
        }
        return view('admin.reviews.edit', compact('review'));
    }

    public function reviewsUpdate(Request $request, $id)
    {
        $review = DB::table('product_review')->where('review_id', $id)->first();
        if (!$review) {
            return redirect('/admin/reviews')->with('error', 'Review not found');
        }

        $data = $request->validate([
            'is_verified' => 'nullable|boolean',
        ]);

        DB::table('product_review')->where('review_id', $id)->update([
            'is_verified' => $request->has('is_verified') ? 1 : 0,
            'updated_at' => now(),
        ]);

        return redirect('/admin/reviews')->with('success', 'Review verification updated successfully');
    }

    public function reviewsDelete($id)
    {
        DB::table('product_review')->where('review_id', $id)->delete();
        return redirect('/admin/reviews')->with('success', 'Review deleted successfully');
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
            ->orderBy('e.emp_id')
            ->get();

        return view('admin.employees.index', compact('employees'));
    }

    public function employeesCreate()
    {
        $positions = DB::table('positions')->orderBy('position_name')->get();
        return view('admin.employees.create', compact('positions'));
    }

    public function employeesStore(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'nullable|email|unique:employees,email',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'employment_status' => 'required|in:active,inactive,terminated,on_leave',
            'hire_date' => 'nullable|date',
            'current_position_id' => 'nullable|exists:positions,position_id',
        ]);

        DB::table('employees')->insert([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'address' => $data['address'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
            'gender' => $data['gender'] ?? null,
            'employment_status' => $data['employment_status'],
            'hire_date' => $data['hire_date'] ?? null,
            'current_position_id' => $data['current_position_id'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/employees')->with('success', 'Employee created successfully');
    }

    public function employeesShow($id)
    {
        $employee = DB::table('employees as e')
            ->leftJoin('positions as p', 'e.current_position_id', '=', 'p.position_id')
            ->where('e.emp_id', $id)
            ->select('e.*', 'p.position_name')
            ->first();

        if (!$employee) {
            return redirect('/admin/employees')->with('error', 'Employee not found');
        }

        return view('admin.employees.show', compact('employee'));
    }

    public function employeesEdit($id)
    {
        $employee = DB::table('employees')->where('emp_id', $id)->first();
        if (!$employee) {
            return redirect('/admin/employees')->with('error', 'Employee not found');
        }
        $positions = DB::table('positions')->orderBy('position_name')->get();
        return view('admin.employees.edit', compact('employee', 'positions'));
    }

    public function employeesUpdate(Request $request, $id)
    {
        $employee = DB::table('employees')->where('emp_id', $id)->first();
        if (!$employee) {
            return redirect('/admin/employees')->with('error', 'Employee not found');
        }

        $data = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'nullable|email|unique:employees,email,' . $id . ',emp_id',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'employment_status' => 'required|in:active,inactive,terminated,on_leave',
            'hire_date' => 'nullable|date',
            'current_position_id' => 'nullable|exists:positions,position_id',
        ]);

        DB::table('employees')->where('emp_id', $id)->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'address' => $data['address'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
            'gender' => $data['gender'] ?? null,
            'employment_status' => $data['employment_status'],
            'hire_date' => $data['hire_date'] ?? null,
            'current_position_id' => $data['current_position_id'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect('/admin/employees')->with('success', 'Employee updated successfully');
    }

    public function employeesDelete($id)
    {
        DB::table('employees')->where('emp_id', $id)->delete();
        return redirect('/admin/employees')->with('success', 'Employee deleted successfully');
    }


    public function positions()
    {
        $positions = DB::table('positions')
            ->select(
                'position_id as ID',
                'position_name as Position',
                'monthly_rate as Salary'
            )
            ->orderBy('position_id')
            ->get();

        return view('admin.positions.index', compact('positions'));
    }

    public function positionsCreate()
    {
        return view('admin.positions.create');
    }

    public function positionsStore(Request $request)
    {
        $data = $request->validate([
            'position_name' => 'required|string',
            'monthly_rate' => 'required|numeric',
        ]);

        DB::table('positions')->insert([
            'position_name' => $data['position_name'],
            'monthly_rate' => $data['monthly_rate'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/positions')->with('success', 'Position created successfully');
    }

    public function positionsShow($id)
    {
        $position = DB::table('positions')->where('position_id', $id)->first();
        if (!$position) {
            return redirect('/admin/positions')->with('error', 'Position not found');
        }
        return view('admin.positions.show', compact('position'));
    }

    public function positionsEdit($id)
    {
        $position = DB::table('positions')->where('position_id', $id)->first();
        if (!$position) {
            return redirect('/admin/positions')->with('error', 'Position not found');
        }
        return view('admin.positions.edit', compact('position'));
    }

    public function positionsUpdate(Request $request, $id)
    {
        $position = DB::table('positions')->where('position_id', $id)->first();
        if (!$position) {
            return redirect('/admin/positions')->with('error', 'Position not found');
        }

        $data = $request->validate([
            'position_name' => 'required|string',
            'monthly_rate' => 'required|numeric',
        ]);

        DB::table('positions')->where('position_id', $id)->update([
            'position_name' => $data['position_name'],
            'monthly_rate' => $data['monthly_rate'],
            'updated_at' => now(),
        ]);

        return redirect('/admin/positions')->with('success', 'Position updated successfully');
    }

    public function positionsDelete($id)
    {
        DB::table('positions')->where('position_id', $id)->delete();
        return redirect('/admin/positions')->with('success', 'Position deleted successfully');
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
            ->orderBy('exp_id')
            ->get();

        return view('admin.expenses.index', compact('expenses'));
    }

    public function expensesCreate()
    {
        return view('admin.expenses.create');
    }

    public function expensesStore(Request $request)
    {
        $data = $request->validate([
            'expense_type' => 'required|in:inventory_purchase,shipping,maintenance,rent,utilities,other',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'status' => 'required|in:pending,paid',
            'due_date' => 'nullable|date',
            'paid_date' => 'nullable|date',
        ]);

        DB::table('expenses')->insert([
            'expense_type' => $data['expense_type'],
            'description' => $data['description'] ?? null,
            'amount' => $data['amount'],
            'status' => $data['status'],
            'due_date' => $data['due_date'] ?? null,
            'paid_date' => $data['paid_date'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/expenses')->with('success', 'Expense created successfully');
    }

    public function expensesShow($id)
    {
        $expense = DB::table('expenses')->where('exp_id', $id)->first();
        if (!$expense) {
            return redirect('/admin/expenses')->with('error', 'Expense not found');
        }
        return view('admin.expenses.show', compact('expense'));
    }

    public function expensesEdit($id)
    {
        $expense = DB::table('expenses')->where('exp_id', $id)->first();
        if (!$expense) {
            return redirect('/admin/expenses')->with('error', 'Expense not found');
        }
        return view('admin.expenses.edit', compact('expense'));
    }

    public function expensesUpdate(Request $request, $id)
    {
        $expense = DB::table('expenses')->where('exp_id', $id)->first();
        if (!$expense) {
            return redirect('/admin/expenses')->with('error', 'Expense not found');
        }

        $data = $request->validate([
            'expense_type' => 'required|in:inventory_purchase,shipping,maintenance,rent,utilities,other',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'status' => 'required|in:pending,paid',
            'due_date' => 'nullable|date',
            'paid_date' => 'nullable|date',
        ]);

        DB::table('expenses')->where('exp_id', $id)->update([
            'expense_type' => $data['expense_type'],
            'description' => $data['description'] ?? null,
            'amount' => $data['amount'],
            'status' => $data['status'],
            'due_date' => $data['due_date'] ?? null,
            'paid_date' => $data['paid_date'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect('/admin/expenses')->with('success', 'Expense updated successfully');
    }

    public function expensesDelete($id)
    {
        DB::table('expenses')->where('exp_id', $id)->delete();
        return redirect('/admin/expenses')->with('success', 'Expense deleted successfully');
    }

    public function salaries()
    {
        $salaries = DB::table('salaries as s')
            ->leftJoin('employees as e', 's.emp_id', '=', 'e.emp_id')
            ->select(
                's.salary_id as ID',
                DB::raw("CONCAT(e.first_name,' ',e.last_name) as Employee"),
                's.pay_date as PayDate',
                's.rate_used as Rate',
                's.status as Status'
            )
            ->orderBy('s.pay_date', 'desc')
            ->get();

        return view('admin.salaries.index', compact('salaries'));
    }

    public function salariesCreate()
    {
        $employees = DB::table('employees')->orderBy('last_name')->get();
        return view('admin.salaries.create', compact('employees'));
    }

    public function salariesStore(Request $request)
    {
        $data = $request->validate([
            'emp_id' => 'required|exists:employees,emp_id',
            'pay_date' => 'required|date',
            'rate_used' => 'required|numeric',
            'status' => 'required|in:pending,paid,cancelled',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
        ]);

        $exists = DB::table('salaries')
            ->where('emp_id', $data['emp_id'])
            ->where('from_date', $data['from_date'] ?? null)
            ->where('to_date', $data['to_date'] ?? null)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Salary record for this period already exists');
        }

        DB::table('salaries')->insert([
            'emp_id' => $data['emp_id'],
            'pay_date' => $data['pay_date'],
            'rate_used' => $data['rate_used'],
            'status' => $data['status'],
            'from_date' => $data['from_date'] ?? null,
            'to_date' => $data['to_date'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/salaries')->with('success', 'Salary created successfully');
    }

    public function salariesShow($id)
    {
        $salary = DB::table('salaries as s')
            ->leftJoin('employees as e', 's.emp_id', '=', 'e.emp_id')
            ->where('s.salary_id', $id)
            ->select('s.*', DB::raw("CONCAT(e.first_name,' ',e.last_name) as employee_name"))
            ->first();

        if (!$salary) {
            return redirect('/admin/salaries')->with('error', 'Salary not found');
        }

        return view('admin.salaries.show', compact('salary'));
    }

    public function salariesEdit($id)
    {
        $salary = DB::table('salaries')->where('salary_id', $id)->first();
        if (!$salary) {
            return redirect('/admin/salaries')->with('error', 'Salary not found');
        }
        $employees = DB::table('employees')->orderBy('last_name')->get();
        return view('admin.salaries.edit', compact('salary', 'employees'));
    }

    public function salariesUpdate(Request $request, $id)
    {
        $salary = DB::table('salaries')->where('salary_id', $id)->first();
        if (!$salary) {
            return redirect('/admin/salaries')->with('error', 'Salary not found');
        }

        $data = $request->validate([
            'emp_id' => 'required|exists:employees,emp_id',
            'pay_date' => 'required|date',
            'rate_used' => 'required|numeric',
            'status' => 'required|in:pending,paid,cancelled',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
        ]);

        DB::table('salaries')->where('salary_id', $id)->update([
            'emp_id' => $data['emp_id'],
            'pay_date' => $data['pay_date'],
            'rate_used' => $data['rate_used'],
            'status' => $data['status'],
            'from_date' => $data['from_date'] ?? null,
            'to_date' => $data['to_date'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect('/admin/salaries')->with('success', 'Salary updated successfully');
    }

    public function salariesDelete($id)
    {
        DB::table('salaries')->where('salary_id', $id)->delete();
        return redirect('/admin/salaries')->with('success', 'Salary deleted successfully');
    }

    public function brands()
    {
        $brands = DB::table('brands')
            ->select(
                'brand_id as ID',
                'brand_name as Brand',
                'logo_url as Logo',
                'website as Website',
                'is_active as Active'
            )
            ->orderBy('brand_id')
            ->get();

        return view('admin.brands.index', compact('brands'));
    }

    public function brandsCreate()
    {
        return view('admin.brands.create');
    }

    public function brandsStore(Request $request)
    {
        $data = $request->validate([
            'brand_name' => 'required|string|unique:brands,brand_name',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'website' => 'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo_url')) {
            $file = $request->file('logo_url');
            $filename = uniqid('brand_', true) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/brands'), $filename);
            $logoPath = 'images/brands/' . $filename;
        }

        DB::table('brands')->insert([
            'brand_name' => $data['brand_name'],
            'logo_url' => $logoPath,
            'website' => $data['website'] ?? null,
            'description' => $data['description'] ?? null,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/brands')->with('success', 'Brand created successfully');
    }

    public function brandsShow($id)
    {
        $brand = DB::table('brands')->where('brand_id', $id)->first();
        if (!$brand) {
            return redirect('/admin/brands')->with('error', 'Brand not found');
        }
        return view('admin.brands.show', compact('brand'));
    }

    public function brandsEdit($id)
    {
        $brand = DB::table('brands')->where('brand_id', $id)->first();
        if (!$brand) {
            return redirect('/admin/brands')->with('error', 'Brand not found');
        }
        return view('admin.brands.edit', compact('brand'));
    }

    public function brandsUpdate(Request $request, $id)
    {
        $brand = DB::table('brands')->where('brand_id', $id)->first();
        if (!$brand) {
            return redirect('/admin/brands')->with('error', 'Brand not found');
        }

        $data = $request->validate([
            'brand_name' => 'required|string|unique:brands,brand_name,' . $id . ',brand_id',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'website' => 'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $logoPath = $brand->logo_url;
        if ($request->hasFile('logo_url')) {
            $file = $request->file('logo_url');
            $filename = uniqid('brand_', true) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/brands'), $filename);
            $logoPath = 'images/brands/' . $filename;
        }

        DB::table('brands')->where('brand_id', $id)->update([
            'brand_name' => $data['brand_name'],
            'logo_url' => $logoPath,
            'website' => $data['website'] ?? null,
            'description' => $data['description'] ?? null,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'updated_at' => now(),
        ]);

        return redirect('/admin/brands')->with('success', 'Brand updated successfully');
    }

    public function brandsDelete($id)
    {
        DB::table('brands')->where('brand_id', $id)->delete();
        return redirect('/admin/brands')->with('success', 'Brand deleted successfully');
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