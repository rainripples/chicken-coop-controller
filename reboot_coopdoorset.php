<?php include 'mainfunctions.php';
/*
// get current hour min am/pm
 $currenthour=date("G");
 $currentmin=date("i");
//  echo 'Current hour:'.$currenthour;

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
  //if ($CloseHour=24)$CloseHour=0;
} else {
  //echo "0 results";
}
// If open time matches then open door and update door Status
if ($currenthour > $OpenHour && $currenthour < $CloseHour ) {
  $action='open';
  $x=open_door();
  sleep(30);
}

//if ($currenthour == $CloseHour && $currentmin < $Closemin ) {
//  $action='open';
//  $x=open_door();
//  sleep(30);
//}


//$diff=$OpenMin-$currentmin;
//if ($diff==-1){
//  $action='open';ß
//  $x=open_door();
//  sleep(30);
//  }

// if close time matches then close door
/*if ($currenthour>$CloseHour) {
  $action='close';
  $x=close_door();
  sleep(30);
}

if ($currenthour == $OpenHour && $currentmin < $OpenMin ) {
  $action='close';
  $x=close_door();
  sleep(30);
}

if ($currenthour==$CloseHour && $currentmin>=$CloseMin) {
  $action='close';
  $x=close_door();
  sleep(30);
}*/

/*?>

<html>
  <body>
<?php
  echo 'Current hour:'.$currenthour;
  echo '   Current min:'.$currentmin.'<br>';
  echo 'scheduled open hour:'.$OpenHour;
  echo '   scheduled close min:' .$OpenMin.'<br>';
  echo 'scheduled close hour:'.$CloseHour;
  echo '   scheduled close min:' .$CloseMin.'<br>';

  echo "<br>" ;

  echo 'schedule hour:'.$CloseHour;
      echo '<br>' ;
      echo 'scheduler min:' .$OpenMin;
        echo "<br>" ;
  echo 'Action:'.$action;
?>
  </body>
</html>
*/
?>
