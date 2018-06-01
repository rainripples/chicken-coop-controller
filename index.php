<?php include 'mainfunctions.php'; ?>

<html>
 <head>
<meta http-equiv="refresh" content="10">
<meta name="viewport" content="width=device-width" />
 <title>Chicken Coop Controller</title>
    <style>
    body {
      background-color: lightblue;
    }
    div {
    margin: 70px;

    }
    table, th, td {
    border: 1px solid black;
    }
  </style>
 </head>

 <body>
 <b>Chicken Coop Dashboard</b> <br>
<?php
echo '<br>';

Database::initialize();
$sql = "use chickencoop";
$result = mysqli_query (Database::$conn, $sql);

// update Schedule open time if set
if(isset($_POST['OpenHour']))
	{
  $OpenHour=$_POST['OpenHour'];
  $OpenMin=$_POST['OpenMin'];
  $OpenAMPM=$_POST['OpenAMPM'];

  $sql = "UPDATE schedule set TimeHour='".$OpenHour."', TimeMin='".$OpenMin."',AMPM='".$OpenAMPM."' where Action='Open'";
  //echo $sql;
  $result = mysqli_query (Database::$conn, $sql);
	echo "<BR>Schedule updated";
  # code to write status
	}

  // update Schedule close time if set
  if(isset($_POST['CloseHour']))
  	{
  $CloseHour=$_POST['CloseHour'];
  $CloseMin=$_POST['CloseMin'];
  $CloseAMPM=$_POST['CloseAMPM'];

  $sql = "UPDATE schedule set TimeHour='".$CloseHour."', TimeMin='".$CloseMin."',AMPM='".$CloseAMPM."' where Action='Close'";
  //echo $sql;
$result = mysqli_query (Database::$conn, $sql);
  	//echo "<BR>Schedule close updated";
          # code to write status
  	}
// Get open time
$sql = "SELECT TimeHour,TimeMin,AMPM FROM schedule where Action='Open'";
$result = mysqli_query (Database::$conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
  $row = mysqli_fetch_assoc($result);
	$OpenHour=$row["TimeHour"];
	$OpenMin=$row["TimeMin"];
	$OpenAMPM=$row["AMPM"];
 	//echo "Hour: " . $row["TimeHour"]. " - Minute: " . $row["TimeMin"]. "<br>";

} else {
    echo "0 results";
}

// Get Close time
$sql = "SELECT TimeHour,TimeMin,AMPM FROM schedule where Action='Close'";
$result = mysqli_query (Database::$conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
        $row = mysqli_fetch_assoc($result);
	$CloseHour=$row["TimeHour"];
	$CloseMin=$row["TimeMin"];
	$CloseAMPM=$row["AMPM"];
} else {
    echo "0 results";
}

# code to read status


if(isset($_POST['open']))
	{
    $chk=open_door();
  } else if(isset($_POST['close'])){
    $chk=close_door();
  }

// Get door status
$sql = "SELECT CharField1 FROM codetable where CodeKey='doorstatus'";
//echo $sql;
$result = mysqli_query (Database::$conn, $sql);
$row = mysqli_fetch_assoc($result);
$DoorStatus=$row["CharField1"];
?>
<br>
<?php
$uptime=uptime();
echo '<table>';
echo '<tr><td><b>Server uptime:</b></td><td>'.$uptime.'</td></tr>';
echo '<tr><td><b>Time:</b></td><td>'.date('h:i:sa').'</td></tr>';
echo '<tr><td><b>Door Status:</b></td><td>';
echo $DoorStatus.'</td></tr>';
echo '</table>';
?>
<br>
<form method="post" action="index.php">
                 <input type="submit" value="Open Door" name="open">
                 <input type="submit" value="Close Door" name="close">
</form>

<form method="post" action="index.php">

<!--Use Sun rise/Sun Set for door open close time ?
<input type="radio" name="sun" value="no">No
<input type="radio" name="sun" value="yes">Yes
<br>
<a href="sunrisesunset.php">Setup sun rise and set times</a>
<br><br>-->

Door open time - Hour:

<select style="width:45px;" name="OpenHour" id="OpenHour">
<?php

	for($i =0;$i<=12;$i+=1){
		if ($OpenHour==$i) {
			echo '<option value="'.$i.'" selected>'.$i.'</option>';
		}else {
			echo '<option value="'.$i.'">'.$i.'</option>';
	}
    }
?>
</select>

Minute:
<select style="width:45px;" name="OpenMin" id="OpenMin">
<?php
$pad_length=2;
$pad_char="0";
for($i =0;$i<=59;$i+=1){
  if ($OpenMin==$i) {
		echo '<option value="'.str_pad($i, $pad_length, $pad_char, STR_PAD_LEFT).'"selected>'.str_pad($i, $pad_length, $pad_char, STR_PAD_LEFT).'</option>';
	}else {
		echo '<option value="'.str_pad($i, $pad_length, $pad_char, STR_PAD_LEFT).'">'.str_pad($i, $pad_length, $pad_char, STR_PAD_LEFT).'</option>';
	}
}
?>
</select>

<select style="width:48px;" name="OpenAMPM" id="OpenAMPM">
<?php
	if ($OpenAMPM=="am"){
		echo '<option value="am" selected>am</option>';
		echo '<option value="pm">pm</option>';
		}
		if ($OpenAMPM=="pm"){
   			echo '<option value="am">am</option>';
			echo '<option value="pm" selected>pm</option>';
		}


?>
</select>


<br>
Door close time - Hour:

<select style="width:45px;" name="CloseHour" id="CloseHour">
<?php

	for($i =0;$i<=12;$i+=1){
		if ($CloseHour==$i) {
			echo '<option value="'.$i.'" selected>'.$i.'</option>';
		}else {
			echo '<option value="'.$i.'">'.$i.'</option>';
	}
    }
?>
</select>

Minute:
<select style="width:45px;" name="CloseMin" id="CloseMin">
<?php
$pad_length=2;
$pad_char="0";

for($i =0;$i<=59;$i+=1){
  if ($CloseMin==$i) {
		echo '<option value="'.str_pad($i, $pad_length, $pad_char, STR_PAD_LEFT).'" selected>'.str_pad($i, $pad_length, $pad_char, STR_PAD_LEFT).'</option>';
	}else {
	echo '<option value="'.str_pad($i, $pad_length, $pad_char, STR_PAD_LEFT).'">'.str_pad($i, $pad_length, $pad_char, STR_PAD_LEFT).'</option>';
	//echo '<option value="'.$i.'">'.$i.'</option>';
	}
}
?>
</select>

<select style="width:48px;" name="CloseAMPM" id="CloseAMPM">
<?php
	if ($CloseAMPM=="am"){
		echo '<option value="am" selected>am</option>';
		echo '<option value="pm">pm</option>';
		}
	if ($CloseAMPM=="pm"){
   			echo '<option value="am">am</option>';
			echo '<option value="pm" selected>pm</option>';
		}
?>

</select>
<br><br>
	<input type="submit" value="Apply Changes" name="Apply Changes">
</form>

<table>

<?php
$sql = "SELECT action,actiontime FROM history  order by actiontime DESC LIMIT 10";
$result = mysqli_query (Database::$conn, $sql);

// Header row
echo '<tr>  <th colspan="2">History Log</th></tr>';
echo '<tr>';
  echo '<th> Time </th>';
  echo '<th> Action </th>';
echo '</tr>';

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
          echo '<td>'.$row["actiontime"].'</td>';
          echo '<td>'.$row["action"].'</td>';
        echo '</tr>';
    }
} else {
    echo "0 results";
}

?>
</table>
         </body>
 </html>

<?php
mysqli_close(Database::$conn);
?>
