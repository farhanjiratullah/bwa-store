@extends('layouts.admin')

@section('title', 'Store Admin Edit User Dashboard')

@section('content')
    
<!-- Section Content -->
<div
class="section-content section-dashboard-home"
data-aos="fade-up"
>
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Admin Edit User Dashboard</h2>
            <p class="dashboard-subtitle">Edit User</p>
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
                        <form action="{{ route('user.update', $item->id) }}" method="post">
                          @method('PUT')
                          @csrf

                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Nama User</label>
                                <input type="text" class="form-control" name="name" required value="{{ $item->name }}">
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Email User</label>
                                <input type="email" class="form-control" name="email" required value="{{ $item->email }}">
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                                <small>Kosongkan jika tidak ingin mengganti password</small>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Nama User</label>
                                <select name="roles" required class="form-control">
                                  <option value="{{ $item->roles }}" selected>Tidak diganti</option>
                                  <option value="ADMIN">Admin</option>
                                  <option value="USER">User</option>
                                </select>
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