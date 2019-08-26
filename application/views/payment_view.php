<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Rayzorpay | CodeIgniter</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	#text_red{
		color: orangered;
		display: none;
	}
	#text_green{
		color: limegreen;
		display: none;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Razorpay with CodeIgniter</h1>

	<h1 id="text_red">Payment failed</h1>
	<h1 id="text_green">Payment successful</h1>

	<div id="body">
		<button type="button" id="frmRzpSbmBtn">Pay now</button>
	</div>
	<br>

</div>

<script src="<?php echo base_url('') ?>assets/jquery.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
	$(document).on('click', '#frmRzpSbmBtn', function () {
		event.preventDefault();

		var name = 'Nashir';
		var email = 'nashirk5@gmail.com';
		var mobile = '8553574795';
		var keyId = "<?php echo RAZORPAY_KEY_ID ?>";
		var keySecrete = "<?php echo RAZORPAY_KEY_SECRETE ?>";
		var rzpAmount = 100;

		var options = {
			"key": keyId,
			"amount": rzpAmount, // 2000 paise = INR 20
			"name": name,
			"description": "",
			"image": "",
			"handler": function (response){
				console.log(response.razorpay_payment_id);
				$('#frmRzpSbmBtn').attr('disabled', true);

				var params = {
					rzpAmount: rzpAmount,
					rzpPaymentId: response.razorpay_payment_id
				};

				$.ajax({
					type: 'post',
					dataType: "json",
					url: '<?php echo site_url('payment/capture_razorpay_payment') ?>',
					data: params,
					success: function (data) {
						console.log(data);
						$('#frmRzpSbmBtn').attr('disabled', false);
						if(data.status){
							$('#text_green').show();
							$('#text_red').hide();
						} else {
							$('#text_red').show();
							$('#text_green').hide();
						}
					}
				});
			},
			"prefill": {
				"name": name,
				"email": email,
				"contact": mobile
			},
			"notes": {
				"address": ""
			},
			"theme": {
				"color": "#533a8c"
			}
		};
		var rzp1 = new Razorpay(options);
		rzp1.open();
	});
</script>

</body>
</html>