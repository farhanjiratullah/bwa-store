@extends('layouts.admin')

@section('title', 'Store Admin Edit Category Dashboard')

@section('content')
    
<!-- Section Content -->
<div
class="section-content section-dashboard-home"
data-aos="fade-up"
>
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Admin Edit Category Dashboard</h2>
            <p class="dashboard-subtitle">Edit Category</p>
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
                        <form action="{{ route('category.update', $item->id) }}" method="post" enctype="multipart/form-data">
                          @method('PUT')
                          @csrf

                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Nama Kategori</label>
                                <input type="text" class="form-control" name="name" value="{{ $item->name }}" required>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Foto</label>
                                <input type="file" class="form-control" name="photo">
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