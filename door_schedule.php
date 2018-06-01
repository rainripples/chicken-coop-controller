<?php include 'mainfunctions.php';

// get current hour min am/pm
 $currenthour=date("G");
 $currentmin=date("i");


// Initalize db
Database::initialize();
$sql = "use chickencoop";
$result = mysqli_query (Database::$conn, $sql);

// Get open time
$sql = "SELECT TimeHour,TimeMin,AMPM FROM schedule where Action='Open'";
$result = mysqli_query (Database::$conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
  $row = mysqli_fetch_assoc($result);
	$OpenHour=$row["TimeHour"];
	$OpenMin=$row["TimeMin"];
	$OpenAMPM=$row["AMPM"];
  if ($OpenAMPM=="pm") $OpenHour=$OpenHour+ 12;
 	//echo "Hour: " . $row["TimeHour"]. " - Minute: " . $row["TimeMin"]. "<br>";

} else {
  //  echo "0 results";
}

$action="Do nothing";
// Get Close time
$sql = "SELECT TimeHour,TimeMin,AMPM FROM schedule where Action='Close'";
$result = mysqli_query (Database::$conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
  $row = mysqli_fetch_assoc($result);
	$CloseHour=$row["TimeHour"];
	$CloseMin=$row["TimeMin"];
	$CloseAMPM=$row["AMPM"];
  if ($CloseAMPM=="pm") $CloseHour=$CloseHour+ 12;
} else {
  //echo "0 results";
}
// If open time matches then open door and update door Status
if ($OpenHour==$currenthour && $OpenMin==$currentmin) {
  $action='open';
  $x=open_door();

}

if ($OpenHour==$currenthour) {
$diff=$OpenMin-$currentmin;
if ($diff==-1){
  $action='open';
  $x=open_door();

  }
}

// if close time matches then close door
if ($CloseHour==$currenthour && $CloseMin==$currentmin) {
  $action='close';
  $x=close_door();

}

if ($CloseHour==$currenthour) {
  $diff=$CloseMin-$currentmin;
  if ($diff==-1){
    $action='close';
    $x=close_door();
    }
  }


// check if reboot occured ie. the door status is out of sync with the pin

// Get door status
$sql = "SELECT * FROM `codetable` WHERE codekey='doorstatus'";
$result = mysqli_query (Database::$conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
  $row = mysqli_fetch_assoc($result);
	$DoorStatus=$row["CharField1"];
} else {
  //echo "0 results";
}

//get pin Status
$pin17 = system('gpio -g read 17');
if ($pin17==0 && $DoorStatus=='Closed') {
  $x=open_door();
  } elseif ($pin17==1 && $DoorStatus=='Open') {
  $x=close_door();
}
echo '<html>';
echo  '<body>';
echo 'Pin17:'.$pin17.'<br>';
echo 'doorstatus:'.$DoorStatus.'<br>';
echo 'Current hour:'.$currenthour;
echo '   Current min:'.$currentmin.'<br>';
echo 'scheduled open hour:'.$OpenHour;
echo '   scheduled close min:' .$OpenMin.'<br>';
echo 'scheduled close hour:'.$CloseHour;
echo '   scheduled close min:' .$CloseMin.'<br>';
echo "<br>" ;
echo 'Close hour:' .$currenthour.' schedule hour:'.$CloseHour;
echo "<br>" ;
echo 'Open min:'.$currentmin.' scheduler min:' .$OpenMin;
echo "<br>" ;
echo 'Action:'.$action;
echo   '</body>';
echo '</html>';
?>
