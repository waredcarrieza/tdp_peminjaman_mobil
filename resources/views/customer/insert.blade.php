@extends('template.main')

<link href="{{ url('/assets/css/jquery.autocomplete.css') }}" rel="stylesheet">

@section('container')
<div class="container">
	<div class="row mb-2">
		<div class="col-md-12 mt-2">
			<h5>Add New Customer</h5>

			<a href="{{ url('/customer') }}" class="btn btn-sm btn-primary">Back</a>
		</div><!-- /.col-md-4 -->
	</div><!-- /.row -->

	<form method="post" action="{{ url('/customer/insert') }}">
	@csrf

	<div class="card mb-3">
		<div class="card-header text-bg-primary">Customer Information</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputCustomerName" class="col-sm-3 col-form-label">Name</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control form-control-sm customer_name" id="inputCustomerName" name="inputCustomerName" value="Customer {{ date('ymdhis') }}">
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputCustomerAddress" class="col-sm-3 col-form-label">Address</label>
					    <div class="col-sm-8">
					      <textarea class="form-control form-control-sm" id="inputCustomerAddress" name="inputCustomerAddress"></textarea>
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputCustomerName" class="col-sm-3 col-form-label">Driver License No.</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control form-control-sm customer_name" id="inputCustomerLicenseNo" name="inputCustomerLicenseNo" value="">
					    </div>
					</div>
				</div><!-- /.col-md-6 -->

				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputCustomerEmail" class="col-sm-3 col-form-label">Email</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control form-control-sm" id="inputCustomerEmail" name="inputCustomerEmail" value="customer.{{ date('ymdhis') }}@gmail.com">
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputCustomerPhone" class="col-sm-3 col-form-label">Phone</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control form-control-sm" id="inputCustomerPhone" name="inputCustomerPhone" value="081180081180">
					    </div>
					</div>
				</div><!-- /.col-md-6 -->
			</div><!-- /.row -->
		</div><!-- /.card-body -->
	</div><!-- /.card -->

	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-12 text-end">
					<input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
					<button type="submit" class="btn btn-sm btn-primary">Save</button>
					<button type="reset" class="btn btn-sm btn-warning">Reset</button>
				</div><!-- /.col-md-12 -->
			</div><!-- /.row -->
		</div><!-- /.card-body -->
	</div><!-- /.card -->
	
	</form>

</div><!-- /.container -->
@endsection

@section('jsmain')
@endsection