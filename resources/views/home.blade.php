<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name', 'Jammy - Home') }}</title>
</head>
<body>
<h2>Home Page</h2>

<p>Welcome, 
    @if(!session('user'))
        guest!
    @else
          {{ session('user')->username }}
    @endif
</p>
    
    <br>

    @if(session('user'))
        <a href="/logout">Logout</a>
    @else
        <a href="/login">Login</a>
    @endif

<hr>

<h3>Search Products</h3>
<form method="GET" action="/home">
    <p>
        <input type="text" name="q" value="{{ $searchTerm ?? '' }}" placeholder="Search products...">
        <button type="submit">Search</button>
    </p>
</form>

@if(isset($searchTerm) && $searchTerm !== '')
    <h4>Search results for "{{ $searchTerm }}"</h4>

    @if($products && $products->count() > 0)
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            @foreach($products as $product)
                <tr>
                    <td>
                        @if($product->photo_url)
                            <img src="{{ asset($product->photo_url) }}" alt="{{ $product->product_name }}" width="80">
                        @endif
                    </td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ number_format($product->retail_price, 2) }}</td>
                    <td>
                        <a href="/shop/products/{{ $product->product_id }}">View</a>
                    </td>
                </tr>
            @endforeach
        </table>

        @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <p>
                {{ $products->withQueryString()->links() }}
            </p>
        @endif
    @else
        <p>No products found.</p>
    @endif
@endif

</body>
</html>