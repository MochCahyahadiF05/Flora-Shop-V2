@extends('layouts.admin')

@section('content')
    <div class="col-12">
        <div class="row">
            <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-center">
                    Product Table
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">+ Add Product</button>
                </h5>
                <div class="table-responsive text-nowrap">
                    <table class="table" id="productTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Image</th>
                                <th>Average Rating</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php use Illuminate\Support\Str; @endphp
                            @foreach ($products as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ Str::limit($product->description, 30, '...') }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        @if ($product->mainImage())
                                            <img src="{{ asset('storage/' . $product->mainImage()->image) }}"
                                                alt="Main Image" width="75">
                                        @endif
                                        {{-- @if ($product->image) --}}
                                        {{-- <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" style="width: 50px; height: 50px;"> --}}
                                        {{-- @else --}}
                                        {{-- No Image --}}
                                        {{-- @endif --}}
                                    </td>
                                    <td>{{ $product->average_rating }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>


                                            <div class="dropdown-menu">
                                                <a class="dropdown-item edit-btn" href="#"
                                                    data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                                    data-description="{{ $product->description }}"
                                                    data-price="{{ $product->price }}" data-stock="{{ $product->stock }}"
                                                    data-category="{{ $product->category->id }}"
                                                    data-image="{{ $product->image }}" data-bs-toggle="modal"
                                                    data-bs-target="#editModal">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <a href="#" class="dropdown-item text-primary show-btn"
                                                    data-name="{{ $product->name }}"
                                                    data-description="{{ $product->description }}"
                                                    data-price="{{ $product->price }}" data-stock="{{ $product->stock }}"
                                                    data-category="{{ $product->category->name }}"
                                                    data-images='@json($product->images->pluck('image'))' data-bs-toggle="modal"
                                                    data-bs-target="#showModal">
                                                    <i class="bx bx-show me-1"></i> Show
                                                </a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                    onsubmit="return confirm('Delete this product?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item text-danger" type="submit"><i
                                                            class="bx bx-trash me-1"></i> Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    @include('admin.pages.product.create')

    <!-- Edit Modal -->
    @include('admin.pages.product.update')

    <!-- Edit Modal -->
    @include('admin.pages.product.show')
@endsection

@push('scripts')
    <!-- jQuery + DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#productTable').DataTable();

            // Isi form edit saat tombol edit ditekan
            $('.edit-btn').on('click', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const description = $(this).data('description');
                const price = $(this).data('price');
                const stock = $(this).data('stock');
                const category = $(this).data('category');
                const image = $(this).data('image');

                $('#editForm').attr('action', '/admin/products/' + id);
                $('#edit-id').val(id);
                $('#edit-name').val(name);
                $('#edit-description').val(description);
                $('#edit-price').val(price);
                $('#edit-stock').val(stock);
                $('#edit-category').val(category);

                // Set preview image for edit modal
                if (image) {
                    $('#edit-image-preview').attr('src', '/storage/' + image).show();
                } else {
                    $('#edit-image-preview').hide();
                }
            });

            // Show Modal
            $('.show-btn').on('click', function() {
                $('#show-name').text($(this).data('name'));
                $('#show-description').text($(this).data('description'));
                $('#show-price').text($(this).data('price'));
                $('#show-stock').text($(this).data('stock'));
                $('#show-category').text($(this).data('category'));

                let images = $(this).data('images'); // array
                let carousel = $('#carousel-images');
                carousel.empty();

                images.forEach((img, index) => {
                    carousel.append(`
                    <div class="carousel-item ${index === 0 ? 'active' : ''}">
                        <img src="/storage/${img}" class="d-block mx-auto" style="max-height: 300px; width: auto;" alt="Image ${index + 1}">
                    </div>
                `);
                });
            });
        });
    </script>
@endpush
