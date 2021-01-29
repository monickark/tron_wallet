<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Document</title>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="index.css">
    </head>
	
    <body class="container">
	<h3>SEND TRX USING JS THROUGH TRONWALLET </h3>
    <button onclick="gettronweb()">Connect to wallet...</button> <br/>
	<div class='conn-address'> <h6></h6> </div>
	<div class='alert alert-success conn-success' role='alert'>  </div>
	<div class='alert alert-danger conn-error' role='alert'>  </div>
	<h4>TRANSACTION DETAILS</h4>
	<div class="form-group row col-lg-12">
	<input class="col-lg-7 form-control" id="addr" type="text" placeholder="Address"/>
	<input class="col-lg-3 form-control" id="amt" type="text" placeholder="TRX to transfer"/>
	<button class="col-lg-2 btn btn-dark" onclick="pay()">Transfer</button>
	<div class='col-lg-12 alert alert-success pay-success' role='alert'>  </div>
	<div class='col-lg-12 alert alert-danger pay-error' role='alert'>  </div></div> 
    <script>
	$(".conn-success").hide(); $(".conn-error").hide();	
	$(".pay-success").hide(); $(".pay-error").hide();
        function gettronweb(){
            if(window.tronWeb && window.tronWeb.defaultAddress.base58){                
                console.log("ADDRESS: ",window.tronWeb.defaultAddress.base58)
				$(".conn-address h6").text("Wallet address: " + window.tronWeb.defaultAddress.base58);
				$(".conn-success").text("Successfully connected to wallet.");
				$(".conn-success").show(); $(".conn-error").hide();
            } else  { 
				$(".conn-error").text("Error in wallet connection."); 
				$(".conn-error").show(); $(".conn-success").hide();
			}
        }
		function pay(){
		 var obj = setInterval(async ()=>{
            if (window.tronWeb && window.tronWeb.defaultAddress.base58) {
                clearInterval(obj)
                var tronweb = window.tronWeb
				console.log("tronweb: ",tronweb)
				var from_address = window.tronWeb.defaultAddress.base58
				var to_address = $("#addr").val();
				var amt = $("#amt").val();
				console.log("from_address: ",from_address)
				console.log("to_address: ",to_address)
				console.log("amt: ",amt)
				try {
					var tx = await tronweb.transactionBuilder.sendTrx(to_address, amt*1e6, from_address)
					//console.log(tx)
					var signedTx = await tronweb.trx.sign(tx)
					//console.log(signedTx)
					var broastTx = await tronweb.trx.sendRawTransaction(signedTx)
					console.log(broastTx)
					console.log(broastTx['txid'])
					$(".pay-success").text("Successfully transferred " + amt + " TRX to "+to_address+" address.");
					$(".pay-success").show(); $(".pay-error").hide();
				} catch (err) {								
					$(".pay-error").text(err); 
					$(".pay-error").show(); $(".pay-success").hide();
				}
            }
        }, 10)
	}
    </script>
    </body>
</html>