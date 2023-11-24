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
			<h5>Edit Rent</h5>

			<a href="{{ url('/rent') }}" class="btn btn-sm btn-primary">Back</a>
		</div><!-- /.col-md-4 -->
	</div><!-- /.row -->

	<form method="post" action="{{ url('/rent/update') }}">
	@csrf

	<div class="card mb-3">
		<div class="card-header text-bg-primary">Customer Information</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Customer</label>
					    <div class="col-sm-8">
					      <select name="customer_id" id="customer_id" class="form-select form-select-sm ft-13" required>
				            <option value="" selected="">- Select Customer -</option>
				            @foreach($option_customers as $customers)
				              <option value="{{ $customers->id }}" {!! ($dbrow['customer_id'] == $customers->id ? 'selected' : '') !!}>{{ $customers->customer_title }}</option>
				            @endforeach
				          </select>
				          @error('is_available')
				            <div class="alert alert-danger">{{ $message }}</div>
				          @enderror
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
					    	<input type="text" name="start_date" id="start_date" class="form-control form-control-sm" placeholder="dd-mm-yyyy" value="{!! convertDateTime($dbrow['start_date'], 'd-m-Y') !!}" autocomplete="off" required="" style="width: 30%;" />
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">End Date</label>
					    <div class="col-sm-8">
					    	<input type="text" name="end_date" id="end_date" class="form-control form-control-sm" placeholder="dd-mm-yyyy" value="{!! convertDateTime($dbrow['end_date'], 'd-m-Y') !!}" autocomplete="off" required="" style="width: 30%;" />
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
					      <select name="car_id" id="car_id" class="form-select form-select-sm ft-13" required>
				            <option value="" selected="">- Select Car -</option>
				            @foreach($option_cars as $cars)
				              <option value="{{ $cars->id }}" data-price="{!! $cars->car_rent_price !!}" {!! ($dbrow['car_id'] == $cars->id ? 'selected' : '') !!}>{{ $cars->car_title }}</option>
				            @endforeach
				          </select>
				          @error('is_available')
				            <div class="alert alert-danger">{{ $message }}</div>
				          @enderror
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Available Status</label>
					    <div class="col-sm-3">
					    	<input type="text" name="available_status" id="available_status" class="form-control form-control-sm" placeholder="OK/NOT OK" readonly="" value="OK" autocomplete="off" required="" />
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
					    	<input type="text" name="date_of_return" id="date_of_return" class="form-control form-control-sm" placeholder="dd-mm-yyyy" value="{!! ($dbrow['return_date'] != '' ? convertDateTime($dbrow['return_date'], 'd-m-Y') : '') !!}" autocomplete="off" style="width: 30%;" />
					    	<p>Isi field ini jika mobil telah dikembalikan</p>
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Days No</label>
					    <div class="col-sm-3">
					    	<input type="text" name="days_no" id="days_no" class="form-control form-control-sm" placeholder="0" value="{!! $dbrow['range_days'] !!}" autocomplete="off" readonly="" required="" />
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Extends Day No</label>
					    <div class="col-sm-3">
					    	<input type="text" name="extends_day" id="extends_day" class="form-control form-control-sm" placeholder="0" value="{!! $dbrow['extends_day'] !!}" readonly="" autocomplete="off" required="" />
					    </div>
					</div>
				</div><!-- /.col-md-6 -->

				<div class="col-md-6">
					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Car Price</label>
					    <div class="col-sm-5">
					    	<input type="text" name="car_rent_price" id="car_rent_price" class="form-control form-control-sm" placeholder="0" value="{!! $dbrow['rent_price'] !!}" readonly="" autocomplete="off" required="" />
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Total Price</label>
					    <div class="col-sm-5">
					    	<input type="text" name="total_price" id="total_price" class="form-control form-control-sm" placeholder="0" value="{!! $dbrow['total_price'] !!}" readonly="" autocomplete="off" required="" />
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">DP Paid</label>
					    <div class="col-sm-5">
					    	<input type="text" name="dp_paid" id="dp_paid" class="form-control form-control-sm calc" placeholder="0" value="{!! $dbrow['booking_paid'] !!}" autocomplete="off" required="" />
					    </div>
					</div>

					<div class="mb-1 row">
					    <label for="inputcarName" class="col-sm-3 col-form-label">Grand Total</label>
					    <div class="col-sm-5">
					    	<input type="text" name="grand_total" id="grand_total" class="form-control form-control-sm" placeholder="0" value="{!! $dbrow['grand_total'] !!}" readonly="" autocomplete="off" required="" />
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
					<input type="hidden" name="inputId" id="inputId" class="" value="{!! $dbrow['id'] !!}" />
					<input type="hidden" name="lastCar" id="lastCar" class="" value="{!! $dbrow['car_id'] !!}" />
					<button type="submit" class="btn btn-sm btn-primary">Apply Change</button>
				</div><!-- /.col-md-12 -->
			</div><!-- /.row -->
		</div><!-- /.card-body -->
	</div><!-- /.card -->
	
	</form>

</div><!-- /.container -->
@endsection

@section('jsmain')
<!-- datepicker js -->
<script src="{{ url('/assets/bootstrap-datetimepicker/js/bootstrap-datepicker.min.js') }}"></script>

<!-- select2 Js -->
<script src="{{ url('/assets/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ url('/assets/js/jquery.blockUI.js?v=') }}<?php echo time(); ?>"></script>
<script src="{{ url('/assets/js/jquery.calculation.js') }}"></script>
<script src="{{ url('/assets/js/jquery.formatCurrency-1.4.0.js') }}"></script>

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

    $("#customer_id").select2({
      placeholder: '<?php echo AGK_LANG_ID_WORD_SELECT; ?>',
      allowClear:true,
    });

    $("#car_id").select2({
      placeholder: '<?php echo AGK_LANG_ID_WORD_SELECT; ?>',
      allowClear:true,
    });

    // $("#start_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
    // $("#end_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});

    $("#start_date").datepicker({
    	format: "dd-mm-yyyy",
	    todayBtn: "linked",
	    clearBtn: true,
	    language: "id",
	    autoclose: true,
	    todayHighlight: true
    });

    $("#end_date").datepicker({
    	format: "dd-mm-yyyy",
	    todayBtn: "linked",
	    clearBtn: true,
	    language: "id",
	    autoclose: true,
	    todayHighlight: true
    });

    $("#date_of_return").datepicker({
    	format: "dd-mm-yyyy",
	    todayBtn: "linked",
	    clearBtn: true,
	    language: "id",
	    autoclose: true,
	    todayHighlight: true
    });

    $(document).on("change", "#end_date", function(){
        var start_date = $("#start_date").val();
        var end_date = $(this).val();
        var _token = "{{ csrf_token() }}";
        if(start_date != '' && end_date != ''){
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
          $.post("{{ url('/rent/get_nums_between_date/') }}", {_token:_token, start_date:start_date, end_date:end_date}, function(data){
            $.unblockUI();
            if(data != "") {
                var total_days = 0;
                var datas = $.trim(data);
                datas = datas.split("|");
                // $("#jangka_waktu").val(datas[0]);
                // $("#jangka_waktu_bulan").val(datas[1]);
                // $("#jangka_waktu_hari").val(datas[2]);

                total_days = (parseInt(datas[0]) * 360) + (parseInt(datas[1]) * 30) + parseInt(datas[2]);
                total_days += 1;

                $("#days_no").val( total_days );
            }else{
              $("#days_no").val( 0 );
            }
            // calc_payment(); 
          })
        } else {
          $("#days_no").val( 0 );
        }
    });

    $(document).on("change", "#date_of_return", function(){
        var start_date = $("#end_date").val();
        var end_date = $(this).val();
        var days_no = $("#days_no").val();
        var carPrice = $("select#car_id option:selected").data("price");
        var dp_paid = $("#dp_paid").val();
        var _token = "{{ csrf_token() }}";
        if(start_date != '' && end_date != ''){
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
          $.post("{{ url('/rent/get_nums_between_date/') }}", {_token:_token, start_date:start_date, end_date:end_date}, function(data){
            $.unblockUI();
            if(data != "") {
            	var total_days = 0;
                var datas = $.trim(data);
                datas = datas.split("|");
                // $("#jangka_waktu").val(datas[0]);
                // $("#jangka_waktu_bulan").val(datas[1]);
                // $("#jangka_waktu_hari").val(datas[2]);

                total_days = (parseInt(datas[0]) * 360) + (parseInt(datas[1]) * 30) + parseInt(datas[2]);

                $("#extends_day").val( total_days );

                var total_price = ( parseFloat(days_no) * parseFloat(carPrice) ) + ( parseFloat(total_days) * parseFloat(carPrice) );
                var grand_total = total_price - parseFloat(dp_paid);

	          	$("#total_price").val( total_price );
	          	$("#grand_total").val( grand_total );
            }else{
              $("#extends_day").val( 0 );
            }
            // calc_payment(); 
          })
        } else {
          $("#extends_day").val( 0 );
        }
    });

    $(document).on("change", "#car_id", function(){
        //calc_payment();
        var val = $("select#car_id option:selected").val();
        var carPrice = $("select#car_id option:selected").data("price");
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var days_no = $("#days_no").val();
        var _token = "{{ csrf_token() }}";

        if(val != ''){
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
          $.post("{{ url('/rent/check_car_availability_by_date/') }}", {_token:_token, val:val,  start_date:start_date, end_date:end_date}, function(data){
            $.unblockUI();
            if(data != "") {
            	$("#available_status").val( data );
            }else{
              	$("#days_no").val( "NOT OK" );
            }
           })
          	
          	var total_price = parseFloat(days_no) * parseFloat(carPrice);

          	$("#car_rent_price").val( carPrice );
          	$("#total_price").val( total_price );
          	$("#grand_total").val( total_price );
        }else{
            $("#car_rent_price").val( 0 );
          	$("#total_price").val( 0 );
          	$("#grand_total").val( 0 );
        }
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
		recalc();
	});

	function recalc(){
		var total_price = $("#total_price").val();
		var dp_paid = $("#dp_paid").val();

		var grand_total = parseFloat(total_price) - parseFloat(dp_paid);

        $("#grand_total").val( grand_total );
	}

    // $( ".date-picker" ).datepicker( "option", "changeMonth", true );
    // $( ".date-picker" ).datepicker( "option", "changeYear", true );

    function clearFormatCurrency(num){
	    num = num.toString().replace(/\Rp|\./g,'');
	    num = num.toString().replace(/\,/g,'.');
	    return num;
	}

    // Format while typing & warn on decimals entered, 2 decimal places
  	$('.to-currency-format-popup').blur(function() {
	  	var dtarget = $(this).data("target");
    	$(this).formatCurrency({ 
		      symbol: 'Rp ',
		      colorize: true, 
		      negativeFormat: '-%s%n', 
		      roundToDecimalPlace: 2 ,
		      decimalSymbol: ',',
		      digitGroupSymbol: '.',
    	});
    	var num = $(this).val();
    	$("#"+dtarget).val(clearFormatCurrency(num));
  	})
  	.keyup(function(e) {
    	var e = window.event || e;
    	var keyUnicode = e.charCode || e.keyCode;
	  	var dtarget = $(this).data("target");
    	if (e !== undefined) {
      		switch (keyUnicode) {
		        case 16: break; // Shift
		        case 17: break; // Ctrl
		        case 18: break; // Alt
		        case 27: this.value = ''; break; // Esc: clear entry
		        case 35: break; // End
		        case 36: break; // Home
		        case 37: break; // cursor left
		        case 38: break; // cursor up
		        case 39: break; // cursor right
		        case 40: break; // cursor down
		        case 78: break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
		        case 110: break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
		        case 190: break; // .
		        default: $(this).formatCurrency({ 
		          symbol: 'Rp ',
		          colorize: true, 
		          negativeFormat: '-%s%n', 
		          roundToDecimalPlace: -1, 
		          eventOnDecimalsEntered: true ,
		          decimalSymbol: ',',
		          digitGroupSymbol: '.',
		        });
      		}
    	}
    	var num = $(this).val();
    	$("#"+dtarget).val(clearFormatCurrency(num));
  	})
  	.bind('decimalsEntered', function(e, cents) {
    	if (String(cents).length > 2) {
      		var errorMsg = 'Mohon tidak menginput angka desimal (0.' + cents + ')';
      		//$('#down_payment_help_block').html(errorMsg);
      		//log('Event on decimals entered: ' + errorMsg);
    	}
  	});
});
</script>
@endsection