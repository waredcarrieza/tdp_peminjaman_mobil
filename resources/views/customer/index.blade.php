@extends('template.main')

@section('container')
<div class="container">
	<div class="row mb-2">
		<div class="col-md-4 mt-2">
			<h5>Customer List</h5>

			<a href="{{ url('/customer/create') }}" class="btn btn-sm btn-primary">New</a>
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
						<th>Address</th>
						<th>Phone No.</th>
						<th>Driver License No.</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$start = 0;

				if(count($dataTables) > 0):
					foreach($dataTables as $row):
						$start++;

						echo '
						<tr>
							<td class="text-center">
								<div class="btn-group dropend">
									<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="fas fa-cogs"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-dark" style="font-size: 13px;">
										<li><a class="dropdown-item disabled">'. $row->customer_title .'</a></li>
										<li><a href="'. url('/customer/detail/' . $row->id) .'" class="dropdown-item">Detail</a></li>
										<li><a href="'. url('/customer/edit/' . $row->id) .'" class="dropdown-item">Edit</a></li>
    									<li><hr class="dropdown-divider"></li>
										<li><a data-url="'. url('/customer/delete/') .'" data-id="'. $row->id .'" data-name="'. $row->customer_title .'" class="dropdown-item text-danger btnRemoveTrans">Delete</a></li>
									</ul>
								</div>
							</td>
							<td class="text-end">'. $start .'</td>
							<td>'. convertDateTime($row->created_at, 'd-m-y H:i') . ($row->updated_at != "" ? '<br />(updated '. convertDateTime($row->updated_at, 'd-m-y H:i') .')' : '') .'</td>
							<td><strong>'. $row->customer_title .'</strong></td>
							<td>'. $row->customer_address .'</td>
							<td>'. $row->customer_phone_no .'</td>
							<td>'. $row->customer_license_no .'</td>
						</tr>
						';
					endforeach;
				endif;
				?>
				</tbody>
				<tfoot>
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