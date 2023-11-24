@extends('template.main')

<link href="{{ url('/assets/css/jquery.autocomplete.css') }}" rel="stylesheet">

@section('container')
<div class="container">
	<div class="row mb-2">
		<div class="col-md-12 mt-2">
			<h5>Edit Car</h5>

			<a href="{{ url('/car') }}" class="btn btn-sm btn-primary">Back</a>
		</div><!-- /.col-md-4 -->
	</div><!-- /.row -->

	<form method="post" action="{{ url('/car/update') }}">
	@csrf

	<div class="card mb-3">
		<div class="card-header text-bg-primary">car Information</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Name</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control form-control-sm" id="inputcarName" name="inputcarName" value="{!! $dbrow['car_title'] !!}">
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Plate No.</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control form-control-sm " id="inputCarNo" name="inputCarNo" value="{!! $dbrow['car_no'] !!}">
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Rent Price</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control form-control-sm" id="inputCarRentPrice" name="inputCarRentPrice" value="{!! $dbrow['car_rent_price'] !!}">
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Available</label>
					    <div class="col-sm-4">
					      <select name="is_available" id="is_available" class="form-select form-select-sm ft-13" required>
				            <option value="yes" {!! ($dbrow['is_available'] == "yes" ? 'selected=""' : '') !!}>Yes</option>
				            <option value="no" {!! ($dbrow['is_available'] == "no" ? 'selected=""' : '') !!}>No</option>
				          </select>
				          @error('is_available')
				            <div class="alert alert-danger">{{ $message }}</div>
				          @enderror
					    </div>
					</div>
				</div><!-- /.col-md-6 -->

				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputcarEmail" class="col-sm-3 col-form-label">Brand</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control form-control-sm" id="inputCarBrand" name="inputCarBrand" value="{!! $dbrow['car_brand'] !!}">
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarPhone" class="col-sm-3 col-form-label">Model</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control form-control-sm" id="inputCarModel" name="inputCarModel" value="{!! $dbrow['car_model'] !!}">
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
					<input type="hidden" id="inputId" name="inputId" value="{!! $dbrow['id'] !!}">
					<button type="submit" class="btn btn-sm btn-primary">Apply Change</button>
				</div><!-- /.col-md-12 -->
			</div><!-- /.row -->
		</div><!-- /.card-body -->
	</div><!-- /.card -->
	
	</form>

</div><!-- /.container -->
@endsection

@section('jsmain')
@endsection