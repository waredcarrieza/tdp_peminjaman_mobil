@extends('template.main')

<link href="{{ url('/assets/css/jquery.autocomplete.css') }}" rel="stylesheet">

@section('container')
<div class="container">
	<div class="row mb-2">
		<div class="col-md-12 mt-2">
			<h5>Add New Transaction</h5>

			<a href="{{ url('/transaction') }}" class="btn btn-sm btn-primary">Back</a>
		</div><!-- /.col-md-4 -->
	</div><!-- /.row -->

	<form method="post" action="{{ url('/transaction/insert') }}">
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
					      <input type="hidden" class="" id="inputCustomerId" name="inputCustomerId" value="">
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputCustomerAddress" class="col-sm-3 col-form-label">Address</label>
					    <div class="col-sm-8">
					      <textarea class="form-control form-control-sm" id="inputCustomerAddress" name="inputCustomerAddress">JL. ABC No.1, Kota Bandung, Jawa Barat, Indonesia</textarea>
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
		<div class="card-header text-bg-secondary">Item Transaction</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<table class="table" id="detail_item" style="font-size: 13px;">
						<thead>
							<tr class="table-primary">
								<th></th>
								<th>#</th>
								<th>Item</th>
								<th>Unit Price</th>
								<th width="10%">Qty</th>
								<th>Discount</th>
								<th>Total Price</th>
							</tr>
							<tr>
								<th colspan="7">
									<button type="button" class="btn btn-outline-primary text-primary btn-sm" id="addNewRow" svn="2">Add New Row</button>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr id="row_1">
								<td><a role="button" class="btn btn-sm btn-outline-danger text-danger removeItem removeItem_1" data-id="" data-calcid="1" data-subtotal=""><i class="fas fa-times"></i> </a></td>
								<td>1</td>
								<td><input type="text" class="form-control form-control-sm name name_1" name="item_name[]" id="item_name_1" svn="1">
									<input type="hidden" name="item_id[]" id="item_id_1"></td>
								<td><input type="text" class="form-control form-control-sm text-end price calc" name="item_price[]" id="item_price_1" svn="1"></td>
								<td><input type="text" class="form-control form-control-sm text-end qty calc" name="item_qty[]" id="item_qty_1" svn="1"></td>
								<td><input type="text" class="form-control form-control-sm text-end disc calc" name="item_discount[]" id="item_discount_1" svn="1"></td>
								<td><input type="text" class="form-control form-control-sm text-end _total calc" name="item_subtotal[]" id="item_subtotal_1" svn="1" readonly=""></td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th class="text-end" colspan="6">Sub Total :</th>
								<th><input type="text" class="form-control form-control-sm text-end _subtotal calc" name="total_subtotal" id="total_subtotal" readonly=""></th>
							</tr>
							<tr>
								<th class="text-end" colspan="6">Freight :</th>
								<th><input type="text" class="form-control form-control-sm text-end _freight calc" name="total_freight" id="total_freight" value="0"></th>
							</tr>
							<tr>
								<th class="text-end" colspan="6">Grand Total :</th>
								<th><input type="text" class="form-control form-control-sm text-end _grand_total calc" name="grand_total" id="grand_total" readonly="" style="font-weight: bold;"></th>
							</tr>
							<tr class="table-secondary">
								<th colspan="7"></th>
							</tr>
							<tr>
								<th class="text-end" colspan="6">Paid :</th>
								<th><input type="text" class="form-control form-control-sm text-end paid calc" name="total_paid" id="total_paid" value="0" autocomplete="off"></th>
							</tr>
							<tr>
								<th class="text-end" colspan="6">Change Due :</th>
								<th><input type="text" class="form-control form-control-sm text-end change_due calc" name="change_due" id="change_due" value="0" readonly=""></th>
							</tr>
						</tfoot>
					</table>
				</div><!-- /.col-md-12 -->
			</div><!-- /.row -->

			<div class="row">
				<div class="col-md-12 text-end">
					<input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
					<button type="submit" class="btn btn-sm btn-primary">Save</button>
					<button type="reset" class="btn btn-sm btn-warning">Reset</button>
				</div><!-- /.col-md-12 -->
			</div><!-- /.row -->
		</div><!-- /.card-body -->
	</div><!-- /.card -->

	<p style="font-size: 12px; font-style: italic;">Silahkan coba dengan memasukan kata gula atau tepung atau segitiga</p>
	
	</form>

</div><!-- /.container -->
@endsection

@section('jsmain')
<script src="{{ url('/assets/js/jquery.autocomplete.js') }}"></script>
<script type="text/javascript" src="{{ url('/assets/js/jquery.calculation.js') }}"></script>
<SCRIPT LANGUAGE="JavaScript">
$.fn.ForceNumericOnly =
	function(){
		return this.each(function(){
			jQuery(this).keydown(function(e){
				var key = e.charCode || e.keyCode || 0;
				// allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
				return (key == 8 || key == 9 ||	key == 46 || (key >= 37 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
			})
		})
	};
</script>
<script>
$(function(){
	$('input').keypress(function (e) {
		var code = null;
		code = (e.keyCode ? e.keyCode : e.which);
		return (code == 13) ? false : true;
	});

	$(document).on("click", "#addNewRow", function(){
		var num = $(this).attr("svn");
		$('#detail_item').find('tbody').append(
			'<tr id="row_'+num+'">'+
				'<td><a role="button" class="btn btn-sm btn-outline-danger text-danger removeItem removeItem_'+num+'" data-id="" data-calcid="'+num+'" data-subtotal=""><i class="fas fa-times"></i> </a></td>'+
				'<td>'+num+'</td>'+
				'<td>\
					<input type="text" class="form-control form-control-sm name name_'+num+'" name="item_name[]" id="item_name_'+num+'" svn="'+num+'">\
					<input type="hidden" name="item_id[]" id="item_id_'+num+'">'+
					'<input type="hidden" name="detail_id[]" id="detail_id_'+num+'" value=""></td>'+
				'<td><input type="text" class="form-control form-control-sm text-end price calc" name="item_price[]" id="item_price_'+num+'" svn="'+num+'"></td>'+
				'<td><input type="text" class="form-control form-control-sm text-end qty calc" name="item_qty[]" id="item_qty_'+num+'" svn="'+num+'"></td>'+
				'<td><input type="text" class="form-control form-control-sm text-end disc calc" name="item_discount[]" id="item_discount_'+num+'" svn="'+num+'"></td>'+
				'<td><input type="text" class="form-control form-control-sm text-end _total calc" name="item_subtotal[]" id="item_subtotal_'+num+'" svn="'+num+'" readonly=""></td>'+
			'</tr>'
		);
		var next_id = (parseInt(num) + 1);
		$("#addNewRow").attr("svn", next_id);
	});

	$(".customer_name").keyup(function(){
		var long = $(this).val();
		if(long == ''){
			$("#inputCustomerId").val('');
			$("#inputCustomerAddress").val('');
			$("#inputCustomerEmail").val('');
			$("#inputCustomerPhone").val('');
		}
	});

	var _csrftoken1 = $("#csrf_token").val();
	$(".customer_name").autocomplete("{{ url('/transaction/getcustomers?csrftoken=') }}"+_csrftoken1, {
		width: 280,
		multiple: false,
		matchContains: true,
	});

	$('.customer_name').result(function(event, data, formatted) {
		var id = $(this).attr('svn');
		if(data){
			$("#inputCustomerName").val(data[0]);
			$("#inputCustomerId").val(data[1]);
			$("#inputCustomerAddress").val(data[2]);
			$("#inputCustomerEmail").val(data[3]);
			$("#inputCustomerPhone").val(data[4]);
		}else{
			$("#inputCustomerName").val('');
			$("#inputCustomerId").val('');
			$("#inputCustomerAddress").val('');
			$("#inputCustomerEmail").val('');
			$("#inputCustomerPhone").val('');
		}
	});

	$(".name").keyup(function(){
		var long = $(this).val();
		var id = $(this).attr('svn');
		if(long == ''){
			$(".name_"+id).val('');
			$("#item_id_"+id).val('');
			$("#item_price_"+id).val(0);
			$("#item_qty_"+id).val(0);
			$("#item_discount_"+id).val(0);
			$("#item_total_"+id).val(0);
		}
	});

	var _csrftoken = $("#csrf_token").val();
	$(".name").autocomplete("{{ url('/transaction/getproducts?csrftoken=') }}"+_csrftoken, {
		width: 280,
		multiple: false,
		matchContains: true,
	});

	$('.name').result(function(event, data, formatted) {
		var id = $(this).attr('svn');
		var next_id = (parseInt(id) + 1);
		if(data){
			$(".name_"+id).val(data[0]);
			$("#item_id_"+id).val(data[1]);
			$("#item_price_"+id).val(data[2]);
			$("#item_discount_"+id).val(0);
		}else{
			$(".name_"+id).val('');
			$("#item_id_"+id).val('');
			$("#item_price_"+id).val(0);
			$("#item_discount_"+id).val(0);
		}
	});

	$(document).on("keyup", ".name", function(){
		var _csrftoken = $("#csrf_token").val();
		$(this).autocomplete("{{ url('/transaction/getproducts?csrftoken=') }}"+_csrftoken, {
			width: 280,
			multiple: false,
			matchContains: true,
		});

		$(this).result(function(event, data, formatted) {
			var id = $(this).attr('svn');
			var next_id = (parseInt(id) + 1);
			if(data){
				$(".name_"+id).val(data[0]);
				$("#item_id_"+id).val(data[1]);
				$("#item_price_"+id).val(data[2]);
				$("#item_discount_"+id).val(0);
			}else{
				$(".name_"+id).val('');
				$("#item_id_"+id).val('');
				$("#item_price_"+id).val(0);
				$("#item_discount_"+id).val(0);
			}
		});
	});

	$('.calc').focus(function(){
		if($(this).val() == '0'){
			$(this).val('');
		}
	}).blur(function(){
		if($(this).val() == ''){
			$(this).val(0);
		}						  
	});

	$(document).on("keyup", ".calc", function(){
		var id = $(this).attr('svn');		   
		recalc(id);
	});

	function recalc(id){
		$("#item_subtotal_"+id).calc(
			"(price-discount) * qty",{
				price: $("#item_price_"+id),
				discount: $("#item_discount_"+id),
				qty: $("#item_qty_"+id),
			},
			function (s){
				return s.toFixed(2);
			},
			function ($this){
				var sum 		= $this.sum();
				var sum_total 	= $('._total').sum();
				
				$('#item_subtotal_'+id).val(sum);
				$(".removeItem_"+id).attr("data-subtotal", sum);

				$("#total_subtotal").val(sum_total);

				var freight = $("._freight").val();

				var grand_total = sum_total + parseFloat(freight);
				$("#grand_total").val(grand_total);

				var paid = $("#total_paid").val();

				var change_due = parseFloat(paid) - grand_total;
				$("#change_due").val(change_due);
			}
		);
	}

	$(document).on("click", ".removeItem", function(){
        var id = $(this).data("id");
        var subtotal = $(this).attr("data-subtotal");
        var calcid = $(this).attr("data-calcid");
        var total_subtotal = $("#total_subtotal").val();

        $.alerts.okButton = '&nbsp;Ya&nbsp;';
        $.alerts.cancelButton = '&nbsp;Tidak&nbsp;';
        jConfirm('Hapus baris item ini ?','Konfirmasi!',function(r){
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
	            $.unblockUI();
                $("#row_"+calcid).remove();

                var sum_total = parseFloat(total_subtotal) - parseFloat(subtotal);

                $("#total_subtotal").val(sum_total);

				var freight = $("._freight").val();

				var grand_total = sum_total + parseFloat(freight);
				$("#grand_total").val(grand_total);

				var paid = $("#total_paid").val();

				var change_due = parseFloat(paid) - grand_total;
				$("#change_due").val(change_due);

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