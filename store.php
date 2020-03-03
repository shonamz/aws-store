
<?php
 session_start();
  
 ?> 

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Wine Search</title>
<!-- 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
 --><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="store.css">

</head>
<body>

	  <?php 
      include 'nav.php'; 
      ?> 
          <?php
         	$error="";
         	$txt="";

		   if(!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  	 		  header('Location: store-login.php');
		  } 
		  else {
 		      $txt = "Welcome to the member's area";
		       }
	      ?> 

<!-- <body>
 -->	 
	<div class="container-fluid">

		<div class="row">

			<form action="" method="" class="col-12" id="search-form">
				<div class="form-row">

					<div class="col-12 mt-4 col-sm-4 col-lg-2 autocomplete" >
						<label for="product-id" class="sr-only">Product Name</label>
						<input type="text" name="" class="form-control" id="product-id" placeholder="Product Name" required="">
					</div>

					<div class="col-12 mt-4 col-sm-4 col-lg-2">
						<label for="quality-id" class="sr-only">Quantity in Stock</label>
						 
						<input type="number" name="" class="form-control" id="quantity-id" placeholder="Quantity" required="">

    					</div>

					<div class="col-12 mt-4 col-sm-4 col-lg-2">
						<label for="price-id" class="sr-only">Price per item</label>
						<input type="number" name="" class="form-control" id="price-id" placeholder="Price" required="">
					</div>
					<div class="col-12 mt-4 col-sm-auto">
						<button type="submit" class="btn btn-block">Submit</button>
					</div>

				</div> <!-- .form-row -->
			</form>

		</div> <!-- .row -->

		<div class="row">

			<table class="table table-responsive table-striped col-12 mt-4">
				<thead>
					<tr>
						<th>Product</th>
						<th>Quality</th>
						<th>Price</th>
						<th>Date submited</th>	
						<th>Total Value Number</th> 
					</tr>
				</thead>
				<tbody>
					<tr>
						<!-- <td>
					    <img src="https://spoonacular.com/productImages/430475-312x231.jpg">
						</td>
						<td>NV The Big Kahuna Merlot</td>
						<td>6.99</td>
						<td>A ripe and rounded Merlot with notes of plum, blackberry, and hint of spice .</td> -->
						 
					</tr>
				</tbody>
			</table>
		</div> <!-- .row -->

		<div>
			<span style="color:red" id ="divid"  ></span>

		</div>

	</div> <!-- .container-fluid -->

	<script>

	
			document.querySelector("#search-form").onsubmit = function() {

	        let product = document.querySelector("#product-id").value;
			let quantity = document.querySelector("#quantity-id").value;
			let price = document.querySelector("#price-id").value;
			let date= new Date();
 			var arr = {"prodcut": product,"quantity": quantity , "price":price, "date":date};
 			//console.log(arr	);
  	        const jsonString = JSON.stringify(arr);
  	        //console.log(jsonString);
 	       
	         //send data

	         var theUrl = "./receive.php";
	         const xhr = new XMLHttpRequest();
			 xhr.open("POST", theUrl);
			 xhr.setRequestHeader("Content-Type", "application/json");

			xhr.addEventListener("readystatechange", function () {
					if (this.readyState === this.DONE) {
						// console.log(this.responseText);

					}
			});

			xhr.send(jsonString);
			  
			 setTimeout(function(){ 

			 var xhr2 = new XMLHttpRequest();
			 var data = null;

			 xhr2.addEventListener("readystatechange", function () {
					if (this.readyState === this.DONE) {
						// console.log(this.responseText);

					}
			});
 
			 xhr2.open("GET", "./data1.json?product=" +product + "&quantity=" +quantity+ "&price=" +price+ "&date=" +date);
			 xhr2.setRequestHeader("Content-Type", "application/json");
			 xhr2.send(data);

			 xhr2.onreadystatechange = function() {
			 
			if(this.readyState == this.DONE) {
					// Received some kind of response
					if(xhr2.readyState === 4 &&xhr2.status == 200 ) {
						// Got a succesful response
 						   var myObject = eval('[' + xhr2.responseText + ']');
 
						// Convert the responsText JSON string to JS objects
 						   let responseObjects = JSON.parse("[" + xhr2.responseText + "]");
 						   displayResults(responseObjects);

					}
					else {
						// Got a response, but it's an error
						console.log("Error!!!");
						console.log(xhr2.status); 
						let tbody = document.querySelector("tbody");
						while( tbody.hasChildNodes() ) {
							tbody.removeChild( tbody.lastChild );
						}
						 
					}
				}
			}

	 }, 1000);			  
// prevent form from being submitted
return false;
}
function displayResults(results) {

	let tbody = document.querySelector("tbody");
	while( tbody.hasChildNodes() ) {
		tbody.removeChild( tbody.lastChild );
	}

    let id = document.querySelector("#divid");
    while (id.hasChildNodes()){
    	id.removeChild(id.lastChild);
    }

      var totalValueNumber =[];
	 for(let i = 0; i < results.length; i++) { 

	let trElement = document.createElement("tr");
	document.querySelector("tbody").appendChild(trElement);
 	 
	 // Create <td> for product
	let productElement = document.createElement("td");
	 
	var json_data = results[i];
	var resuArray =json2array(json_data);
	productElement.innerHTML = resuArray[0];
	trElement.appendChild(productElement);

	 // Create <td> for quantity
	let quantityElement = document.createElement("td");
     quantityElement.innerHTML = resuArray[1];
    trElement.appendChild(quantityElement);

   // Create <td> for price
	let priceElement = document.createElement("td");
     priceElement.innerHTML = resuArray[2];
     trElement.appendChild(priceElement);

      // Create <td> for date
	let dateElement = document.createElement("td");
     dateElement.innerHTML = resuArray[3];
     trElement.appendChild(dateElement);

       // Create <td> for total
	let totalElement = document.createElement("td");
	var quantityValue = resuArray[1];
	var priceValue= resuArray[2];
	var totalValue =[];
	totalValue[i]=eval(quantityValue*priceValue);
    totalElement.innerHTML = totalValue[i];
    trElement.appendChild(totalElement); 
    totalValueNumber.push(totalValue[i]);
     
   }
    var sum = 0;
 
    let trValueElement = document.createElement("tr");
	document.querySelector("tbody").appendChild(trValueElement);

 
     var sum = totalValueNumber.reduce(function(a, b){
        return a + b;
    }, 0);
    
   //create td for paragraph

    let paragraphElement = document.createElement("td");
      paragraphElement.innerHTML = "total value Number";
      trValueElement.appendChild(paragraphElement); 

       // Create <td> for total value Number
	 let totalValueElement = document.createElement("td");
      totalValueElement.innerHTML = sum;
       trValueElement.appendChild(totalValueElement); 

    
  function json2array(json){
    var result = [];
    var keys = Object.keys(json);
    keys.forEach(function(key){
        result.push(json[key]);
    });
    return result;
} 
	  
  }
				
	</script>	
 </body>
</html>
 