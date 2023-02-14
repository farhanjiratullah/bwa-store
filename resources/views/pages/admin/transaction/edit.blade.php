@extends('layouts.admin')

@section('title', 'Store Admin Edit Transaction Dashboard')

@section('content')
    
<!-- Section Content -->
<div
class="section-content section-dashboard-home"
data-aos="fade-up"
>
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Admin Edit Transaction Dashboard</h2>
            <p class="dashboard-subtitle">Edit Transaction</p>
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
                        <form action="{{ route('transaction.update', $item->id) }}" method="post">
                          @method('PUT')
                          @csrf

                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Transaction Status</label>
                                <select name="transaction_status" class="form-control">
                                  <option value="{{ $item->transaction_status }}" selected>{{ $item->transaction_status }}</option>
                                  <option value="" disabled>----------</option>
                                  <option value="PENDING">PENDING</option>
                                  <option value="SHIPPING">SHIPPING</option>
                                  <option value="SUCCESS">SUCCESS</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Total Price</label>
                                <input type="number" class="form-control" name="total_price" value="{{ $item->total_price }}" required>
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