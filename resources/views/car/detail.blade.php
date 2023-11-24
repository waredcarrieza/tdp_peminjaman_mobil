@extends('template.main')

<link href="{{ url('/assets/css/jquery.autocomplete.css') }}" rel="stylesheet">

@section('container')
<div class="container">
	<div class="row mb-2">
		<div class="col-md-12 mt-2">
			<h5>Detail Car</h5>

			<a href="{{ url('/car') }}" class="btn btn-sm btn-primary">Back</a>
		</div><!-- /.col-md-4 -->
	</div><!-- /.row -->

	<div class="card mb-3">
		<div class="card-header text-bg-primary">Car Information</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Name</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control form-control-sm" id="inputcarName" name="inputcarName" readonly="" value="{!! $dbrow['car_title'] !!}">
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Plate No.</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control form-control-sm " id="inputCarNo" name="inputCarNo" readonly="" value="{!! $dbrow['car_no'] !!}">
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Rent Price</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control form-control-sm" id="inputCarRentPrice" name="inputCarRentPrice" readonly="" value="{!! $dbrow['car_rent_price'] !!}">
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Available</label>
					    <div class="col-sm-4">
					    	<input type="text" class="form-control form-control-sm " id="is_available" name="is_available" readonly="" value="{!! $dbrow['is_available'] !!}">
					    </div>
					</div>
				</div><!-- /.col-md-6 -->

				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputcarEmail" class="col-sm-3 col-form-label">Brand</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control form-control-sm" id="inputCarBrand" name="inputCarBrand" readonly="" value="{!! $dbrow['car_brand'] !!}">
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarPhone" class="col-sm-3 col-form-label">Model</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control form-control-sm" id="inputCarModel" name="inputCarModel" readonly="" value="{!! $dbrow['car_model'] !!}">
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