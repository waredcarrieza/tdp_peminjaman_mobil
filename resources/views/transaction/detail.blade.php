@extends('template.main')

@section('container')
<div class="container">
	<div class="row mb-2">
		<div class="col-md-4 mt-2">
			<h5>Transaction Detail</h5>

			<a href="{{ url('/transaction') }}" class="btn btn-sm btn-primary">Back</a>
			<a href="{{ url('/transaction/create') }}" class="btn btn-sm btn-primary">New</a>
			@if($dbrow['total_payment'] == 0.00)
				<a href="{{ url('/transaction/edit/' . $dbrow['id']) }}" class="btn btn-sm btn-outline-primary text-primary">Edit</a>
			@endif
		</div><!-- /.col-md-1 -->
	</div><!-- /.row -->

	<div class="row">
		<div class="col-md-6">
			<div class="mb-1 row">
			    <label class="col-sm-3 col-form-label" style="font-size: 13px;">Transaction Date</label>
			    <div class="col-sm-8">
			      <p class="form-control-plaintext" style="font-size: 13px;"><strong>{{ convertDateTime($dbrow['transaction_date'], 'd F Y H:i:s') }}</strong></p>
			    </div>
			</div>
		</div>
	</div>

	<div class="card mb-3">
		<div class="card-header text-bg-primary">Customer Information</div>
		<div class="card-body" style="font-size: 13px;">
			<div class="row">
				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputCustomerName" class="col-sm-3 col-form-label">Name</label>
					    <div class="col-sm-8">
					      <p class="form-control-plaintext"><strong class="text-primary">{{ $dbrow['customer_title'] }}</strong></p>
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputCustomerAddress" class="col-sm-3 col-form-label">Address</label>
					    <div class="col-sm-8">
					      <p class="form-control-plaintext">{!! $dbrow['customer_address'] !!}</p>
					    </div>
					</div>
				</div><!-- /.col-md-6 -->

				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputCustomerEmail" class="col-sm-3 col-form-label">Email</label>
					    <div class="col-sm-8">
					      <p class="form-control-plaintext"><a href="mailto:{{ $dbrow['customer_email'] }}?subject=Hi">{{ $dbrow['customer_email'] }}</a></p>
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputCustomerPhone" class="col-sm-3 col-form-label">Phone</label>
					    <div class="col-sm-8">
					      <p class="form-control-plaintext">{{ $dbrow['customer_phone_no'] }}</p>
					    </div>
					</div>
				</div><!-- /.col-md-6 -->
			</div><!-- /.row -->
		</div><!-- /.card-body -->
	</div><!-- /.card -->

	<div class="card">
		<div class="card-header text-bg-secondary">Item Transaction</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<table class="table" id="detail_item" style="font-size: 13px;">
						<thead>
							<tr class="table-primary">
								<th>#</th>
								<th>Item</th>
								<th>Unit Price</th>
								<th width="10%">Qty</th>
								<th>Discount</th>
								<th>Total Price</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$start = 0;
						if(count($details) > 0):
							foreach($details as $row):
								$start++;

								echo '
								<tr>
									<td>'. $start .'</td>
									<td>'. $row->product_title .'</td>
									<td class="text-end">Rp '. currencyFormat($row->price, 2) .'</td>
									<td class="text-end">'. currencyFormat($row->qty) .'</td>
									<td class="text-end">Rp '. currencyFormat($row->discount, 2) .'</td>
									<td class="text-end">Rp '. currencyFormat($row->subtotal, 2) .'</td>
								</tr>
								';
							endforeach;
						endif;
						?>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="5" class="text-end">Sub Total :</th>
								<th class="text-end">Rp {{ currencyFormat($dbrow['total_subtotal'], 2) }}</th>
							</tr>
							<tr>
								<th colspan="5" class="text-end">Freight :</th>
								<th class="text-end">Rp {{ currencyFormat($dbrow['total_freight'], 2) }}</th>
							</tr>
							<tr>
								<th colspan="5" class="text-end">Grand Total :</th>
								<th class="text-end">Rp {{ currencyFormat($dbrow['grand_total'], 2) }}</th>
							</tr>
							<tr class="table-secondary">
								<th colspan="6"></th>
							</tr>
							<tr>
								<th colspan="5" class="text-end">Paid :</th>
								<th class="text-end">Rp {{ currencyFormat($dbrow['total_payment'], 2) }}</th>
							</tr>
							<tr>
								<th colspan="5" class="text-end">Change Due :</th>
								<th class="text-end">Rp {{ currencyFormat($dbrow['total_change_due'], 2) }}</th>
							</tr>
						</tfoot>
					</table>
				</div><!-- /.col-md-12 -->
			</div><!-- /.row -->
		</div><!-- /.card-body -->
	</div><!-- /.card -->

</div><!-- /.container -->
@endsection

@section('jsmain')
<script>
$(function(){

});
</script>
@endsection