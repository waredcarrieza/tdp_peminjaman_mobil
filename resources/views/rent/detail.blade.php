@extends('template.main')

<link href="{{ url('/assets/css/jquery.autocomplete.css') }}" rel="stylesheet">
<link href="{{ url('/assets/select2/css/select2.min.css') }}" rel="stylesheet">

<!-- Bootstrap datetimepicker css -->
<link rel="stylesheet" href="{{ url('/assets/bootstrap-datetimepicker/css/bootstrap-datepicker3.min.css') }}">

<style>
.datepicker>.datepicker-days {
    display: block;
}

ol.linenums {
    margin: 0 0 0 -8px;
}
</style>

@section('container')
<div class="container">
	<div class="row mb-2">
		<div class="col-md-12 mt-2">
			<h5>Detail Rent</h5>

			<a href="{{ url('/rent') }}" class="btn btn-sm btn-primary">Back</a>
		</div><!-- /.col-md-4 -->
	</div><!-- /.row -->

	<div class="card mb-3">
		<div class="card-header text-bg-primary">Customer Information</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Customer</label>
					    <div class="col-sm-8">
					      {!! $dbrow['customer_title'] !!}
					    </div>
					</div>
				</div><!-- /.col-md-6 -->

				<div class="col-md-6">
				</div><!-- /.col-md-6 -->
			</div><!-- /.row -->
		</div><!-- /.card-body -->
	</div><!-- /.card -->

	<div class="card mb-3">
		<div class="card-header text-bg-primary">Date Information</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Start Date</label>
					    <div class="col-sm-8">
					    	{!! $dbrow['start_date'] !!}
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">End Date</label>
					    <div class="col-sm-8">
					    	{!! $dbrow['end_date'] !!}
					    </div>
					</div>
				</div><!-- /.col-md-6 -->

				<div class="col-md-6">
				</div><!-- /.col-md-6 -->
			</div><!-- /.row -->
		</div><!-- /.card-body -->
	</div><!-- /.card -->

	<div class="card mb-3">
		<div class="card-header text-bg-primary">Car Information</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Car</label>
					    <div class="col-sm-8">
					      {!! $dbrow['car_title'] !!}
					    </div>
					</div>
				</div><!-- /.col-md-6 -->

				<div class="col-md-6">

				</div><!-- /.col-md-6 -->
			</div><!-- /.row -->
		</div><!-- /.card-body -->
	</div><!-- /.card -->

	<div class="card mb-3">
		<div class="card-header text-bg-primary">Rent Information</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Date of Return</label>
					    <div class="col-sm-8">
					    	{!! $dbrow['return_date'] !!}
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Days No</label>
					    <div class="col-sm-3">
					    	{!! $dbrow['range_days'] !!}
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Extends Day No</label>
					    <div class="col-sm-3">
					    	{!! $dbrow['extends_day'] !!}
					    </div>
					</div>
				</div><!-- /.col-md-6 -->

				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Car Price</label>
					    <div class="col-sm-5">
					    	{!! $dbrow['rent_price'] !!}
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Total Price</label>
					    <div class="col-sm-5">
					    	{!! $dbrow['total_price'] !!}
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">DP Paid</label>
					    <div class="col-sm-5">
					    	{!! $dbrow['booking_paid'] !!}
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Grand Total</label>
					    <div class="col-sm-5">
					    	{!! $dbrow['grand_total'] !!}
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