@extends('layouts.admin')

@section('title', 'Store Admin Add Product Gallery Dashboard')

@section('content')
    
<!-- Section Content -->
<div
class="section-content section-dashboard-home"
data-aos="fade-up"
>
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Admin Add Product Gallery Dashboard</h2>
            <p class="dashboard-subtitle">Add New Product Gallery</p>
        </div>
        <div class="dashboard-content">
            {{-- List of Categories --}}
            <div class="row">
                <div class="col-md-12">
                  @if ($errors->any())
                      <div class="alert alert-danger">
                        <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                        </ul>
                      </div>
                  @endif

                  <div class="card">
                      <div class="card-body">
                        <form action="{{ route('product-gallery.store') }}" method="post" enctype="multipart/form-data">
                          @csrf

                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Pemilik Product</label>
                                <select name="products_id" class="form-control">
                                  @foreach ($products as $product)
                                      <option value="{{ $product->id }}">{{ $product->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Foto Product</label>
                                <input type="file" class="form-control" name="photos" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col text-right">
                              <button class="btn btn-success px-5" type="submit">Save Now</button>
                            </div>
                          </div>
                        </form>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection