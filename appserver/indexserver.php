<?php
ini_set('display_errors', 1);
error_reporting(~0);
include "centralconnect.php";
// This file is encompassing several scripts fr the whole mobile app. each page's code is related to one function which is running by Switch/Case below. ajaxflag is a variable which is sent by client will decide which scripts should run.
$formData2 = ($_REQUEST['formData']);
$formData = json_decode($formData2);
$ajaxflag = $formData->{'ajaxflag'};
$ajaxflag = mysql_real_escape_string($ajaxflag);
//$output = array('status' => false, 'massage' => $ajaxflag);
//	echo json_encode($output);
//die();


//$ajaxflag2 = isset($_REQUEST['formData']) ? json_decode($_REQUEST['ajaxflag']) : "Null";
switch ($ajaxflag) {
  case "0":
    $output = array('status' => false, 'massage' => 'case 0!');
	echo json_encode($output);
    break;
  case "1": //login via form
    $email = $formData->{'username'};
    $password = $formData->{'pass'}; 
	$email = mysql_real_escape_string($email);
	$password = mysql_real_escape_string($password);
	//sleep(10);
    normallogin($email,$password);
    break;
  case "2": //sign up via form
  	$name = mysql_real_escape_string($formData->{'uname'});
	$email = mysql_real_escape_string($formData->{'uemail'});
    $password = mysql_real_escape_string($formData->{'upass'}); 
	signupfunc($email,$name,$password);
    break;
  case "3": //forgot password form
	$forgotemail = mysql_real_escape_string($formData->{'forgotemail'});
	forgotfunc($forgotemail);
    break;
  case "4": //Area combo box in afui page
	areafunc();
    break;	
  case "5": //Cuisine combo box in afui page
    cuisinefunc();
    break;	
  case "6": //Event combo box in afui page
    eventsfunc();
    break;  
  case "7": //load all subscribed restaurants in afui page
	loadresfunc("7");
    break;  
  case "8": //load all free listing restaurants in afui page
	loadresfunc("8");
    break;  
  case "9": //load all nearby restaurants by GPS in afui page
	$lati = mysql_real_escape_string($formData->{'curlat'}); //current Latitude
	$longi = mysql_real_escape_string($formData->{'curlong'}); //current Longitude
	gpsfunc($lati,$longi);
    break; 
  case "10": //load all promotion restaurants in offers page
	loadoffersfunc();
    break; 
  case "11": //load all contents of each restaurant page
 	$branchID = mysql_real_escape_string($formData->{'branchID'});
	loadEach($branchID);
    break; 
  case "12": //load all dining offers located in each restaurant page
 	$res = mysql_real_escape_string($formData->{'res'});
	loadDine($res);
    break; 	
  case "13": //determining the number of the branch pictures which we should load in the photo gallery.
	$branch = mysql_real_escape_string($formData->{'branch'});
 	$res = mysql_real_escape_string($formData->{'res'});
	loadGallery($res,$branch);
    break; 	
  case "14": //load all restaurant reviews of a particular restaurant
 	$res = mysql_real_escape_string($formData->{'res'});	
	readReviews($res);
	break;
  case "15": //submit review of a particular restaurant
 	$res = mysql_real_escape_string($formData->{'res'});
	$name = mysql_real_escape_string($formData->{'name'});
	$email = mysql_real_escape_string($formData->{'email'});
	$comment = mysql_real_escape_string($formData->{'comment'});	
	writeReview($name,$email,$res,$comment);
	break;
  case "16": //checks current user has been submitted a rate or not.
	$res = mysql_real_escape_string($formData->{'res'});
	$branch = mysql_real_escape_string($formData->{'branch'});
	$email = mysql_real_escape_string($formData->{'email'});
	checkRate($res, $branch, $email);
	break;	
  case "17": //submits the new rate in the database	
 	$res = mysql_real_escape_string($formData->{'res'});
	$branch = mysql_real_escape_string($formData->{'branch'});
	$email = mysql_real_escape_string($formData->{'email'});
	$name = mysql_real_escape_string($formData->{'name'});
	$rate = mysql_real_escape_string($formData->{'newRate'});
	$oldRate = mysql_real_escape_string($formData->{'oldRate'});	
	submitRate($res, $branch, $email, $name, $rate, $oldRate);
	break;
  case "18": //submits the new rate in the database	
	loadBlog();	
	break;
  case "19": //Show a particular blog in each blog page	
 	$blogID = mysql_real_escape_string($formData->{'blogID'});
	loadeachBlog($blogID);
	break;
  case "20": //Sends data and configurations of each dine in type to reservation form on load of reservation3 page.
	$selectedbranch = mysql_real_escape_string($formData->{'branch'});
	$selectedres = mysql_real_escape_string($formData->{'res'});
	loadres3func($selectedbranch,$selectedres);
    break;
  case "21": //submit reservation form data from reservation3 page.	
	$res3name = mysql_real_escape_string($formData->{'name'});
	$res3email = mysql_real_escape_string($formData->{'email'});
	$res3branch = mysql_real_escape_string($formData->{'branch'});
	$res3res = mysql_real_escape_string($formData->{'res'});
	$res3phno = mysql_real_escape_string($formData->{'phno'});
	$res3dine = mysql_real_escape_string($formData->{'dine'});
	$res3date = mysql_real_escape_string($formData->{'datepicker'});
	$res3checkin = mysql_real_escape_string($formData->{'checkin'});
	$res3checkout = mysql_real_escape_string($formData->{'checkout'});
	$res3guest2 = mysql_real_escape_string($formData->{'guest2'});
	$res3guest = mysql_real_escape_string($formData->{'guest'});
	$res3kids = mysql_real_escape_string($formData->{'kids'});
	$res3remarks = mysql_real_escape_string($formData->{'remarks'});
	$res3guestflag = mysql_real_escape_string($formData->{'guestflag'});
	$res3maxguest = mysql_real_escape_string($formData->{'maxguest'});
	$res3uid = mysql_real_escape_string($formData->{'uid'});		
	submitRes3func($res3name,$res3email,$res3branch,$res3res,$res3phno,$res3dine,$res3date,$res3checkin,$res3checkout,$res3guest2,$res3guest,$res3kids,$res3remarks,$res3guestflag,$res3maxguest,$res3uid);
    break;
	case "22": //Load restaurant layouts and tables in reservation 9 page
	$resDB = mysql_real_escape_string($formData->{'dbname'});
	$bookingDate = mysql_real_escape_string($formData->{'resDate'});
	$selectedbranch = mysql_real_escape_string($formData->{'branch'});
	$tbprop = mysql_real_escape_string($formData->{'tableproperties'});
	$uniqueid = mysql_real_escape_string($formData->{'UID'});
	$cout = mysql_real_escape_string($formData->{'cout'});
	$cin = mysql_real_escape_string($formData->{'cin'});
	$maximumchair = mysql_real_escape_string($formData->{'maxchair'});
	$dine = mysql_real_escape_string($formData->{'dine'});
	loadLayout($resDB,$bookingDate,$uniqueid,$selectedbranch,$tbprop,$cout,$cin,$maximumchair,$dine);
    break;
	case "23": //Submit the selected tables to the database
    $uid = mysql_real_escape_string($formData->{'UID'});
	$tb1 = mysql_real_escape_string($formData->{'tb1'});
	$tb2 = mysql_real_escape_string($formData->{'tb2'});
	$tb3 = mysql_real_escape_string($formData->{'tb3'});
	$dbname = mysql_real_escape_string($formData->{'serial'});
	saveLayout($uid,$tb1,$tb2,$tb3,$dbname);	
	break;
	case "24": //Calculates the bill
    $uid = mysql_real_escape_string($formData->{'UID'});
	$vipflag = mysql_real_escape_string($formData->{'vipflag'});
	$dbname = mysql_real_escape_string($formData->{'serial'});
	$res = mysql_real_escape_string($formData->{'res'});	
	calculation($uid,$vipflag,$dbname,$res);
	break;
	case "25": //thank you page
    $uniqueid = mysql_real_escape_string($formData->{'UID'});
	$branch = mysql_real_escape_string($formData->{'branch'});
	$dbname = mysql_real_escape_string($formData->{'serial'});
	$restaurant = mysql_real_escape_string($formData->{'res'});
	$email = mysql_real_escape_string($formData->{'email'});
	$totalamount = mysql_real_escape_string($formData->{'totalamount'});
	$guests = mysql_real_escape_string($formData->{'totalguests'});
	$points = mysql_real_escape_string($formData->{'points'});
	thankyou($uniqueid,$dbname,$branch,$totalamount,$restaurant,$email,$guests,$points);	
	break;
	case "26": //save blog comments into database  
	$blogID = mysql_real_escape_string($formData->{'blogID'});
	$name = mysql_real_escape_string($formData->{'name'});
	$email = mysql_real_escape_string($formData->{'email'});
	$comment = mysql_real_escape_string($formData->{'comment'});		
	submitBlogComment($blogID,$name,$email,$comment);
	break;
	default:
    $output = array('status' => false, 'massage' => 'case default! ');	
	echo json_encode($output);
	$resDB = "kohincom_k69719471";
	$bookingDate = "2015-01-08";
	$selectedbranch = "Ampang";
	$tbprop = "tableproperties9";
	$uniqueid = "42a54837cb2ee2c398d49ab8187edbb2";
	$cout = "1380";
	$cin = "1260";
	$maximumchair = "4";
	loadLayout($resDB,$bookingDate,$uniqueid,$selectedbranch,$tbprop,$cout,$cin,$maximumchair);

}
?>

<?php //login and signup block to call this block Ajaxflag should be 0

function normallogin($email2,$pass2) {
   
	$sql1 = "Select * from users where email='$email2'";
	$res1 = mysql_query($sql1) or die(mysql_error());
	$num1 = mysql_num_rows($res1);
	if ($num1 > 0)
	{
		$row1 = mysql_fetch_array($res1);
		$passworddb = $row1['password'];
		if (crypt($pass2, $passworddb) == $passworddb)
		{	
			$nameuser = $row1['name'];
			$points = $row1['points'];
			$output = array('status' => true, 'name' => $nameuser, 'points' => $points);
		}
		else {
			$output = array('status' => false, 'massage' => 'Wrong Password!');
		}
	}
	else {
		$output = array('status' => false, 'massage' => 'Wrong Email!');
	}
    echo json_encode($output);

}

function signupfunc($email2,$name2,$password2) {

	$sql131 = "Select * from users where email='$email2'";
	$res131 = mysql_query($sql131) or die(mysql_error());	
	$num131 = mysql_num_rows($res131);
    if($num131 > 0){		
              $output = array('status' => false, 'massage' => 'Sorry, Your email address is already registered in our database. Please login with your email and password!');
                 }
	else{
	$points = 50;
	$password1 = crypt($password2);
	$source ='Mobile App Sign Up'; 
	$timezone = 'Asia/Kuala_Lumpur';
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	$todaydate = date('Y/m/d h:i:s');
	$sql = "Insert into users(name,email,password,points,source,signupdate) values ('$name2','$email2','$password1','$points','$source','$todaydate')";
	if (!mysql_query($sql))
	{
		die(mysql_error());
	}	
	   	$sqlsignup12 = "Insert into allusers (name,email,flag) values ('$name2','$email2','$source')";
		if (!mysql_query($sqlsignup12))
		{
			die(mysql_error());
		}
	$to = 'support@kreserve.com';
	$subject= "New User Signed up by Mobile App Signup Form"; 
	$details = " Dear Support, We have one new sign up user  from Mobile App.<br>Name: " .$name2. "\n Email: " .$email2;

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From:Signup Notification <support@kreserve.com>' . "\r\n";


// Mail it
mail($to, $subject, $details, $headers);    

// end of mail section In the mobile app no need to redirect anywhere. we can just send a successful signup message by Ajax 
$output = array('status' => true, 'massage' => 'Thank you, you are successfully registered in Kreserve.');
}
	echo json_encode($output);
}

//function for forgot password form. ajax flag 3
function forgotfunc($email3) {
	
	$sql1f = "Select * from users where email='$email3'";
	$result1f = mysql_query($sql1f) or die(mysql_error());
	$row1f = mysql_fetch_array($result1f);
	$num1f = mysql_num_rows($result1f);
	if ($num1f > 0)
	{
	$random= mt_rand(10000000, 99999999);
	$randdb = crypt($random);
	$to= $email3; 
	$sqlf1 = "Update users set password='$randdb' where email='$to'";
	if (!mysql_query($sqlf1))
	{
		die(mysql_error());	
	}
	$subject= "Your New Kreserve Password";
	$message = '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>KRESERVE | Book a table in Restaurants in Kuala Lumpur</title>
<meta name="generator" content="Kohitec R and D Team HTTP://www.kohitec.com">
<style type="text/css">
</style>
</head>
<body style="font-size:16px;">
<div class="maindiv" style="max-width:550px;margin: 15px auto ;">
<div id="head" style="position:relative;background: rgb(153,0,0);width:550px;z-index:0;">
<img id="back" style="z-index:5;width:90px;" src="http://www.kreserve.com/images/backemails.png">
<div id="kname" style="font-family:Tahoma, Geneva, sans-serif;font-size:135%;position:relative;padding:0% 0 0 1%;width:25%;color:#fff;font-weight:bold;z-index:4;">KRESERVE</div></div>

<div id="reservetext" style="position:relative;margin-left:auto;margin-right:auto;color:#333;font-size:10pt;z-index:5;margin-top:2%;font-family:Arial, Helvetica, sans-serif;text-align: justify;width: 90%;">You requested a new password for your account. Your login details are found below.</div>
<div id="yourreserve" style="position:relative;margin:2% 0 0 34%;float:left;color:#333;font-size:18px;z-index:6;width:266px;height:20px;
font-family:Lucida Sans Unicode, Lucida Grande, sans-serif;">Login Details</div>

<table id="rounded-corner" style="font-family: Lucida Sans Unicode,Lucida Grande, Sans-Serif;font-size: 12px;margin: 7% 0% 0% 11%;width: 430px;text-align: left;border-collapse: collapse;position:relative;z-index:5;" summary="2007 Major IT Companies" Profit">
        <tfoot>    	
    </tfoot>
    <tbody>
    	<tr>
        	<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Email:</td>
            <td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$email3.'</td>
            </tr>
        </tr>
        <tr>
        	<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Password:</td>
            <td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$random.'</td>
             </tr>
        
      
    </tbody>
</table>
<div id="yourreserve" style="position:relative;margin:0% 0 0 30%;float:left;color:#333;font-size:14px;z-index:6;width:266px;height:20px;
font-family:Lucida Sans Unicode, Lucida Grande, sans-serif;"> You can login with this temporary system generated password. Please change this password once you sign in to Kreserve.</div>
<div id="yourreserve" style="position:relative;margin:0% 0 0 2%;float:left;color:#333;font-size:14px;z-index:6;width:266px;height:20px;
font-family:Lucida Sans Unicode, Lucida Grande, sans-serif;">Best Regards</div>
<div id="yourreserve" style="position:relative;margin:0% 0 0 2%;float:left;color:#333;font-size:14px;z-index:6;width:266px;height:20px;
font-family:Lucida Sans Unicode, Lucida Grande, sans-serif;">K Reserve Support Team</div>
<div id="footer" style="background:#990000;width:550px;height:30px;margin:0% 0 0 0; position:relative;display:inline-block;">
<div id="contact" style="color: rgb(255, 255, 255);font-size: 9pt;z-index: 5;font-family:Arial, Helvetica, sans-serif;width: 100%;margin: 1% 0%;text-align: center;">Kreserve.com | Phone : 03-42650388 | Email: account@kreserve.com</div></div>
<p style="color:#fff;">Kreserve.com</p>
</div>
</body>
</html>';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From:Kreserve.com <support@kreserve.com>' . "\r\n"; 
mail($to,$subject,$message,$headers);
 	$output = array('status' => true, 'massage' => 'An email has been sent to your email address. Please check your email.');	
	}
	else
	{
	$output = array('status' => false, 'massage' => 'Sorry, The email is not registered with Kreserve!');	
	}	
    echo json_encode($output);
}

// This section is for area combo box. Ajax flag 4
function areafunc(){
$sql2 = "Select DISTINCT(area) from branch WHERE activate='1' ORDER BY area ASC";
$res2 = mysql_query($sql2) or die(mysql_error());
$counter=0;
$areaarray=array();
while($row2= mysql_fetch_array($res2))
	{
	array_push($areaarray, $row2['area']);
	$counter++;
	}
$output = array('status' => true, 'counter' => $counter, 'val' => $areaarray);
echo json_encode($output);
}

// This section is for cuisine combo box. Ajax flag 5
function cuisinefunc(){
$sql3="SELECT major AS cus FROM restaurantinfo WHERE activate ='1' UNION SELECT minor AS cus FROM restaurantinfo WHERE activate ='1' ORDER BY cus"; 
$res3 = mysql_query($sql3) or die(mysql_error());
$counter=0;
$cusarray=array();
while($row3= mysql_fetch_array($res3))
      {  
	  if(($row3["cus"]!="Select") && ($row3["cus"]!="")) {
														  array_push($cusarray, $row3["cus"]);
														  $counter++;
														  }
	   }
$output = array('status' => true, 'counter' => $counter, 'val' => $cusarray);
echo json_encode($output);
}

// This section is for event combo box. Ajax flag 6
function eventsfunc(){
$sql4="SELECT event1 AS allevents FROM restaurantinfo WHERE activate ='1' UNION SELECT event2 AS allevents FROM restaurantinfo WHERE activate ='1' UNION SELECT event3 AS allevents FROM restaurantinfo WHERE activate ='1' UNION SELECT event4 AS allevents FROM restaurantinfo WHERE activate ='1' ORDER BY allevents"; 
$res4 = mysql_query($sql4) or die(mysql_error());
$counter=0;
$cusarray=array();
while($row4= mysql_fetch_array($res4))
      {  
	  if(($row4["allevents"]!="-Select-") && ($row4["allevents"]!="")) {
														  array_push($cusarray, $row4["allevents"]);
														  $counter++;
														  }
	   }
$output = array('status' => true, 'counter' => $counter, 'val' => $cusarray);
echo json_encode($output);
}

// This section is loading all subscribed restaurants. Ajax flag 7 and 8.
function loadresfunc($flag7){
    if($flag7=="7") {
		$sql7 = "select * from (select * from branch where (activate = '1' AND disablebranch != '1' AND listingmembership>0) order by Rand()) branch order by listingmembership DESC";
	}
	if($flag7=="8") {
        $sql7 = "select * from (select * from branch where (activate = '1' AND disablebranch != '1' AND listingmembership<1) order by Rand()) branch order by listingmembership DESC";
	}
$res7 = mysql_query($sql7) or die(mysql_error());
$counter=0;
$areaarray=array();
$namearray=array();
$ratearray=array();
$cusarray=array();
$pricearray=array();
$eventsarray=array();
$picarray=array();
$branchidarray=array();
while($row7= mysql_fetch_array($res7))
{
array_push($namearray, $row7['restaurant']);
array_push($areaarray, $row7['area']);
array_push($ratearray, $row7['rate']);
if($row7['minor']!="Select"){array_push($cusarray, $row7['major']."-".$row7['minor']);}
else {array_push($cusarray, $row7['major']);}

array_push($pricearray, $row7['averageprice']);
array_push($eventsarray, $row7['event1']."-".$row7['event2']."-".$row7['event3']."-".$row7['event4']);
array_push($picarray, $row7['labelpic']);
array_push($branchidarray, $row7['id']);
$counter++;
}
$output = array('status' => true, 'counter' => $counter, 'name' => $namearray, 'area' => $areaarray, 'rate' => $ratearray, 'cus' => $cusarray, 'events' => $eventsarray, 'price' => $pricearray, 'picname' => $picarray, 'branchid' => $branchidarray);
echo json_encode($output);
}

//loads restaurants nearby (3 miles around current location by GPS). Ajax flag 9 
function gpsfunc($latitude,$longitude){
$radius = 3; //3 miles
$res9 = mysql_query("SELECT
    id
FROM
    branch
WHERE
    (
    	(69.1 * (latitude - " . $latitude . ")) * 
    	(69.1 * (latitude - " . $latitude . "))
    ) + ( 
    	(69.1 * (longitude - " . $longitude . ") * COS(" . $latitude . " / 57.3)) * 
    	(69.1 * (longitude - " . $longitude . ") * COS(" . $latitude . " / 57.3))
    ) < " . pow($radius, 2) . " 
ORDER BY 
    (
    	(69.1 * (latitude - " . $latitude . ")) * 
    	(69.1 * (latitude - " . $latitude . "))
    ) + ( 
    	(69.1 * (longitude - " . $longitude . ") * COS(" . $latitude . " / 57.3)) * 
    	(69.1 * (longitude - " . $longitude . ") * COS(" . $latitude . " / 57.3))
    ) ASC") or die(mysql_error());

$gpsidarray=array();
while($row9= mysql_fetch_array($res9))
       {
		array_push($gpsidarray, $row9["id"]);
	   }
$output = array('status' => true, 'nearbyid' => $gpsidarray);
echo json_encode($output);
}

// This section is loading all promotion restaurants. Ajax flag 10
function loadoffersfunc(){
$sql10 = "select * from  branch where (discount1 !='0' or discount2 !='0' or discount3 !='0' or discount4 !='0') and (activate = '1') order by greaterdiscount DESC";
$res10 = mysql_query($sql10) or die(mysql_error());

$counter10=0;
$areaarray=array();
$namearray=array();
$discountarray=array();
$cusarray=array();
$pricearray=array();
$offertitlearray=array();
$picarray=array();
$branchidarray=array();

while($row10= mysql_fetch_array($res10))
{
array_push($namearray, $row10['restaurant']);
array_push($areaarray, $row10['area']);

if($row10['minor']!="Select"){array_push($cusarray, $row10['major']."-".$row10['minor']);}
else {array_push($cusarray, $row10['major']);}

array_push($pricearray, $row10['averageprice']);
array_push($discountarray, $row10['greaterdiscount']);

$offertitle= "";
if($row10['greaterdiscount'] == $row10['discount1']) {$offertitle= $row10['event1'];}
else if($row10['greaterdiscount'] == $row10['discount2']) {$offertitle= $row10['event2'];}
else if($row10['greaterdiscount'] == $row10['discount3']) {$offertitle= $row10['event3'];}
else if($row10['greaterdiscount'] == $row10['discount4']) {$offertitle= $row10['event4'];}
array_push($offertitlearray, $offertitle);

array_push($picarray, $row10['labelpic']);
array_push($branchidarray, $row10['id']);
$counter10++;
}

$output = array('status' => true, 'counter' => $counter10, 'name' => $namearray, 'area' => $areaarray, 'discount' => $discountarray, 'cus' => $cusarray, 'offertitle' => $offertitlearray, 'price' => $pricearray, 'picname' => $picarray, 'branchid' => $branchidarray);
echo json_encode($output);
}

/////Loads data and configuration of each dining package like end date, price difference between kids and adults and ... on reservation 3 page
function loadres3func($currentbranch,$currentrestaurant){
if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Kuala_Lumpur');
$today20= date("Y/m/d");
$sql20 = "SELECT * FROM dine where (branch='$currentbranch') and (restaurant='$currentrestaurant') and ((date2='null1')or(STR_TO_DATE(  date2 ,  '%m/%d/%Y' ) >= '$today20')) ORDER BY dit ASC";
$res20 = mysql_query($sql20) or die(mysql_error());
$counter20=0;
$ditarray=array();
$enddatearray=array();
$kidsflagarray=array();
$agefromarray=array();
$ageuptoarray=array();
$maxguestarray = array();
while($row20= mysql_fetch_array($res20))
{
array_push($ditarray, $row20['dit']);
array_push($enddatearray,$row20['date2']);
array_push($maxguestarray,$row20['maxguest']);

$flagkid= "1"; //if price of kid and adult is different then it will be 1 otherwise it will be 2.
if(($row20['kids']=='same') && ($row20['fullkid']=='same')){$flagkid= "2";}
array_push($kidsflagarray,$flagkid);
array_push($agefromarray,$row20['agefrom']);
array_push($ageuptoarray,$row20['ageupto']);
$counter20++;
}
/// Find branch open and closing time.
$sql20b = "SELECT * FROM branch where (name='$currentbranch') and (restaurant='$currentrestaurant')";
$res20b = mysql_query($sql20b) or die(mysql_error());
$row20b = mysql_fetch_array($res20b);
if ($row20b['m1']=="0"){
	$opentime = $row20b['h1'].":".$row20b['m1']."0";
	}
else {
	$opentime = $row20b['h1'].":".$row20b['m1'];
}

if ($row20b['m2']=="0"){
	$closetime = $row20b['h2'].":".$row20b['m2']."0";
	}
else {
	$closetime = $row20b['h2'].":".$row20b['m2'];
}


$today21= date("m/d/Y");
$output = array('status' => true, 'counter' => $counter20, 'dit' => $ditarray, 'enddate' => $enddatearray, 'kidsflag' => $kidsflagarray, 'agefrom' => $agefromarray, 'ageupto' => $ageuptoarray, 'opentime' => $opentime, 'closetime' => $closetime, 'today' => $today21, 'maxguest' => $maxguestarray);
echo json_encode($output);
}

/////////Submit reservation form data. Ajax flag 21.
function submitRes3func($name,$email,$branch,$restaurant,$phno,$dine,$resdate,$checkin,$checkout,$totalguest,$adultqty,$kidqty,$remarks,$guestflag,$maxguest,$uniqueid){
	

	$intime = explode(":", $checkin);
	$outtime = explode(":", $checkout); 

	$h1= $intime[0];
	$m1= $intime[1];
	$h2= $outtime[0];
	$m2= $outtime[1];
	$arraydate = explode("/", $resdate);
	$day=$arraydate[1];
	$month= $arraydate[0];
	$year= $arraydate[2];
	$outputDate= $year."-".$month."-".$day;
	$cin = ($h1*60) + $m1; // check-in time converted to minutes
	$cout = ($h2*60) + $m2; // check-out time converted to minutes
	
	if($guestflag = "2") 
	{
	$guestqty = $totalguest; //$guestqty has total number of guests.
	$kidqty = 0;
	$adultqty = $totalguest;
	} 
	else {$guestqty= $adultqty + $kidqty;}
	$referenceno = mt_rand(100000000,999999999);
	
	////take today's date to save it in database as the date which customer did the reservation.
	$timezone = 'Asia/Kuala_Lumpur';
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	$datetime = date('Y-m-d H:i:s');
	$day1 = date('d');
	$month1 = date('m');
	$year1 = date('Y');	
	
	////connecting to the restaurant's individual database
	$sql21 = "Select * from databasename where restaurantname = '$restaurant'";
	$result21 = mysql_query($sql21) or die("error:21 ".mysql_error());
	$row21 = mysql_fetch_array($result21);
	$dbname = $row21['dbname'];
	include "connect.php";
	
	////check whether restaurant is closed bookings for this date or not.
	$sql21a = "SELECT * FROM closebooking WHERE (branch = '$branch') and (closingdate = '$resdate') and ((dine = 'All Dining Packages')or(dine LIKE '$dine'))";
	$result21a = mysql_query($sql21a) or die("error:21a ".mysql_error());
	if(mysql_num_rows($result21a)> 0){
	$output = array('status' => false, 'massage' => ' Sorry, The restaurant will not accept any booking for this date. Please choose another date.');
	echo json_encode($output);
	return false;
	}
	
	/////check this booking's guest quantity is not passing the maximum guest limit on that date for that dining package
	if($maxguest != "NULL1") {
		$totalDayGuests = $guestqty; // we save total number of guests for that date for this dining package in this variable.
		$sql21b = "Select * from reservation where day='$day' and month='$month' and branch='$branch' and year='$year' and dine='$dine' and paymentstatus != '' and paymentstatus != 'Cancelled'";
		$res21b = mysql_query($sql21b) or die("error:21b ".mysql_error());
		while($row21b = mysql_fetch_array($res21b))
		{
			$totalDayGuests .= $row21b['guest'] + $row21b['kids'] + $row21b['vipadultqty'] + $row21b['vipkidqty'] + $row21b['vipguest'];	
		}
		if ($totalDayGuests > $maxguest ) 
			{
			$output = array('status' => false, 'massage' => 'Sorry, This dining package is fully booked on this date at this branch!');
			echo json_encode($output);
			return false;
			}	
	}
	
	////check if there is booking restriction for minimum number of guests on that date then apply it on this booking.
	$sql21c = "SELECT * FROM kohincom_centralkreserve.maxguests WHERE (branch = '$branch') and (restaurant = '$restaurant') and (date = '$resdate') and ((dine = 'all')or(dine LIKE '$dine'))";
	$result21c = mysql_query($sql21c) or die("error:21c ".mysql_error());
	if($row21c = mysql_fetch_array($result21c)){
		if($guestqty < $row21c["guestlimit"]){
			$output = array('status' => false, 'massage' => 'Sorry, The restaurant restricted booking orders to minimum '.$row21c["guestlimit"].' guests for this date. please choose another date.');
			echo json_encode($output);
			return false;
			}
	}
	
	////Find the paymenttype from dine table to save with reservation data in reservation table
	$sql21d="Select * from dine where dit = '$dine' and branch='$branch'";
	$result21d=mysql_query($sql21d);
	$row21d=mysql_fetch_array($result21d);
	
	if ($row21d['payment'] == "alacarte") {
	$paymenttype = "Minimum Deposit";
	} 
	else {
	$paymenttype =  $row21d['payment'];
	}
	
	//// Save the user data in allusers table if not exists
	$sql21e="INSERT INTO kohincom_centralkreserve.allusers (name, email, flag)
	SELECT * FROM (SELECT '$name', '$email', 'Mobile App Booking') AS tmp
	WHERE NOT EXISTS (SELECT email FROM kohincom_centralkreserve.allusers WHERE email = '$email') LIMIT 1;";
	$result21e = mysql_query($sql21e) or die(mysql_error());

	////save booking information into central database
	if($uniqueid=="NULL1"){ //if a person amend a booking then e has a md5 generated uniqueid from his last ajax call. if it is null1 then it means it is a new booking.
		$uid="a";
		$uid.= uniqid();
		$uid.= $referenceno ;
		$uniqueid2 = md5($uid);
		$sql21f="INSERT INTO kohincom_centralkreserve.reservation (name,phno,email,loyality,dine,paymenttype,day,month, year, h1, m1, h2, m2, guest,kids, branch,restaurant, remarks,booking , referenceno, uniqueid, day1, month1, year1, datetime) VALUES
				('$name' , '$phno' ,'$email','NULL1','$dine' , '$paymenttype', '$day', '$month','$year','$h1','$m1','$h2','$m2','$adultqty', '$kidqty' ,'$branch','$restaurant','$remarks','0' ,'$referenceno', '$uniqueid2', '$day1', '$month1', '$year1', '$datetime')";		
		$result21f = mysql_query($sql21f) or die("error:21f - ".mysql_error());
		$id = mysql_insert_id();
	} else {
		$sql21f="Update kohincom_centralkreserve.reservation set name='$name',phno='$phno',email='$email',loyality='NULL1',dine='$dine',
		paymenttype='$paymenttype',day1='$day1', month1='$month1', year1='$year1', datetime= '$datetime', day='$day',month='$month', year='$year', h1='$h1', m1='$m1', h2='$h2', m2='$m2',
		guest='$adultqty',kids='$kidqty', branch='$branch', restaurant='$restaurant', remarks='$remarks',booking='0',referenceno='$referenceno'
		where uniqueid='$uniqueid'";
		$result21f = mysql_query($sql21f) or die(mysql_error());	
	}

	
	////save booking information in the restaurant's individual database.
	if($uniqueid=="NULL1"){
	$sql21g="INSERT INTO reservation (name,phno,email,loyality,dine,paymenttype,day,month, year, h1, m1, h2, m2, guest,kids, branch, remarks,booking,referenceno, uniqueid, day1, month1, year1, datetime) VALUES
			('$name', '$phno', '$email','NULL1','$dine' , '$paymenttype', '$day', '$month','$year','$h1','$m1','$h2','$m2','$adultqty', '$kidqty' ,'$branch','$remarks','0','$referenceno', '$uniqueid2', '$day1', '$month1', '$year1', '$datetime')";
	$result21g = mysql_query($sql21g) or die(mysql_error());	
	$id = mysql_insert_id();		  
	} else {
	$sql21g="Update reservation set name='$name',phno='$phno',email='$email',loyality='NULL1',dine='$dine',
		paymenttype='$paymenttype',day1='$day1', month1='$month1', year1='$year1', datetime= '$datetime',day='$day',month='$month', year='$year', h1='$h1', m1='$m1', h2='$h2', m2='$m2',
		 guest='$adultqty',kids='$kidqty', branch='$branch', remarks='$remarks',booking='0',referenceno='$referenceno'
		 where uniqueid='$uniqueid'";
	$result21g = mysql_query($sql21g) or die(mysql_error());
	}

	/////////Send a notification email to reservation@kreserve.com for a new pending booking	
	if($uniqueid=="NULL1"){
		$uniqueid = $uniqueid2;
		$reservationnum = $id +1000;
		$to ="reservation@kreserve.com";
		$mailtitle= "Support Team";
		$subject= "Pending booking from Kreserve Mobile App"; 
		$message = '
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<style type="text/css">
		</style>
		</head>
		<body>
		<div class="maindiv" style="max-width:550px;margin: 15px auto ;">
		<div id="head" style="position:relative;background: rgb(153,0,0);width:550px;z-index:0;">
		<img id="back" style="z-index:5;width:90px;" src="http://www.kreserve.com/images/backemails.png">
		<div id="kname" style="font-family:Tahoma, Geneva, sans-serif;font-size:135%;position:relative;padding:0% 0 0 1%;width:25%;color:#fff;font-weight:bold;z-index:4;">KRESERVE</div></div>
		<div id="thankyou" style="position:relative;margin:2% 0 0 0%;text-align:left;color:#ff9900;font-size:20px;z-index:6;width:291px;height:20px;font-family:Courier New, Courier, monospace;font-weight:bold;"> Dear '.$mailtitle.'<br><span style="font-size:16px;color:black;"> You have got a pending booking from Kreserve Mobile App.<br> Kindly log-in to your Kreserve control panel to view details</span></div>
		<div id="yourreserve" style="position:relative;margin:2% 0 0 19%;float:left;color:#333;font-size:18px;z-index:6;width:266px;height:20px;
		font-family:Lucida Sans Unicode, Lucida Grande, sans-serif;">Reservation Number is:</div>
		<div id="reservenum" style="position:relative;margin:2.2% 24%  0 0;float:right;overflow:auto;color:#333;font-size:13pt;z-index:5;font-family: Lucida Sans Unicode, Lucida Grande, sans-serif;">'.$reservationnum.'</div>
		<table id="rounded-corner" style="font-family: Lucida Sans Unicode,Lucida Grande, Sans-Serif;font-size: 12px;margin: 7% 0% 0% 11%;width: 430px;text-align: left;border-collapse: collapse;position:relative;z-index:5;" summary="2007 Major IT Companies" Profit">		   
			<tfoot>				
			</tfoot>
			<tbody>
			<tr>
					<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Name:</td>
					<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$name.'</td>
					</tr>			
				<tr>
					<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Date Of booking:</td>
					<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$day.'-'.$month .'-'.$year.'</td>
					</tr>
				</tr>				
				<tr>
					<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Phone:</td>
					<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$phno.'</td>
				</tr>
				<tr>
					<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">E Mail:</td>
					<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$email.'</td>
				</tr>
				
				 <tr>
					<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Restaurant:</td>
					<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$restaurant.'</td>					
				</tr>				 
				 <tr>
					<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Branch:</td>
					<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$branch.'</td>
				</tr>
			</tbody>
		</table>
		<div id="footer" style="background:#990000;width:550px;height:30px;margin:3.3% 0 0 0">
		<div id="contact" style="color: rgb(255, 255, 255);font-size: 9pt;z-index: 5;font-family:Arial, Helvetica, sans-serif;width: 100%;margin: 1% 0%;text-align: center;">Kreserve.com | Phone : 03-42650388 | Email: support@kreserve.com</div></div>
		<p style="color:#fff;">Kreserve.com</p>
		</div>
		</body>
		</html>';     		   
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		// Additional headers
		$headers .= 'From:Kreserve Notification <reservation@kreserve.com>' . "\r\n";
		//$headers .= 'Bcc: reservation@kreserve.com' . "\r\n";

		// Mail it
		mail($to, $subject, $message, $headers);    
		/////////// end of mail section
	}	
	
	////check what is the next page for redirection.
	$nextpage = "bill";
	$tableproperties = "NULL1";	
	if ($row21d['disablemapsection'] != "1") {
	$cdate = $day.'-'.$month.'-'. $year; // CUSTOMER BOOKING DATE CONEVERETED TO TIME STAMP
	$cuser_ts = strtotime ($cdate); // CUSTOMER DATE CONVERTED 

	// TO SHOW PARTICULAR MAP ON THAT DATE 
	$sql21h = "Select * from maplist WHERE saveflag != '0' and branch='$branch'"; // a-7
	$result21h = mysql_query($sql21h) or die(mysql_error());
	$num21h = mysql_num_rows($result21h);

	//check date and find map
	$count21h = 0;
	while ($count21h < $num21h)
		{
		$row21h = mysql_fetch_array ($result21h);
		$disabledate1 = $row21h['disabledate1']; // a-8
		$disabledate2 = $row21h['disabledate2']; // a-9

		$disablemonth1 = substr($disabledate1,0,2);
		$disableday1 = substr($disabledate1,3,2);
		$disableyear1 = substr($disabledate1,6,7);

		$disabledatestart = $disableday1.'-'.$disablemonth1.'-'.$disableyear1;

		$disablemonth2 = substr($disabledate2,0,2);
		$disableday2 = substr($disabledate2,3,2);
		$disableyear2 = substr($disabledate2,6,7);

		$disabledateend = $disableday2.'-'.$disablemonth2.'-'.$disableyear2;
					
		$mapsdate = $row21h['sday'].'-'.$row21h['smonth'].'-'.$row21h['syear'];//START DATE OF ALL MAPS DATABASE // a-10 		
		$mapedate = $row21h['eday'].'-'.$row21h['emonth'].'-'.$row21h['eyear'];// END DATE OF ALL MAPS // a-11

		$disablestart_ts = strtotime($disabledatestart); //CONVERTED TO TIMESTAMP  
		$disableend_ts =  strtotime($disabledateend);   //CONVERTED TO TIMESTAMP

		$start_ts = strtotime($mapsdate); //CONVERTED TO TIMESTAMP
		$end_ts =  strtotime($mapedate);  //CONVERTED TO TIMESTAMP

				  if (($cuser_ts >= $start_ts) && ($cuser_ts <= $end_ts))  // a-12      
				  {
					if (($disablestart_ts > $cuser_ts) or ($disableend_ts < $cuser_ts)) // a-13
						{		  
						$nextpage = "reservation9";
						$tableproperties = $row21h['tablepropertiesname']; // select table properties 
						$count21h=$num21h;
						}
				  }          
		$count21h++;
		} // ends while
	}	
	
	//calculate the maximum chair for a booking. we need this data for reservation9 and layout.
	if($row21d['extrachair'] != "-1") {
	$maxchair = $guestqty + $row21d['extrachair'];
	}
	else {$maxchair = "-1";}
	
	////send Ajax response
	$output = array('status' => true, 'uid' => $uniqueid, 'serial' => $dbname, 'nextpage' => $nextpage, 'layout' => $tableproperties, 'cin' => $cin, 'cout' => $cout, 'resDate' => $outputDate, 'maxchair' => $maxchair, 'totalguest' => $guestqty);
	echo json_encode($output);
}

////Load layout of a branch on restaurant map page. It just load the tables which are not booked.
function loadLayout($dbname,$resDate,$uid,$branch,$tableproperties,$checkout,$checkin,$maxchair,$dine){
	include "connect.php";
	
	$sql22 = "Select * from dine WHERE dit='$dine'";
	$result22 = mysql_query($sql22) or die(mysql_error());
	$row22 = mysql_fetch_array($result22);
	if($row22['disablemapsection'] == "1"){
	$output = array('redirect' => true, 'nextpage' => 'bill');
	echo json_encode($output);
	}
	else {	
	////check which tables are already booked.
	$disabledTablesArray=array();
	$sql22a="Select * from reservation WHERE (datetime LIKE '".$resDate."%') AND (uniqueid!='".$uid."') AND (branch='".$branch."') AND (!(".$checkout." < (h1*60 + m1)) OR (".$checkin." > (h2*60 + m2)))";
	$result22a=mysql_query($sql22a) or die(mysql_error());	
	while($row22a= mysql_fetch_array($result22a))
	{
		array_push($tableNumberArray, $row22a['tb1']);	
		array_push($tableNumberArray, $row22a['tb2']);	
		array_push($tableNumberArray, $row22a['tb3']);	
	}
	
	//// Load tables which the number of their chairs are smaller than maximum allowed chairs.
	$sql22b="Select * from ".$tableproperties." WHERE tbpic != 'wall'";
	if($maxchair != "-1"){
	$sql22b .= " AND chairs <= ".$maxchair;
	}
	$result22b=mysql_query($sql22b) or die(mysql_error());
	$tableNumberArray=array();
	$vipArray=array();
	$chairArray=array();
	$counter22=0;
	while($row22b= mysql_fetch_array($result22b))
	{
		if (!(in_array($row22b['tableno'], $tableNumberArray))){
			array_push($tableNumberArray, $row22b['tableno']);
			array_push($vipArray, $row22b['vip']);
			array_push($chairArray, $row22b['chairs']);
			$counter22++;
		}
	}
	$output = array('status' => true, 'redirect' => false, 'counter' => $counter22, 'tableno' => $tableNumberArray, 'vip' => $vipArray, 'chair' => $chairArray);
	echo json_encode($output);
} //end of else

}
///Ajax flag 23: save the tables user selected into database.
 function saveLayout($uid,$tb1,$tb2,$tb3,$dbname){
	include "connect.php";	
	$sql23a = "UPDATE reservation SET tb1='$tb1', tb2='$tb2', tb3='$tb3' WHERE uniqueid='$uid' and paymentstatus !=''";
	mysql_query($sql23a) or die(mysql_error());
	$sql23b = "UPDATE  kohincom_centralkreserve.reservation SET tb1='$tb1', tb2='$tb2', tb3='$tb3' WHERE uniqueid='$uid' and paymentstatus !=''";
	mysql_query($sql23b) or die(mysql_error());
	$output = array('status' => true);
	echo json_encode($output);
 }
 
 ///Ajax flag 24: Calculates the amount of the bill, save it to the payment table and show it to the user.
 function calculation($uniqueid,$vipflag,$dbname,$restaurant){
	$sql24b = "Select * from databasename where dbname='$dbname'";
	$result24b = mysql_query($sql24b) or die(mysql_error());
	$row24b = mysql_fetch_array($result24b);
	$dbuid= $row24b['uniqueid'];
	
	include "connect.php";

	$sql9c="Select * from kohincom_centralkreserve.reservation where uniqueid='$uniqueid'"; 
	$result9c = mysql_query($sql9c) or die(mysql_error());
	$row9c=mysql_fetch_array($result9c);
	$idc= $row9c['id']; // we have to save this id in the central payment table. It must be same with id of this user in central reservation table.

	$sql9="Select * from reservation where uniqueid='$uniqueid'"; 
	$result9 = mysql_query($sql9) or die(mysql_error());
	$row9=mysql_fetch_array($result9);

	// Get values from reservation table
	$name=$row9['name'];
	//$loyalty = $row9['loyality'];
	$dine=$row9['dine'];
	$branch = $row9['branch'];
	$day=$row9['day'];
	$month = $row9['month'];
	$year = $row9['year'];
	$adultqty = $row9['guest'];
	$kidqty= $row9['kids'];
	if ($adultqty == 0)
	{
	$adultqty = $row9['vipadultqty']; // no of adults
	}
	if ($kidqty ==  0)
	{
	$kidqty = $row9['vipkidqty']; // no of kids
	}
	if ($adultqty == 0)
	{
	$adultqty = $row9['vipguest']; // no of kids
	}

	$monthlen = strlen($month);
	if ($monthlen == 1)
	{
	$monthlen1 = '0'.$month;
	}
	else
	{
	$monthlen1 = $month;
	}

	$daylen = strlen($day);
	if ($daylen == 1)
	{
	$daylen1 = '0'.$day;
	}
	else
	{
	$daylen1 = $day;
	}
	$dateholiday = $monthlen1.'/'.$daylen1.'/'.$year;

	$dateweek = $month.'/'.$day.'/'.$year;
	$date1week = strtotime($dateweek);
	$date2week = date("l", $date1week);
	$date3week = strtolower($date2week);
	if(($date3week == "saturday" )|| ($date3week == "sunday")) // a-7
	{
	   $rates = "week";         
	}
	 
	else 
	{
	 $rates = "normal";
	}

	$sql540 = "Select * from kohincom_centralkreserve.holidays where date ='$dateholiday'"; // a-8
	$res540 = mysql_query($sql540) or die(mysql_error());
	$num540 = mysql_num_rows($res540);
	if ($num540 > 0)
	{
	  $rates = "week"; 
	}

	$id= $row9['id'];
	if ($dine =="A La Carte" &&  $row9['paymenttype'] =='No Payment') // a-10
	{
	$output = array('redirect' => true, 'nextpage' => 'thankyou', 'totalamount' => '0');
	echo json_encode($output);
	}
	else
	{
	$sql898912 = "Select * from payment where id='$id'"; // a- 11
	$res898912 = mysql_query($sql898912) or die(mysql_error());
	$num898912 = mysql_num_rows($res898912);
	if ($num898912 == 1)
	{
		$sql8989 = "delete  from payment where id='$id'"; // a-12
	if (!mysql_query($sql8989))
	{
	die(mysql_error());
	}
	}

	$sql898912a = "Select * from kohincom_centralkreserve.payment where id='$idc'"; // a-13
	$res898912a = mysql_query($sql898912a) or die(mysql_error());
	$num898912a = mysql_num_rows($res898912a);

	if ($num898912a == 1)
	{
	$sql89891 = "delete  from kohincom_centralkreserve.payment where id='$idc'"; // a-14
	if (!mysql_query($sql89891))
	{
	die(mysql_error());
	}
	}

	$sql7="Select * from dine where dit ='$dine' and branch='$branch'"; // CALLING DINE TYPE SELECTED BY CUSTOMER TO CHECK PROMOTIONS DATES & RATES / DISCOUNTS/ PAYMENT METHOD//..
	$result7=mysql_query($sql7) or die(mysql_error());
	$num7=mysql_num_rows($result7);
	$row7=mysql_fetch_array($result7); 
	 
	// this section checks our kid price is different with adult price or it is same price. If it is same then it makes kids prices same as adults to always use adults prices.
	if ($vipflag == "1"){ // a-15	
				if ($rates == "normal") // a-16
				{
						$fulladultprice = $row7['fullvipadult'];						
						$depositadultprice = $row7['vipadult'];
						if ($row7['fullvipkids']=="same"){ // a-17
						$fullkidprice = $row7['fullvipadult'];
						}
						else {
						$fullkidprice = $row7['fullvipkids'];
						}
						if ($row7['vipkids']=="same"){
						$depositkidprice = $row7['vipadult'];
						}
						else {
						$depositkidprice = $row7['vipkids'];
						}
				} // rates normal closes ...
				else
				{
						$fulladultprice = $row7['fullvipadultweek'];					
						$depositadultprice = $row7['vipadultweek'];
						if ($row7['fullvipkidsweek']=="same"){
						$fullkidprice = $row7['fullvipadultweek'];
						}
						else {
						$fullkidprice = $row7['fullvipkidsweek'];
						}
						if ($row7['vipkidsweek']=="same"){
						$depositkidprice = $row7['vipadultweek'];
						}
						else {
						$depositkidprice = $row7['vipkidsweek'];
						}				
				}
						if ($kidqty == 0 ) // a-18
						{
									   
				   $vipqty = $adultqty + $kidqty;
				  
				   $sql10 = "Update reservation set vipguest='$vipqty' , guest = '0' where uniqueid='$uniqueid'";
				   if (!mysql_query($sql10))
				   {
					   die(mysql_error());
				   } 		   
					$sql10a = "Update kohincom_centralkreserve.reservation set vipguest='$vipqty' , guest = '0' where uniqueid='$uniqueid'";
				   if (!mysql_query($sql10a))
				   {
					   die(mysql_error());
				   } 		   
						}
						else
						{
							$vipadultqty = $adultqty;
							$vipkidqty = $kidqty;						
							$sql10 = "Update reservation set vipadultqty='$vipadultqty', vipkidqty='$vipkidqty' , guest = '0' ,kids='0' where uniqueid='$uniqueid'";
				   if (!mysql_query($sql10))
				   {
					   die(mysql_error());
				   } 
				   
					$sql10a = "Update kohincom_centralkreserve.reservation set  vipadultqty='$vipadultqty', vipkidqty='$vipkidqty' , guest = '0' ,kids='0' where uniqueid='$uniqueid'";
				   if (!mysql_query($sql10a))
				   {
					   die(mysql_error());
				   } 
						}			   
					} // if vipfag closes					
	else{
						if ($rates == "normal")
						{
							$fulladultprice = $row7['fulladult'];
							$depositadultprice = $row7['adult'];                
							if ($row7['fullkid']=="same"){
							$fullkidprice = $row7['fulladult'];}
							else {
							$fullkidprice = $row7['fullkid'];
							}
							if ($row7['kids']=="same"){
							$depositkidprice = $row7['adult'];
							}
							else {
							$depositkidprice = $row7['kids'];
							}
						} // rates normal closes

						else
						{
							 $fulladultprice = $row7['fulladultweek'];
							$depositadultprice = $row7['adultweek'];                
							if ($row7['fullkidweek']=="same"){
							$fullkidprice = $row7['fulladultweek'];}
							else {
							$fullkidprice = $row7['fullkidweek'];
							}
							if ($row7['kidsweek']=="same"){
							$depositkidprice = $row7['adultweek'];
							}
							else {
							$depositkidprice = $row7['kidsweek'];
							}						
						}
		} //else non vip table closes
										
	//end check kids and vip section.

	$totaladultfull = round(($adultqty * $fulladultprice),2); // a-19
	$totalkidfull = round(($kidqty * $fullkidprice),2); // a-20
	$totalfullbdis = $totaladultfull +$totalkidfull; //total full amount before discount a-21

	$totalpersons = $row7['totalpersons']; // TOTAL PERSON PACKAGE for discount section a-22
	@$freeperson = $row7['freeperson'];  // FREE PERSON qty for discount section a-23

	// TIME STAMP CONEVERSION
	$cdate = $day.'-'.$month.'-'. $year; // CUSTOMER BOOKING DATE CONEVERETED TO TIME STAMP 
	$cuser_ts = strtotime ($cdate); // CUSTOMER DATE CONVERTED a-24

	$sdate = $row7['day']."-".$row7['month']."-". $row7['year']; //PROMOTION START DATE CONEVERETED TO TIME STAMP
	$sdate_ts = strtotime ($sdate); // Start DATE CONVERTED a-25

	$edate = $row7['day1']."-".$row7['month1']."-". $row7['year1']; // PROMOTION END DATE CONEVERETED TO TIME STAMP
	$edate_ts = strtotime ($edate); // END DATE CONVERTED a-26
	//TIMESTAMP ENDS

	$totalguest = $adultqty + $kidqty;
	
	$payFlag="true"; //it means after bill we have to redirect to PayPal. Online payment is on.
	if(($row7['control']==1)||($row7['payment']=="No Payment")){
	$payFlag="false"; //it means after bill we have to redirect to thank you. Online payment is off.
	}
		
	//check payment methods for calculating deposit amount and other charges  
	  if ($row7['payment'] == "alacarte") { // 
		 // if dine type is an a la carte  
	$totaladultdeposit = $adultqty *  $depositadultprice;
	 
	$totalkiddeposit = $kidqty * $depositkidprice; 
	$totaladultfull = $totaladultdeposit;
	$totalkidfull = $totalkiddeposit; 
	$totaldeposit = $totaladultdeposit +$totalkiddeposit;

	$serviceandtax = 0; // in a la carte service charge and tax is zero
	$balance = "Depends on your food choices at the restaurant";
	//in a la carte all percentage type of member or normal discounts will apply in the restaurant 
	$totalmemberdiscount = 0; //it is 0 by default
	$totalnormaldiscount = 0; //it is 0 by default
	$totaldiscount = 0;

	//checks for discount of some pax free for every some pax!
		  if($totalpersons >0 && $freeperson >0) { //checks we have some loyalty plan or not // a-27
														   $discountguestqty = intval($totalguest * ($freeperson/$totalpersons));
														   $adultqty = $adultqty - $discountguestqty;
															// total value of discount   
														   $totaldiscount = $discountguestqty * $depositadultprice; 													 													   
														   }
	// if the customer books within the promotion periods
	if ($cuser_ts < $sdate_ts || $cuser_ts > $edate_ts) 
	{
	 $totaldiscount = 0;
	}

	//calculates deposit amount after discount
	$totalnormaldiscount = $totaldiscount; // I wrote this line just for better reading and clear my program more
	$totaldeposit = ($totaldeposit - $totalnormaldiscount);

	if (($totalpersons == 0) && ($row7['discount'] > 0)){ // It tells customer that she can earn some percentage of discount when she comes to the restaurant.
	$totalnormaldiscount = $row7['discount']."% of your total bill amount*";
	}

	//saves into database and goes to payment page
	if ($vipflag == "1") {
	mysql_query("INSERT INTO payment (id, name, dine, totalnormaladult, totalnormalkid, totalvipadult, totalvipkid, serviceandtax, discount, loyaltydiscount, depositamount, balance,branch) VALUES
	 ('$id', '$name', '$dine', '0', '0', '$totaladultfull', '$totalkidfull', '$serviceandtax', '$totalnormaldiscount', '0', '$totaldeposit', '$balance','$branch')") or die(mysql_error());

	mysql_query("INSERT INTO kohincom_centralkreserve.payment (id, name, dine, totalnormaladult, totalnormalkid, totalvipadult, totalvipkid, serviceandtax, discount, loyaltydiscount, depositamount, balance,branch,restaurant) VALUES
	 ('$idc', '$name', '$dine', '0', '0', '$totaladultfull', '$totalkidfull', '$serviceandtax', '$totalnormaldiscount', '0', '$totaldeposit', '$balance','$branch','$restaurant')") or die(mysql_error());
	 }
	else{	
	mysql_query("INSERT INTO payment (id, name, dine, totalnormaladult, totalnormalkid, totalvipadult, totalvipkid, serviceandtax, discount, loyaltydiscount, depositamount, balance,branch) 
	VALUES ('$id', '$name', '$dine', '$totaladultfull', '$totalkidfull', '0', '0', '$serviceandtax', '$totalnormaldiscount', '0', '$totaldeposit', '$balance','$branch')") or die(mysql_error());

	mysql_query("INSERT INTO kohincom_centralkreserve.payment (id, name, dine, totalnormaladult, totalnormalkid, totalvipadult, totalvipkid, serviceandtax, discount, loyaltydiscount, depositamount, balance,branch,restaurant) 
	VALUES ('$idc', '$name', '$dine', '$totaladultfull', '$totalkidfull', '0', '0', '$serviceandtax', '$totalnormaldiscount', '0', '$totaldeposit', '$balance','$branch','$restaurant')") or die(mysql_error());
	}
	if($row7['control']==2)
	{ // it means restaurant manager disabled showing the bill to customer.
	$output = array('status' => true, 'redirect' => true, 'nextpage' => 'thankyou', 'totalamount' => '0');
	echo json_encode($output);
	}
	else {
	$output = array('status' => true, 'redirect' => false, 'nextpage' => 'bill', 'adultPrice' => $totaladultfull, 'kidPrice' => $totalkidfull, 'sAndTax' => $serviceandtax, 'discount' => $totalnormaldiscount, 'deposit' => $totaldeposit, 'balance' => $balance, 'guestqty' => $adultqty, 'kidqty' => $kidqty, 'dbuid' => $dbuid, 'payFlag' => $payFlag);
	echo json_encode($output);
	}
	return false;
	}  // Payment al carte close

	$totalpaxdiscount=0;
	$totalpercentdiscount=0;
	$totalnormaldiscount=0;
	$totalmemberdiscount=0;
	$totalmemnormpercentage = $row7['discount'];
	// check promotion date 
	if ($cuser_ts < $sdate_ts || $cuser_ts > $edate_ts) 
	{
	$totalnormaldiscount = 0;
	}
	else {
	//calculates normal discount section
	if ($row7['discount'] > "0") { //discount as percentage
	$totalpercentdiscount = round(($totalfullbdis * ($row7['discount'] / 100)),2); // Total value of percentage discount

	//updates full kid price and adult's full price
	$fullkidprice = round(($fullkidprice - ($fullkidprice * ($totalmemnormpercentage / 100))),2); // full price of kid after percentage discount

	$fulladultprice = round (($fulladultprice - ($fulladultprice * ($totalmemnormpercentage  / 100))),2); // full price of adult after percentage discount

	}
	if($totalpersons >0 && $freeperson >0) {	
		 //checks we have some loyalty plan or not 
														   $discountguestqty = intval($totalguest * ($freeperson/$totalpersons));
														   $adultqty = $adultqty - $discountguestqty;
															// total value of discount   
														   $totalpaxdiscount = round($discountguestqty * $fulladultprice,2);
											}
											  
	$totalnormaldiscount = round(($totalpaxdiscount + $totalpercentdiscount),2); //total amount of discount
	}
	//end of calculating normal discount section

	//caclulates tax and service charges and total amount of the bill
	$totalfulladis = round(($totalfullbdis - ($totalnormaldiscount + $totalmemberdiscount)),2); // total full amount after discount
	$totalservicecharge = round((($row7['othercharge']/100) * $totalfulladis),2);

	$totalfulladis = round(($totalfulladis + $totalservicecharge),2);
	$totaltax = round((($row7['tax']/100) * $totalfulladis),2);
	$totalfulladis = round(($totalfulladis + $totaltax),2);
	$serviceandtax = round(($totaltax + $totalservicecharge),2);
	if ($rates =="normal")
	{
	// calculating total deposit amount and balance
	if(($row7['adult'] > 0) && ($row7['payment'] == "Minimum Deposit")) { //calulation of fixed deposit payments
	$totaladultdeposit = round(($adultqty *  $row7['adult']),2);
	$totalkiddeposit = round(($kidqty * $depositkidprice),2);
	$totaldeposit = round(($totalkiddeposit + $totaladultdeposit),2);
	$balance = round(($totalfulladis - $totaldeposit),2);
	}
	elseif(($row7['percentage'] > 0) && ($row7['payment'] == "Minimum Deposit")) { //calulation of percentage deposit payments
	$totaldeposit = round(($totalfulladis * ($row7['percentage'] / 100)),2);
	$balance = round(($totalfulladis - $totaldeposit),2);

	}
	elseif(($row7['payment'] == "Full Payment")) { //make deposit amount zero for full payments
	$totaldeposit = round($totalfulladis,2);
	$balance = 0;
	}
	elseif($row7['payment'] == "No Payment"){ //if it is in nopayment mode then all of the bill amount is balance
	$totaldeposit = 0;
	$balance = round($totalfulladis,2);
	}
	} //  rates normal days..
	else
	{
	// calculating total deposit amount and balance
	if(($row7['adultweek'] > 0) && ($row7['payment'] == "Minimum Deposit")) { //calulation of fixed deposit payments
	$totaladultdeposit = round(($adultqty *  $row7['adultweek']),2);
	$totalkiddeposit = round(($kidqty * $depositkidprice),2);
	$totaldeposit = round(($totalkiddeposit + $totaladultdeposit),2);
	$balance = round(($totalfulladis - $totaldeposit),2);
	}
	elseif(($row7['percentage'] > 0) && ($row7['payment'] == "Minimum Deposit")) { //calulation of percentage deposit payments
	$totaldeposit = round(($totalfulladis * ($row7['percentage'] / 100)),2);
	$balance = round(($totalfulladis - $totaldeposit),2);

	}
	elseif(($row7['payment'] == "Full Payment")) { //make deposit amount zero for full payments
	$totaldeposit = round($totalfulladis,2);
	$balance = 0;
	}
	elseif($row7['payment'] == "No Payment"){ //if it is in nopayment mode then all of the bill amount is balance
	$totaldeposit = 0;
	$balance = round($totalfulladis,2);
	}
	}
	//End of calculation deposit and balance

	//saves into database and goes to bill page
	if ($vipflag == "1") {
		
	mysql_query("INSERT INTO payment (id, name, dine, totalnormaladult, totalnormalkid, totalvipadult, totalvipkid, serviceandtax, discount, loyaltydiscount, depositamount, balance,branch) VALUES
	 ('$id', '$name', '$dine', '0', '0', '$totaladultfull', '$totalkidfull', '$serviceandtax', '$totalnormaldiscount', '0', '$totaldeposit', '$balance','$branch')") or die(mysql_error());


	mysql_query("INSERT INTO kohincom_centralkreserve.payment (id, name, dine, totalnormaladult, totalnormalkid, totalvipadult, totalvipkid, serviceandtax, discount, loyaltydiscount, depositamount, balance,branch,restaurant) VALUES
	 ('$idc', '$name', '$dine', '0', '0', '$totaladultfull', '$totalkidfull', '$serviceandtax', '$totalnormaldiscount', '0', '$totaldeposit', '$balance','$branch','$restaurant')") or die(mysql_error());
	}
	else {
	mysql_query("INSERT INTO payment (id, name, dine, totalnormaladult, totalnormalkid, totalvipadult, totalvipkid, serviceandtax, discount, loyaltydiscount, depositamount, balance,branch) VALUES 
	('$id', '$name', '$dine', '$totaladultfull', '$totalkidfull', '0', '0', '$serviceandtax', '$totalnormaldiscount', '0', '$totaldeposit', '$balance','$branch')") or die(mysql_error());

	mysql_query("INSERT INTO kohincom_centralkreserve.payment (id, name, dine, totalnormaladult, totalnormalkid, totalvipadult, totalvipkid, serviceandtax, discount, loyaltydiscount, depositamount, balance,branch,restaurant) VALUES 
	('$idc', '$name', '$dine', '$totaladultfull', '$totalkidfull', '0', '0', '$serviceandtax', '$totalnormaldiscount', '0', '$totaldeposit', '$balance','$branch','$restaurant')") or die(mysql_error());
	}

	if($row7['control']==2){ // it means restaurant manager disabled showing the bill to customer.
	$appAmount = $totaldeposit + $balance;
	$output = array('status' => true, 'redirect' => true, 'nextpage' => 'thankyou', 'totalamount' => $appAmount);
	echo json_encode($output);
	}
	else {
	$output = array('status' => true, 'redirect' => false, 'nextpage' => 'bill', 'adultPrice' => $totaladultfull, 'kidPrice' => $totalkidfull, 'sAndTax' => $serviceandtax, 'discount' => $totalnormaldiscount, 'deposit' => $totaldeposit, 'balance' => $balance, 'guestqty' => $adultqty, 'kidqty' => $kidqty, 'dbuid' => $dbuid, 'payFlag' => $payFlag);
	echo json_encode($output);
	}
	}//else closes ..//
 }
 
 //load data for thank you and reservation confirmation, calculates kreserve commission and user points, sends email to users and restaurant managers 
 function thankyou($uniqueid,$dbname,$branch,$totalamount,$restaurant,$email,$guests,$points){
	
	$timezone = 'Asia/Kuala_Lumpur';
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	$todaydate1 = date('Y/m/d');
	$todaydate = strtotime($todaydate1);
	
	include "connect.php";
	$sql25 = "Select * from reservation where uniqueid='$uniqueid'";
	$result25 = mysql_query($sql25) or die(mysql_error());
	$row25 = mysql_fetch_array($result25);
	$refNo = $row25['referenceno'];
	$reservationno = $row25['id'] + 1000;
	$h1= $row25['h1'];
	$h2= $row25['h2'];
	$m1= $row25['m1'];
	$m2= $row25['m2'];
	if ($m1=="0") {$m1="00";}
	if ($m2=="0") {$m2="00";}	
	$time1 = $h1.':'.$m1;
	$time2 = $h2.':'.$m2;
	$booking = $row25['booking'];
	$dine = $row25['dine'];
	$idlatest = $row25['id'];	
	$userName = $row25['name'];
	$userPhone = $row25['phno'];
	$date = $row25['day'].'/'.$row25['month'].'/'.$row25['year'];
	
	$sql25b = "Select * from branch where name='$branch'";
	$res25b = mysql_query($sql25b) or die(mysql_error());
	$row25b = mysql_fetch_array($res25b);
	$address = $row25b['address'];
	$phone = $row25b['phone'];

	//update payment status in reservation and payment tables
	$paymentstats = 'Sucessfull';
	$sql25c = "Update payment set paymentstatus='$paymentstats' where id='$idlatest' ";
	mysql_query($sql25c) or die(mysql_error());
	$sql25d = "Update reservation set paymentstatus='$paymentstats', paidamount='0' where id='$idlatest' ";
	mysql_query($sql25d) or die(mysql_error());
	$sql25d2 = "Update kohincom_centralkreserve.reservation set paymentstatus='$paymentstats', paidamount='0' where uniqueid='$uniqueid' ";
	mysql_query($sql25d2) or die(mysql_error());
	
	//update user's points
	$totalpoints = $points;	
	$sql25e = "Select * from kohincom_centralkreserve.users where email='$email' and uniqueid != '$uniqueid'";
	$res25e = mysql_query($sql25e) or die(mysql_error());
	$num25e = mysql_num_rows($res25e);
	$row25e = mysql_fetch_array($res25e);
	if ($num25e > 0)
		{
		$dbPoints = $row25e['points'];
		if ($dine == 'A La Carte')
		{
		$totalpoints = $guests * 25;
		}
		else
		{
		$totalpoints = $totalamount;
		}		
		$totalpoints = round($totalpoints + $dbPoints);	
		$sql25f = "Update kohincom_centralkreserve.users set points='$totalpoints' ,uniqueid ='$uniqueid' where email='$email'";
		mysql_query($sql25f) or die(mysql_error());
	}
			
	//send email to the user	
	$to = $email;
	$subject = "Booking Confirmation from Kreserve Mobile App at ".$restaurant;

	$message = '
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>KRESERVE | Book a table in Restaurants in Kuala Lumpur</title>
	<meta name="generator" content="Kohitec R and D Team HTTP://www.kohitec.com">
	<style type="text/css">
	</style>
	</head>
	<body>
	<div class="maindiv" style="max-width:550px;margin: 15px auto ;">
	<div id="head" style="position:relative;background: rgb(153,0,0);width:550px;z-index:0;">
	<img id="back" style="z-index:5;width:90px;" src="http://www.kreserve.com/images/backemails.png">
	<div id="kname" style="font-family:Tahoma, Geneva, sans-serif;font-size:135%;position:relative;padding:0% 0 0 1%;width:25%;color:#fff;font-weight:bold;z-index:4;">KRESERVE</div></div>
	<div id="thankyou" style="position:relative;margin:2% 0 0 22%;text-align:center;color:#ff9900;font-size:20px;z-index:6;width:291px;height:20px;font-family:Courier New, Courier, monospace;font-weight:bold;">Thank you for Booking</div>

	<div id="yourreserve" style="position:relative;margin:2% 0 0 19%;float:left;color:#333;font-size:18px;z-index:6;width:266px;height:20px;
	font-family:Lucida Sans Unicode, Lucida Grande, sans-serif;">Please show this receipt to the restaurant. Your Reservation Number is:</div>
	<div id="reservenum" style="position:relative;margin:2.2% 24%  0 0;float:right;overflow:auto;color:#333;font-size:13pt;z-index:5;font-family: Lucida Sans Unicode, Lucida Grande, sans-serif;">'.$reservationno.'</div>

	<table id="rounded-corner" style="font-family: Lucida Sans Unicode,Lucida Grande, Sans-Serif;font-size: 12px;margin: 7% 0% 0% 11%;width: 430px;text-align: left;border-collapse: collapse;position:relative;z-index:5;">	   
		<tfoot>			
		</tfoot>
		<tbody>
		<tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Reference Number:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$refNo.'</td>
				</tr>
			<tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Name:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$username.'</td>
				</tr>
			</tr>		
			<tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Date Of booking:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$date.'</td>
				</tr>
			</tr>
			<tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Check In:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$time1.'</td>
				 </tr>
			<tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Check Out:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$time2.'</td>
			</tr>
			<tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Dining Offer:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$dine.'</td>
			</tr>
			 <tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Number Of Guest(s):</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$guests.'</td>
			</tr>
			 <tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Restaurant:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$restaurant.'</td>
				
			</tr>
			 <tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Address:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$address.'</td>
			</tr>
			 <tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Phone:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$phone.'</td>
			</tr>
		</tbody>
	</table>

	<div id="footer" style="background:#990000;width:550px;height:30px;margin:3.3% 0 0 0">
	<div id="contact" style="color: rgb(255, 255, 255);font-size: 9pt;z-index: 5;font-family:Arial, Helvetica, sans-serif;width: 100%;margin: 1% 0%;text-align: center;">Kreserve.com | Phone : 03-42650388 | Email: support@kreserve.com</div></div>
	<p style="color:#fff;">Kreserve.com</p>
	</div>
	</body>
	</html>';

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	$headers .= 'From:Kreserve Notification <reservation@kreserve.com>' . "\r\n";

	// Mail it
	mail($to, $subject, $message, $headers); 

	//send email to the restaurant manager			
	$sql25g="Select * from admin where sendemail='1' and (branch='$branch' or branch='' or branch='hq')"; 
	$result25g = mysql_query($sql25g) or die(mysql_error());
	$to9 ="reservation@kreserve.com";
	while($row25g=mysql_fetch_array($result25g)) {
	$to9 .= ", ".$row25g['email'];
	}
	$mailtitle = "Restaurant Manager <br/>";
	$subject9= "Confirmed Booking from Kreserve Mobile App"; 

	$message9 = '
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>KRESERVE | Book a table in Restaurants in Kuala Lumpur</title>
	<meta name="generator" content="Kohitec R and D Team HTTP://www.kohitec.com">
	<style type="text/css">
	</style>
	</head>
	<body>
	<div class="maindiv" style="max-width:550px;margin: 15px auto ;">
	<div id="head" style="position:relative;background: rgb(153,0,0);width:550px;z-index:0;">
	<img id="back" style="z-index:5;width:90px;" src="http://www.kreserve.com/images/backemails.png">
	<div id="kname" style="font-family:Tahoma, Geneva, sans-serif;font-size:135%;position:relative;padding:0% 0 0 1%;width:25%;color:#fff;font-weight:bold;z-index:4;">KRESERVE</div></div>
	<div id="thankyou" style="position:relative;margin:2% 0 0 22%;text-align:justify;color:#ff9900;font-size:20px;z-index:6;width:291px;height:20px;font-family:Courier New, Courier, monospace;font-weight:bold;"> Dear '.$mailtitle.' You have got one confirmed booking from Kreserve system. Kindly log-in to your Kreserve control panel to view details </div>

	<div id="yourreserve" style="position:relative;margin:2% 0 0 19%;float:left;color:#333;font-size:18px;z-index:6;width:266px;height:20px;
	font-family:Lucida Sans Unicode, Lucida Grande, sans-serif;">Reservation Number is:</div>
	<div id="reservenum" style="position:relative;margin:2.2% 24%  0 0;float:right;overflow:auto;color:#333;font-size:13pt;z-index:5;font-family: Lucida Sans Unicode, Lucida Grande, sans-serif;">'.$reservationno.'</div>

	<table id="rounded-corner" style="font-family: Lucida Sans Unicode,Lucida Grande, Sans-Serif;font-size: 12px;margin: 7% 0% 0% 11%;width: 430px;text-align: left;border-collapse: collapse;position:relative;z-index:5;">	   
		<tfoot>			
		</tfoot>
		<tbody>
		<tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Name:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$userName.'</td>
				</tr>
			<tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Date Of booking:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$date.'</td>
				</tr>
			</tr>
			<tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Check In:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$time1.'</td>
				 </tr>
			<tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Phone Number:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$userPhone.'</td>
			</tr>
			<tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Dining Offer:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$dine.'</td>
			</tr>
			 <tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Number Of Guest(s):</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$guests.'</td>
			</tr>
			 <tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Restaurant:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$restaurant.'</td>			
			</tr>
			 <tr>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">Address:</td>
				<td style="padding: 8px;background: #FF9900;border-top: 1px solid #FFcc66;color: #fff;">'.$address.'</td>
			</tr>
			
		</tbody>
	</table>

	<div id="footer" style="background:#990000;width:550px;height:30px;margin:3.3% 0 0 0">
	<div id="contact" style="color: rgb(255, 255, 255);font-size: 9pt;z-index: 5;font-family:Arial, Helvetica, sans-serif;width: 100%;margin: 1% 0%;text-align: center;">Kreserve.com | Phone : 03-42650388 | Email: support@kreserve.com</div></div>
	<p style="color:#fff;">Kreserve.com</p>
	</div>
	</body>
	</html>';    
	   
	// To send HTML mail, the Content-type header must be set
	$headers9  = 'MIME-Version: 1.0' . "\r\n";
	$headers9 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	$headers9 .= 'From:Kreserve Notification <reservation@kreserve.com>' . "\r\n";
	//$headers9 .= 'Bcc: reservation@kreserve.com' . "\r\n";

	// Mail it
	mail($to9, $subject9, $message9, $headers9);    
	
	//calculate commission of kreserve
	include "../calculatecomission.php"; // This file is calculating the Kreserve commission on a booking and returns the amount. 
	$comission = calculatecomission($totalamount,$restaurant,$dine,$booking,$todaydate1,'0');
	$sql25h = "Update reservation set comission ='$comission'  where uniqueid='$uniqueid'";
	mysql_query($sql25h) or die(mysql_error());	
	
	$output = array('status' => true, 'phone' => $phone, 'date' => $date, 'checkin' => $time1, 'checkout' => $time2, 'address' => $address, 'bookingNo' => $reservationno, 'refNo' => $refNo, 'newPoints' => $totalpoints);
	echo json_encode($output);
	
 }
 
/// This function loads required data for each restaurant page. (it does not include gallery, dining offers and reviews)
function loadEach($branchID){	
	$sql11 = "Select * from branch where id='$branchID'";
	$res11 = mysql_query($sql11) or die(mysql_error());
	$row11 = mysql_fetch_array($res11);
	$branch =$row11['name'];
	$res = $row11['restaurant'];
	$workHour = stripslashes($row11['texttiming']);
	$googleMap = $row11['mapcodes'];
	$address = stripslashes($row11['contacttext']);
	
	$sql11b = "Select * from branch where restaurant='$res' and disablebranch != '1' ORDER BY name ASC";
	$res11b = mysql_query($sql11b) or die(mysql_error());
	$counter = 0;
	$branchArray=array();
	while($row11b = mysql_fetch_array($res11b)){
	array_push($branchArray, $row11b['name']);
	$counter++;		
	}
	
	$sql11c = "Select * from restaurantinfo where restaurant='$res'";
	$res11c = mysql_query($sql11c) or die(mysql_error());
	$row11c = mysql_fetch_array($res11c);
	$rate = $row11c['rate'];
	$major = stripslashes($row11c['major']);
	$minor = stripslashes($row11c['minor']);
	$description = stripslashes($row11c['restaurantinfo']);
	$banner = $row11c['banner'];
	
	$output = array('status' => true, 'res' => $res, 'branch' => $branch, 'workHour' => $workHour, 'googleMap' => $googleMap, 'address' => $address, 'branchListing' => $branchArray, 'counter' => $counter, 'rate' => $rate, 'description' => $description, 'banner' => $banner, 'major' => $major, 'minor' => $minor);
	echo json_encode($output);	
}

//// This function is loading each dining offer data.
function loadDine($res){
	$sql12 = "Select * from restaurantinfo where restaurant='$res'";
	$res12 = mysql_query($sql12) or die(mysql_error());
	$row12 = mysql_fetch_array($res12);
	
	$titleArray=array(stripslashes($row12['eventtitle1']),stripslashes($row12['eventtitle2']),stripslashes($row12['eventtitle3']),stripslashes($row12['eventtitle4']));
	$detailArray=array(stripslashes($row12['eventdetails1']),stripslashes($row12['eventdetails2']),stripslashes($row12['eventdetails3']),stripslashes($row12['eventdetails4']));
	$priceArray=array(stripslashes($row12['price1']),stripslashes($row12['price2']),stripslashes($row12['price3']),stripslashes($row12['price4']));
	$attireArray=array(stripslashes($row12['attire1']),stripslashes($row12['attire2']),stripslashes($row12['attire3']),stripslashes($row12['attire4']));
	
	$sql12b = "Select * from branch where restaurant='$res' and disablebranch != '1' ORDER BY name ASC";
	$res12b = mysql_query($sql12b) or die(mysql_error());	
	$counter = 0;
	$branchArray=array();
	while($row12b = mysql_fetch_array($res12b)){
	array_push($branchArray, $row12b['name']);
	$counter++;		
	}

	$output = array('status' => true, 'branchListing' => $branchArray, 'counter' => $counter, 'title' => $titleArray, 'detail' => $detailArray, 'price' => $priceArray, 'attire' => $attireArray);
	echo json_encode($output);	
}

////this function is determining the number of the branch pictures which we should load in the photo gallery of each restaurant.
function loadGallery($res,$branch){

	$dir = "../images/".$res."/".$branch;
	$files = scandir($dir);
	$x =  count($files);
	$y = $x - 2;

	$output = array('status' => true, 'number' => $y);
	echo json_encode($output);	
}

////////this function is loading reviews about a restaurant in each restaurant page. Ajax 14
function readReviews($res){
	$sql14 = "Select * from reviews where restaurant='$res'";
	$res14 = mysql_query($sql14) or die(mysql_error());
	$titleArray = array();
	$dateArray = array();
	$commentArray = array();
	$counter=0;
	while($row14 = mysql_fetch_array($res14)){
	array_push($titleArray, stripslashes($row14['name']));
	array_push($commentArray, stripslashes($row14['review']));
	array_push($dateArray, $row14['date']);
	$counter++;
	}

	$output = array('status' => true, 'counter' => $counter, 'title' => $titleArray, 'date' =>  $dateArray, 'comment' => $commentArray);
	echo json_encode($output);	
}

////////this function is saving reviews about a restaurant into the database. Ajax 15
function writeReview($name,$email,$res,$comment){
	$today = date("Y/m/d");
	$sql15="INSERT INTO reviews (name, email, replyid, restaurant, review, date, likes, dislike, ip) values ('$name','$email',0,'$res','$comment','$today','0','0','Mobile App')";
	mysql_query($sql15) or die(mysql_error());

	$output = array('status' => true);
	echo json_encode($output);	
}	


////////Checks current user rated this restaurant or not. Ajax Flag 16
function checkRate($res, $branch, $email) {

	$sql16 = "SELECT * FROM rates WHERE email='$email' and branch='$branch' and restaurant='$res'"; ////rate is not depends on branch now. but I added branch in order to support future expansions.
	$query16 = mysql_query($sql16) or die(mysql_error());
	$num16= mysql_num_rows($query16);
	if($num16>0){
		$row16= mysql_fetch_array($query16);
		$output = array('status' => true, 'rate' => $row16['rate']);
	}
	else {
		$output = array('status' => false);
	}
	echo json_encode($output);
}

//////////saves the rates into the database.
function submitRate($res, $branch, $email, $name, $rate, $oldRate) {

	$sql17 = "SELECT * FROM rates WHERE email='$email' and branch='$branch' and restaurant='$res'"; ////rate is not depends on branch now. but I added branch in order to support future expansions.
	$query17 = mysql_query($sql17) or die(mysql_error());
	$num17= mysql_num_rows($query17);
	
	$sql17b = "SELECT * FROM restaurantinfo WHERE restaurant='$res'";
	$query17b = mysql_query($sql17b) or die(mysql_error());
	$row17b = mysql_fetch_array($query17b);
	$totalNumber = $row17b['totalpeople'];
	$currentRate = $row17b['rate'];
	$rateSum = $currentRate * 	$totalNumber;
	if($num17>0){
		$newRate = ((($rateSum - $oldRate) + $rate) / $totalNumber);
		
		$sql17c = "Update rates SET rate='$rate' where email='$email' and branch='$branch' and restaurant='$res'";
		mysql_query($sql17c) or die(mysql_error());
		
		$sql17d = "Update branch SET rate='$newRate' where name='$branch' and restaurant='$res'";
		mysql_query($sql17d) or die(mysql_error());
		
		$sql17e = "Update restaurantinfo SET rate='$newRate' WHERE restaurant='$res'";
		mysql_query($sql17e) or die(mysql_error());
		
	} else{
		$totalNumber++;
		$newRate = (($rateSum + $rate) / $totalNumber);
		$sql17f="INSERT INTO rates (name, email, branch, restaurant) values ('$name','$email','$branch','$res')";
		mysql_query($sql17f) or die(mysql_error());
		
		$sql17d = "Update branch SET rate='$newRate' where name='$branch' and restaurant='$res'";
		mysql_query($sql17d) or die(mysql_error());
		
		$sql17e = "Update restaurantinfo SET rate='$newRate', totalpeople='$totalNumber' WHERE restaurant='$res'";
		mysql_query($sql17e) or die(mysql_error());
	}
	
	$output = array('status' => true);
	echo json_encode($output);
}

////////////////////////////load the blogs in blog pages.
function loadBlog() {

	$sql18 = "SELECT * FROM blog ORDER BY id DESC"; ////rate is not depends on branch now. but I added branch in order to support future expansions.
	$query18 = mysql_query($sql18) or die(mysql_error());
	
	$titleArray = array();
	$picArray = array();
	$briefArray = array();
	$idArray = array();
	$counter=0;
	
	while($row18 = mysql_fetch_array($query18)){
	array_push($titleArray, stripslashes($row18['title']));
	array_push($picArray, $row18['picture']);
	array_push($briefArray, stripslashes($row18['brief']));
	array_push($idArray, $row18['id']);	
	$counter++;
	}

	$output = array('status' => true, 'counter' => $counter, 'title' => $titleArray, 'picture' => $picArray, 'brief' => $briefArray, 'blogID' => $idArray);
	echo json_encode($output);
}

////////////////////////////load the blogs in blog pages.
function loadeachBlog($blogID) {
	$sql19 = "SELECT * FROM blog WHERE id='$blogID'";
	$query19 = mysql_query($sql19) or die(mysql_error());
	$row19 = mysql_fetch_array($query19);
	
	$sql19b = "SELECT * FROM blogcmt WHERE blogid='$blogID' and remoteip='Mobile App'";
	$query19b = mysql_query($sql19b) or die(mysql_error());
	$nameArray = array();
	$dateArray = array();
	$cmtArray = array();
	$counter = 0;
	while($row19b = mysql_fetch_array($query19b)){
		array_push($cmtArray, stripslashes($row19b['comment']));
		array_push($nameArray, stripslashes($row19b['name']));
		array_push($dateArray,  $row19b['date']);
		$counter++;
	}
	
	$output = array('status' => true, 'counter' => $counter, 'title' => $row19["title"], 'picture' => $row19['picture'], 'description' => $row19['description'], 'author' => $row19['author'], 'name' => $nameArray, 'date' => $dateArray, 'comment' => $cmtArray);
	echo json_encode($output);	
}

////////////////////////////load the blogs in blog pages.
function submitBlogComment($blogID,$name,$email,$comment) {
	$today = date("d/m/Y");
	$sql26="INSERT INTO blogcmt (name, email, comment, date, blogid, remoteip) values ('$name','$email','$comment','$today','$blogID','Mobile App')";
	mysql_query($sql26) or die(mysql_error());
	
	$output = array('status' => true);
	echo json_encode($output);	
}
?>