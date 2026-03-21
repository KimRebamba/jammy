<!DOCTYPE html>
<html>
<head>
    <title>Reviews</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDrpNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/2.2.1/dataTables.bootstrap5.min.css"
        integrity="sha512-pVSTZJo4Kj/eLMUG1w+itkGx+scwF00G5dMb02FjgU9WwF7F/cpZvu1Bf1ojA3iAf8y94cltGnuPV9vwv3CgZw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
        integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $('#reviewsTable').DataTable();
        });
    </script>
</head>
<body class="container mt-4">

<h2>Reviews</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

@if($errors->any())
    <ul style="color:red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="post" action="/admin/reviews/batch">
@csrf

<table id="reviewsTable" class="table table-striped table-bordered">
<tr>
    <th>Select</th>
    <th>ID</th>
    <th>Customer</th>
    <th>Product</th>
    <th>Rating</th>
    <th>Verified</th>
    <th>Actions</th>
</tr>

@foreach($reviews as $review)
<tr>
    <td>
        <input type="checkbox" name="selected_ids[]" value="{{ $review->ID }}">
    </td>
    <td>{{ $review->ID }}</td>
    <td>{{ $review->Customer }}</td>
    <td>{{ $review->Product }}</td>
    <td>{{ $review->Rating }}</td>
    <td>{{ $review->Verified ? 'Yes' : 'No' }}</td>
    <td>
        <a href="/admin/reviews/{{ $review->ID }}">View</a> |
        <a href="/admin/reviews/{{ $review->ID }}/edit">Edit</a> |
        <form action="/admin/reviews/{{ $review->ID }}/delete" method="post" style="display:inline;">
            @csrf
            <button type="submit">Delete</button>
        </form>
    </td>
</tr>
@endforeach

</table>

<div class="mt-2">
    <button type="submit" class="btn btn-danger">Delete Selected</button>
</div>

</form>

<br>
<a href="/admin/dashboard" class="btn btn-secondary">Back</a>

</body>
</html>
