<?php
 include 'mainfunctions.php';
 $addresserror="";

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if(isset($_POST['Street'])) $Street=test_input($_POST['Street']);
   if(isset($_POST['City'])) $City=test_input($_POST['City']);
   if(isset($_POST['State'])) $State=test_input($_POST['State']);
   if(isset($_POST['Country'])) $Country=test_input($_POST['Country']);


   $url='https://maps.googleapis.com/maps/api/geocode/json?address='
   .urlencode($Street).'+'
   .urlencode($City).'+'
   .urlencode($Country).
   '&key=AIzaSyA5uUKi9R401yiX94NPa7Vz9rpvbpmkhpI';

   echo 'Address:'.urlencode($Street).'+'.urlencode($City).'+'.urlencode($Country);
   echo '<br />';
   $geoloc = file_get_contents($url);
   //$result=file_get_contents($url);
   $response=json_decode($geoloc);
   if ($response->status == 'OK') {
       $latitude = $response->results[0]->geometry->location->lat;
       $longitude = $response->results[0]->geometry->location->lng;
       echo 'Latitude: ' . $latitude;
       echo '<br />';
       echo 'Longitude: ' . $longitude;
       echo '<br />';
   } else {
       //echo $response->status;
       $addresserror = "Address / location not found.<br>";
   }
   if ($addresserror=="") {
     Database::initialize();
     $sql = "use chickencoop";
     $result = mysqli_query (Database::$conn, $sql);

     $sql="delete from sunrisesunset";
     $result = mysqli_query (Database::$conn, $sql);
     echo '<table style="width:100%">';
     echo '<tr>';
     echo '<th>Date</th>';
     echo '<th>Sunrise</th>';
     echo '<th>Sunset</th>';
     echo '</tr>';

     $date = '2018-01-01';
     while ($date <= '2018-01-03')
     {
       $sunarray = GetSunRiseSunSetLocal($latitude,$longitude,$date);
       $sunriselocal = $sunarray[0];
       $sunsetlocal = $sunarray[1];
       //add to database
       $sql="INSERT INTO `sunrisesunset`(`Date`, `Sunrise`, `Sunset`) VALUES ('".$date."','".$sunriselocal."','".$sunsetlocal."')";
       $result = mysqli_query (Database::$conn, $sql);
       echo'<div>';
       echo '<tr>';
       echo '<td>'.$date.'</td>';
       echo '<td>'.$sunriselocal. '</td>';
       echo '<td>'.$sunsetlocal. '</td>';
       echo '</tr>';
       $result = mysqli_query (Database::$conn, $sql);
       $date = date('Y-m-d', strtotime($date . ' +1 day'));
     echo '</div>';
     }
     echo '</table>';
   }
 }
 ?>


<!DOCTYPE html>
<html>
<style>
input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}


table {
    width:100%;
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 15px;
    text-align: left;
}

.error {color: #FF0000;}

#map {
       height: 100%;
     }
     /* Optional: Makes the sample page fill the window. */
     html, body {
       height: 100%;
       margin: 0;
       padding: 0;
     }
</style>
<body>

<h2>Setup SunRise and SunSet times</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <span class="error">* <?php echo $addresserror;?></span>
    <label for="Stname">Street:</label>
    <input type="text" id="Stname" name="Street" placeholder="Your street number and name">


    <label for="Ctyname">City:</label>
    <input type="text" id="Ctyname" name="City" placeholder="City..">

    <label for="Statename">State:</label>
    <input type="text" id="Statename" name="State" placeholder="State..">

    <label for="CtryName">Country:</label>
    <input type="text" id="CtryName" name="Country" placeholder="Country..">

    </select>

    <input type="submit" value="Submit">
  </form>
</div>

</body>
</html>
