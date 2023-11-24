@extends('template.main')

<link href="{{ url('/assets/css/jquery.autocomplete.css') }}" rel="stylesheet">

@section('container')
<div class="container">
	<div class="row mb-2">
		<div class="col-md-12 mt-2">
			<h5>Detail Customer</h5>

			<a href="{{ url('/customer') }}" class="btn btn-sm btn-primary">Back</a>
		</div><!-- /.col-md-4 -->
	</div><!-- /.row -->

	<div class="card mb-3">
		<div class="card-header text-bg-primary">Customer Information</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputCustomerName" class="col-sm-3 col-form-label">Name</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control-static form-control-sm customer_name" readonly="readonly" id="inputCustomerName" name="inputCustomerName" value="{!! $dbrow['customer_title'] !!}">
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputCustomerAddress" class="col-sm-3 col-form-label">Address</label>
					    <div class="col-sm-8">
					      <textarea class="form-control-static form-control-sm" readonly="readonly" id="inputCustomerAddress" name="inputCustomerAddress">{!! $dbrow['customer_address'] !!}</textarea>
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputCustomerName" class="col-sm-3 col-form-label">Driver License No.</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control-static form-control-sm customer_name" readonly="readonly" id="inputCustomerLicenseNo" name="inputCustomerLicenseNo" value="{!! $dbrow['customer_license_no'] !!}">
					    </div>
					</div>
				</div><!-- /.col-md-6 -->

				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputCustomerEmail" class="col-sm-3 col-form-label">Email</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control-static form-control-sm" readonly="readonly" id="inputCustomerEmail" name="inputCustomerEmail" value="{!! $dbrow['customer_email'] !!}">
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputCustomerPhone" class="col-sm-3 col-form-label">Phone</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control-static form-control-sm" readonly="readonly" id="inputCustomerPhone" name="inputCustomerPhone" value="{!! $dbrow['customer_phone_no'] !!}">
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputCustomerPhone" class="col-sm-3 col-form-label">Created At</label>
					    <div class="col-sm-8">
					      {!! convertDateTime($dbrow['created_at'], 'd-m-y H:i') !!}
					    </div>
					</div>
				</div><!-- /.col-md-6 -->
			</div><!-- /.row -->
		</div><!-- /.card-body -->
	</div><!-- /.card -->

</div><!-- /.container -->
@endsection

@section('jsmain')
@endsection