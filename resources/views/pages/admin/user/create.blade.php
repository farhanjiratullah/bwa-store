@extends('layouts.admin')

@section('title', 'Store Admin Add User Dashboard')

@section('content')
    
<!-- Section Content -->
<div
class="section-content section-dashboard-home"
data-aos="fade-up"
>
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Admin Add User Dashboard</h2>
            <p class="dashboard-subtitle">Add New User</p>
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
                        <form action="{{ route('user.store') }}" method="post">
                          @csrf

                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Nama User</label>
                                <input type="text" class="form-control" name="name" required>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Email User</label>
                                <input type="email" class="form-control" name="email" required>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" required>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Nama User</label>
                                <select name="roles" required class="form-control">
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