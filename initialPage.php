<!DOCTYPE HTML>

<!-- don't mess with anything here, everything is done -->

<title>Starbucks DTO Prototype</title>

<link rel="stylesheet" type="text/css" href="style.css">
<link rel="manifest" href="/manifest.json">

<center><img src="icons/sbuxLogo.png" width="200" height="200px"></center>

<center><h1>New Order:</h1></center>
<!-- id delivery -->

<div class="deliverySelection" id="pickUp">
<h2 class="methodHeader">Pick up</h2>
 <img class="methodHeader" src="icons/cart.png" width="90" height="90">
</div>

<h1 id="sentConfirmation">Order Successful!</h1>


<!-- next page loader script -->
<script>
var pickUpDiv = document.getElementById("pickUp");
var confirmationHeader = document.getElementById("sentConfirmation");

if(localStorage.getItem("sent") == "wroteOrder")
{
	confirmationHeader.style.color = "#ff4d4d";
	confirmationHeader.style.visibility = "visible";
	localStorage.setItem("sent", "noOrder");
}
//Checks whether the page was loaded after an order was submitted as well as resets the localStorage item
//If the page was loaded after order was submitted than the confirmationHeader will show
pickUpDiv.onclick = function(){clickedOption(this);};
function clickedOption(option){ //loads order.php and goes to next page
	window.open("order.php", "_self");
}
</script>
