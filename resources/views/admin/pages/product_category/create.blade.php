@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Product Category Form</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Product Category Form</li>
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
            <h3 class="card-title">Product Category</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ route('admin.product_category.store') }}">
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