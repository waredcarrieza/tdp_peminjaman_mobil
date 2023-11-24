@extends('template.main')

@section('container')
<div class="container">
	<div class="row mb-2">
		<div class="col-md-4 mt-2">
			<h5>Transaction List</h5>

			<a href="{{ url('/transaction/create') }}" class="btn btn-sm btn-primary">New</a>
		</div><!-- /.col-md-1 -->
	</div><!-- /.row -->

	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
			<table class="table table-bordered table-striped" style="font-size: 13px;">
				<thead>
					<tr class="table-primary">
						<th>ACTION</th>
						<th>#</th>
						<th>Date</th>
						<th>Customer</th>
						<th>Total Qty</th>
						<th>Total Price</th>
						<th>Total Disc.</th>
						<th>Total Subtotal</th>
						<th>Total Freight</th>
						<th>Total Transaction</th>
						<th>Paid</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$start = 0;
				$total_qty = 0;
				$total_price = 0.00;
				$total_disc = 0.00;
				$total_subtotal = 0.00;
				$total_freight = 0.00;
				$total_transaction = 0.00;
				$total_paid = 0.00;
				if(count($dataTables) > 0):
					foreach($dataTables as $row):
						$start++;
						$total_qty += $row->total_qty;
						$total_price += $row->total_price;
						$total_disc += $row->total_discount;
						$total_subtotal += $row->total_subtotal;
						$total_freight += $row->total_freight;
						$total_transaction += $row->grand_total;
						$total_paid += $row->total_payment;

						echo '
						<tr>
							<td class="text-center">
								<div class="btn-group dropend">
									<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="fas fa-cogs"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-dark" style="font-size: 13px;">
										<li><a class="dropdown-item disabled">'. $row->customer_title . ' ' . convertDateTime($row->transaction_date, 'd-m-y H:i') .'</a></li>
										<li><a href="'. url('/transaction/detail/' . $row->id) .'" class="dropdown-item">Detail</a></li>
										'. ($row->total_payment == 0.00 || $row->total_payment < $row->grand_total ? '<li><a href="'. url('/transaction/edit/' . $row->id) .'" class="dropdown-item">Edit</a></li>' : '') .'
    									<li><hr class="dropdown-divider"></li>
										<li><a data-url="'. url('/transaction/delete/') .'" data-id="'. $row->id .'" data-name="'. $row->customer_title . ' ' . convertDateTime($row->transaction_date, 'd-m-y H:i') .'" class="dropdown-item text-danger btnRemoveTrans">Delete</a></li>
									</ul>
								</div>
							</td>
							<td class="text-end">'. $start .'</td>
							<td>'. convertDateTime($row->transaction_date, 'd-m-y H:i') .'</td>
							<td><strong>'. $row->customer_title .'</strong></td>
							<td class="text-end">'. currencyFormat($row->total_qty) .'</td>
							<td class="text-end">Rp '. currencyFormat($row->total_price, 2) .'</td>
							<td class="text-end">Rp '. currencyFormat($row->total_discount, 2) .'</td>
							<td class="text-end">Rp '. currencyFormat($row->total_subtotal, 2) .'</td>
							<td class="text-end">Rp '. currencyFormat($row->total_freight, 2) .'</td>
							<td class="text-end">Rp '. currencyFormat($row->grand_total, 2) .'</td>
							<td class="text-end">Rp '. currencyFormat($row->total_payment, 2) .'</td>
						</tr>
						';
					endforeach;
				endif;
				?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="4">Summary from {{ $start }} Transactions</th>
						<th class="text-end">{{ currencyFormat($total_qty) }}</th>
						<th class="text-end">Rp {{ currencyFormat($total_price, 2) }}</th>
						<th class="text-end">Rp {{ currencyFormat($total_disc, 2) }}</th>
						<th class="text-end">Rp {{ currencyFormat($total_subtotal, 2) }}</th>
						<th class="text-end">Rp {{ currencyFormat($total_freight, 2) }}</th>
						<th class="text-end">Rp {{ currencyFormat($total_transaction, 2) }}</th>
						<th class="text-end">Rp {{ currencyFormat($total_paid, 2) }}</th>
					</tr>
				</tfoot>
			</table>
			</div>
		</div>
	</div>
</div><!-- /.container -->
@endsection

@section('jsmain')
<script>
$(function(){
	$(document).on("click", ".btnRemoveTrans", function(){
        var id = $(this).data("id");
        var dataname = $(this).data("name");
        var goURL = $(this).data("url");

        $.alerts.okButton = '&nbsp;Ya&nbsp;';
        $.alerts.cancelButton = '&nbsp;Tidak&nbsp;';
        jConfirm('Hapus data <br /><strong class="text-bold">'+dataname+'</strong> ?','Konfirmasi!',function(r){
            if(r){
            	$.blockUI({ 
	                message: $('<img src="/assets/images/loader/dot-loading-spinner-2.gif" align="absmiddle" style="width: 70px;">'),
	                css: {
	                    border: 'none',
	                    padding: '2px',
	                    backgroundColor: 'none'
	                },
	                overlayCSS: {
	                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
	                    opacity: 1,
	                    cursor: 'wait'
	                }
	            });
                window.location = goURL+'/'+id;
            }else{
                return false;
            }
        });

        $("#popup_content").addClass("prompt-action");
        $("#popup_message").css("padding-left", "70px");
    });
});
</script>
@endsection