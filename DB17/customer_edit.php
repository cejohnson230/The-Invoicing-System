<?php

/*

EDIT.PHP

Allows user to edit specific entry in database

*/



// creates the edit record form

// since this form is used multiple times in this file, I have made it a function that is easily reusable

function renderForm($Customer_ID,$firstname, $lastname,$midname,$line1,$line2,$city,$state,$zip,$error)

{

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>
   <title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {font-family: "Lato", sans-serif}
.mySlides {display: none}
</style>
<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-black w3-card-2">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="/db17/home.php" class="w3-bar-item w3-button w3-padding-large">HOME</a>
    <a href="#customers" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Customers</a>
    <a href="#products" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Products</a>
  </div>
</div>



<!-- Page content -->
<div class="w3-content" style="max-width:2000px;margin-top:46px">



<title>New Record</title>

</head>

<body>


<?php

// if there are any errors, display them

if ($error != '')

{

echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';

}

?>



<form action="" method="post">

<input type="hidden" name="Customer_ID" value="<?php echo $Customer_ID; ?>"/>

 <div class="w3-container w3-content w3-padding-64 w3-center" style="max-width:800px" id="customers">

     
  <h2 class="w3-wide w3-center">Edit Customer</h2>
     <br/>
     
         <div class="w3-row-padding w3-center">
  <div class="w3-third">
    <strong>Fist Name: </strong> 
    <input class="w3-input w3-border" type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="First Name"/>
  </div>
  <div class="w3-third">
  
    <strong>Last Name: </strong> 
    <input class="w3-input w3-border" type="text" name = "lastname" value="<?php echo $lastname; ?>" placeholder="Last Name"/> 
  </div>
  <div class="w3-third">
   <strong>Middle Name:</strong> 
    <input class="w3-input w3-border" type="text" name="midname" value="<?php echo $midname; ?>" placeholder="Middle Initial"/>
  </div>
  
</div>
     <br>
    
        <div class="w3-row-padding">
  <div class="w3-third">
   <strong>Address 1: </strong> 
    <input class="w3-input w3-border" type="text" name="line1" value="<?php echo $line1; ?>" placeholder="Address 1"/>
  </div>
  <div class="w3-third">
   <strong>Address 2: </strong> 
    <input class="w3-input w3-border" type="text" name="line2" value="<?php echo $line2; ?>" placeholder="Address 2"/>
  </div>
</div>
     <br>
             <div class="w3-row-padding">
  <div class="w3-third">
    <strong>City: </strong> 
    <input class="w3-input w3-border" type="text" name="city" value="<?php echo $city; ?>" placeholder="City"/>
  </div>
  <div class="w3-third">
    <strong>State: </strong> 
    <input class="w3-input w3-border" type="text" name="state" value="<?php echo $state; ?>" placeholder="State"/>
  </div>
    <div class="w3-third">
      <strong>Zip: </strong> 
    <input class="w3-input w3-border" type="text" name="zip" value="<?php echo $zip; ?>" placeholder="Zip"/>
  </div>
</div>
     

<br> 

<input type="submit" name="submit" value="Submit">

</div>

</form>

</body>

</html>

<?php

}







// connect to the database

include('connect-db.php');



// check if the form has been submitted. If it has, process the form and save it to the database

if (isset($_POST['submit']))

{

// confirm that the 'id' value is a valid integer before getting the form data

if (is_numeric($_POST['Customer_ID']))

{

// get form data, making sure it is valid

$Customer_ID = $_POST['Customer_ID'];
$firstname = mysqli_real_escape_string($conn,htmlspecialchars($_POST['firstname']));
$lastname =  mysqli_real_escape_string($conn,htmlspecialchars($_POST['lastname']));
$midname =   mysqli_real_escape_string($conn,htmlspecialchars($_POST['midname']));
$line1 =     mysqli_real_escape_string($conn,htmlspecialchars($_POST['line1']));
$line2 =     mysqli_real_escape_string($conn,htmlspecialchars($_POST['line2']));
$city =      mysqli_real_escape_string($conn,htmlspecialchars($_POST['city']));
$state =     mysqli_real_escape_string($conn,htmlspecialchars($_POST['state']));
$zip =       mysqli_real_escape_string($conn,htmlspecialchars($_POST['zip']));



// check that firstname/lastname fields are both filled in

	if ($firstname == '' || $lastname == ''|| $line1 == ''|| $line2 == ''|| $city == ''|| $state == ''|| $zip == '')

	{

// generate error message

$error = 'ERROR: Please fill in all required fields!';



//error, display form

renderForm($Customer_ID,$firstname, $lastname,$midname,$line1,$line2,$city,$state,$zip,$error);

	}

	else

	{

// save the data to the database

mysqli_query($conn,"UPDATE tblcustomer SET Name_First='$firstname', Name_Last='$lastname', Name_MI='$midname' where Customer_ID = $Customer_ID")

or die(mysql_error());

mysqli_query($conn,"UPDATE tbladdress SET Line_1='$line1', Line_2='$line2', City='$city', State='$state', Zip='$zip'where Customer_ID = $Customer_ID")

or die(mysql_error());



// once saved, redirect back to the view page

header("Location: home.php");

	}

}

else

{

// if the 'id' isn't valid, display an error

echo 'Error!';

}

}

else

// if the form hasn't been submitted, get the data from the db and display the form

{



// get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)

if (isset($_GET['Customer_ID']) && is_numeric($_GET['Customer_ID']) && $_GET['Customer_ID'] > 0)

{

// query db

$id = $_GET['Customer_ID'];

$result = mysqli_query($conn,"SELECT * FROM tblcustomer WHERE Customer_ID=$id")

or die(mysql_error());

$row = mysqli_fetch_array($result);


$result2 = mysqli_query($conn,"SELECT * FROM tbladdress WHERE Customer_ID=$id")

or die(mysql_error());

$row2 = mysqli_fetch_array($result2);


// check that the 'id' matches up with a row in the databse

if($row)

{



// get data from db

$firstname = $row['Name_First'];
$lastname = $row['Name_Last'];
$midname = $row['Name_MI'];
$line1 = $row2['Line_1'];
$line2 = $row2['Line_2'];
$city = $row2['City'];
$state = $row2['State'];
$zip = $row2['Zip'];


// show form

renderForm($id,$firstname,$lastname,$midname,$line1,$line2,$city,$state,$zip,'');

}

else

// if no match, display result

{

echo "No results!";

}

}

else

// if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error

{

echo 'Error!';

}

}

?>