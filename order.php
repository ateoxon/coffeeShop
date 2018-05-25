<link rel="stylesheet" type="text/css" href="style.css">
<link rel="manifest" href="/manifest.json">

<!-- database connection occurs here / completed -->
<?php $servername = "localhost";
$username = "root";
$password = "123angelo1";
$dbname = "sbuxdto";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); } ?>


<!-- nice html to make it look pretty -->
<img class="topHeader" src="icons/sbuxLogo.png" height="100" width="100">
<h1 class="topHeader">Starbucks Drive Through Prototype</h1>
<div class="tooltip">
 <img src="icons/helpIcon.png" height="40" width="40">
 <span class="tooltiptext">Click on the beverages you would like to order;
   <br> Click on the size to change size</span>
</div>
<br>
<br><br>

<!-- this loads data from database -->
<?php
$sql = " SELECT drinkName,drinkID, tallCost FROM drinkList";
$result = $conn->query($sql);
echo "<ol id='coffeeTypeList'>";
if($result->num_rows >0)
{
  $i = 0;
  while($row = $result->fetch_assoc()) // this loads database into list, also creates array of pricing which someone can pull from later to get total !!
  {
    echo  "<li id=".$row["drinkID"].">".$row["drinkName"]."</li>";
    echo "$".$row["tallCost"];

   $pricingArray[$i] = $row["tallCost"];

  $i = $i+1;
  }
}else {
  echo "you're a dummy and you did this wrong";
}
echo "</oi>";
?>


<h1>Name:<h1>
<input id="nameInput" type="text" maxLength="13" onkeypress="return isProperLetterInput(event)">
<br>
<br>

<br>
<br>
<button id="nextButton">Next</button>
<br>
<br>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

<!-- i'm so sorry but below you'll find the javascript code all in a giant
script tag because for some reason it wouldn't accept external code when
the script was typed as .php -->

<script>

//Global variables
var nameInput = document.getElementById("nameInput");
var nextButton = document.getElementById("nextButton");
var totalCost =0 ;





var coffeeLiArray = $("li").toArray();

for(var i = 0; i < coffeeLiArray.length; i++) //iterates through the coffeeLiArray
{                                             //and sets .checked property and .onclick function accordingly
	coffeeLiArray[i].checked = false;

	coffeeLiArray[i].onclick = function (){
		selectCoffeeType(this);
	};
}

function isProperNumberInput(evt){
	if(evt.charCode >= 48 && evt.charCode <= 57)
		return true;
	else
		return false;
}

function isProperLetterInput(evt){
	if(/^[a-zA-Z]*$/g.test(String.fromCharCode(evt.charCode)) || evt.keyCode == 32)
		return true;
	else
		return false;
}
//these two functions return a boolean value for input boxes whether the character inputted was a valid one

function validInputs(){
	var allValidInputs;
	var numOfCoffees = 0;
	var invalidProblems = [];


	for(var i = 0; i < coffeeLiArray.length; i++)
	{
		if(coffeeLiArray[i].checked)
		{
			numOfCoffees += Number(coffeeLiArray[i].quantityElement.value);
		}
	}
	//iterates through the coffeeLiArray, if .checked is true then numOfCoffees is incremented by the value of the corresponding quantityElement




  //should iterate through coffeeLiArray and if .checked is true, add to drinkList the cost of a drink



	if(nameInput.value && numOfCoffees <= 5 && numOfCoffees >= 1)
	{
		allValidInputs = true;

	}else{
		allValidInputs = false;
		if(!nameInput.value)
			invalidProblems.splice(0,0, "*Enter Name");
		if(numOfCoffees < 1 || numOfCoffees > 10)
			invalidProblems.splice(0,0, "*Can only select up to 10 beverages");


		var problemParagraph = document.createElement("p");
		problemParagraph.setAttribute("id", "problemElement");
		for(i = 0; i < invalidProblems.length; i++)
		{

			problemParagraph.appendChild(document.createTextNode(invalidProblems[i]));
			problemParagraph.appendChild(document.createElement("br"));
		}

		problemParagraph.style.fontFamily = "Nunito", "sans-serif";
		problemParagraph.style.position = "absolute";
		problemParagraph.style.color = "red";
		problemParagraph.style.left = "685px";
		problemParagraph.style.top = "335px";
		document.body.appendChild(problemParagraph);
		//outputting problems with input to the user in a p element if any exists
	}

	return allValidInputs;
	//returns boolean value
}



//This function (completed) below is called when a coffee is selected:


function selectCoffeeType(coffeeLiElement){
	if(!coffeeLiElement.checked)
	{
		coffeeLiElement.quantityElement = document.createElement("input");
		coffeeLiElement.quantityElement.setAttribute("type", "text");
		coffeeLiElement.quantityElement.setAttribute("class", "quantityElement");
		coffeeLiElement.quantityElement.setAttribute("onkeypress", "return isProperNumberInput(event)");
		coffeeLiElement.quantityElement.setAttribute("maxLength", "1");
		coffeeLiElement.quantityElement.setAttribute("value", "1");

		coffeeLiElement.quantityElement.style.position = "absolute";
		coffeeLiElement.quantityElement.style.left = "550px";
		coffeeLiElement.quantityElement.style.top = $(coffeeLiElement).position().top + 14;
		document.body.appendChild(coffeeLiElement.quantityElement);

		coffeeLiElement.sizeSelector = document.createElement("div");
		coffeeLiElement.sizeSelector.setAttribute("class","sizeSelector");
		coffeeLiElement.sizeSelector.style.position = "absolute";
		coffeeLiElement.sizeSelector.style.left = "100px";
		coffeeLiElement.sizeSelector.style.top = $(coffeeLiElement).position().top + 10;
		coffeeLiElement.sizeSelector.checked = false;

		var sizeSpan = document.createElement("span");
		sizeSpan.setAttribute("id", "sizeSpan");
		sizeSpan.appendChild(document.createTextNode("Tall"));

		coffeeLiElement.sizeSelector.appendChild(sizeSpan);
		coffeeLiElement.sizeSelector.onclick = function(){selectSize(this);};
		document.body.appendChild(coffeeLiElement.sizeSelector);

		coffeeLiElement.checked = true;
		coffeeLiElement.style.color = "#d9d9d9";
		coffeeLiElement.style.backgroundColor = "#595959";

		//Essentially when the coffeeLiElement is clicked and it's not selected the corresponding quantityElement and
		//sizeSelector will appear. set .checked to true and the colors accordingly
  }
  else
	{
		document.body.removeChild(coffeeLiElement.quantityElement);
		document.body.removeChild(coffeeLiElement.sizeSelector);
		coffeeLiElement.checked = false;
		coffeeLiElement.style.color = "black";
		coffeeLiElement.style.backgroundColor = "#f2f2f2";

		//If coffeeLiElement is clicked and is already selected the corresponding quantityElement and sizeSelector will
		//disappear as well as changing the color accordingly
	}

}

//This function below is called when the sizeSelector is clicked
//TODO you have tall and venti, implement grande along with prices

function selectSize(sizeSelector){
	if(!sizeSelector.checked)
	{
		sizeSelector.checked = true;
		sizeSelector.style.backgroundColor = "#ff9966";
		$(sizeSelector).find("span").html("Venti");

	}else{
		sizeSelector.checked = false;
		sizeSelector.style.backgroundColor = "#66b3ff";
		$(sizeSelector).find("span").html("Tall");
	}
}
//If sizeSelector is checked (tall) it will change to "Venti" and vice versa
//Colors and labels change appropriately


function addConfirmOrderElements(){
	var totalCost = 0;

  var javaPriceArray = <?php echo json_encode($pricingArray); ?>;


	var confirmOrderDiv = document.createElement("div");
	confirmOrderDiv.setAttribute("id", "confirmOrderDiv");


	confirmOrderDiv.style.borderColor = "#ff4d4d";

	var customerHeader = document.createElement("H1");
	customerHeader.style.marginTop = "0px";
	customerHeader.appendChild(document.createTextNode(nameInput.value));
	confirmOrderDiv.appendChild(customerHeader);


	for(i=0 ; i < coffeeLiArray.length; i++)
	{
		if(coffeeLiArray[i].checked)
		{
			for(var a = 0; a < Number(coffeeLiArray[i].quantityElement.value); a++)
			{
				var orderElement = document.createElement("div");
				orderElement.style.display = "inline-block";
				orderElement.style.padding = "10px";
				orderElement.style.borderRadius = "10px";
				orderElement.style.borderStyle = "solid";
				orderElement.style.borderWidth = "2.5px";
				orderElement.style.fontFamily = "Nunito", "sans-serif";

				orderElement.appendChild(document.createTextNode(coffeeLiArray[i].innerHTML));
				orderElement.appendChild(document.createElement("br"));
				var priceTextNode;

//an attempt to pass db vars into js

        if(coffeeLiArray[i].sizeSelector.checked)
        {
          orderElement.style.borderColor = "#ff9966";
          var y =  parseFloat(javaPriceArray[i]) + .8;
          priceTextNode = document.createTextNode(y);
          totalCost += y;
        }
        else
        {
          orderElement.style.borderColor = "#66b3ff";

          var x = parseFloat(javaPriceArray[i]);

          priceTextNode = document.createTextNode(x);
          totalCost += (x);
  }

        orderElement.appendChild(priceTextNode);
				confirmOrderDiv.appendChild(orderElement);

			}
		}

	}


	//What's happening above: essentially checks which elements in coffeeLiArray
	//are selected and outputs the orderElements according to the corresponding
	// quantityElement.value

	var deliveryDetailsHeader = document.createElement("H1");
	var totalHeader = document.createElement("H2");

		deliveryDetailsHeader.appendChild(document.createTextNode("Pick Up at Cart"));
		confirmOrderDiv.appendChild(deliveryDetailsHeader);



	//If delivery was chosen then show the delivery cost and details

	totalHeader.appendChild(document.createTextNode("Total: $" + totalCost.toFixed(2).toString()));
	totalHeader.style.fontFamily = "Nunito", "sans-serif";
	confirmOrderDiv.appendChild(totalHeader);

	var confirmOrderButton = document.createElement("BUTTON");
	confirmOrderButton.setAttribute("class", "orderElementButton");
	confirmOrderButton.setAttribute("id", "confirmOrderButton");
	confirmOrderButton.appendChild(document.createTextNode("Confirm"));
	var cancelOrderButton = document.createElement("BUTTON");
	cancelOrderButton.setAttribute("class", "orderElementButton");
	cancelOrderButton.setAttribute("id", "cancelOrderButton");
	cancelOrderButton.appendChild(document.createTextNode("Cancel"));
	confirmOrderDiv.appendChild(cancelOrderButton);
	confirmOrderDiv.appendChild(confirmOrderButton);

	document.body.appendChild(confirmOrderDiv);

	confirmOrderButton.onclick = function(){orderDivConfirmation(true);};
	cancelOrderButton.onclick = function(){orderDivConfirmation(false);};
	//sets up the rest of confirmOrderDiv
}

function orderDivConfirmation(confirmed){
	if(confirmed)
	{
		localStorage.setItem("sent", "wroteOrder");
		window.open("initialPage.php", "_self");
		//sets the localStorage item "sent" to "wroteOrder" so a confirmation message is shown on initialPage.php

	}else{
		document.body.removeChild(confirmOrderDiv);
		nextButton.disabled = false;
		nextButton.style.backgroundColor = "#e9ece5";
		nextButton.style.opacity = "1";
		//If cancel is hit remove confirmOrderDiv and enable nextButton
		//Inputs aren't cleared so amendments can be made
	}

}

nextButton.onclick = function() {
	var problemElement = document.getElementById("problemElement");
	if(problemElement)
		document.body.removeChild(problemElement);

	//Check if problemElement exists and remove it if it does
	//If another one is required it will be taken care of in validInputs()
	if(validInputs())
	{

		//var currentOrder = new Order();

		this.disabled = true;
		this.style.backgroundColor = "gray";
		this.style.opacity = "0.1";

		addConfirmOrderElements();

	}
	//Call validInputs() to check for validInput
};

initOrderPage();
//To check deliveryMethod and set up the page



</script>
