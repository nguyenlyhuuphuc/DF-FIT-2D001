@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Product Form</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Product Form</li>
        </ol>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            @if (session('message'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    </div>
                </div>
            @endif
            <div class="card-header">
            <h3 class="card-title">Product</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                <label for="name">Name</label>
                <input type="text" value="{{ old('name') }}" name="name" class="form-control" id="name" placeholder="Enter name">
                @error('name')
                    <span class="text-danger">{{ $message }}<span>
                @enderror
                </div>
                <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" value="{{ old('slug') }}" name="slug" class="form-control" id="slug" placeholder="Enter slug">
                @error('slug')
                    <span class="text-danger">{{ $message }}<span>
                @enderror
                </div>
                <div class="form-group">
                <label for="price">Price</label>
                <input type="number" value="{{ old('price') }}" name="price" class="form-control" id="price" placeholder="Enter Price">
                @error('price')
                    <span class="text-danger">{{ $message }}<span>
                @enderror
                </div>
                 <div class="form-group">
                <label for="qty">Qty</label>
                <input type="number" value="{{ old('qty') }}" name="qty" class="form-control" id="qty" placeholder="Enter qty">
                @error('qty')
                    <span class="text-danger">{{ $message }}<span>
                @enderror
                </div>
                <div class="form-group">
                <label for="image_url">Image</label>
                <input type="file" name="image_url" class="form-control" id="image_url">
                @error('image_url')
                    <span class="text-danger">{{ $message }}<span>
                @enderror
                </div>
                <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" id="description">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}<span>
                @enderror
                </div>
                <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" id="status">
                    <option value="">---Please Select---</option>
                    <option {{ old('status') == '1' ? 'selected' : '' }} value="1">Show</option>
                    <option {{ old('status') == '0' ? 'selected' : '' }} value="0">Hide</option>
                </select>
                @error('status')
                    <span class="text-danger">{{ $message }}<span>
                @enderror
                </div>
                <div class="form-group">
                <label for="product_category_id">Product Category</label>
                <select name="product_category_id" class="form-control" id="product_category_id">
                    <option value="">---Please Select---</option>
                    @foreach ($productCategories as $productCategory)
                        <option {{ old('product_category_id') == $productCategory->id ? 'selected' : '' }}
                             value="{{ $productCategory->id }}">{{ $productCategory->name }}</option>    
                    @endforeach
                </select>
                @error('status')
                    <span class="text-danger">{{ $message }}<span>
                @enderror
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                @csrf
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
            </form>
        </div>
        <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
  </div>
@endsection


@section('my-script')
<script type="text/javascript">
    $(document).ready(function(){
        $('#name').on('keyup', function(){
            var name = $(this).val();

            $.ajax({
                method: 'POST', //method of form
                url : "{{ route('admin.product_category.slug') }}", //action of form
                data: {
                    slug: name,
                    _token: '{{ csrf_token() }}'
                }, //input name
                success: function (res){
                    $('#slug').val(res.slug);
                }
            });
        });
        
    });
</script>
<script>
    ClassicEditor
        .create( document.querySelector( '#description' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection