<?php
class Database
{
    /** TRUE if static variables have been initialized. FALSE otherwise
    */
    Private static $init = FALSE;

    /** The mysqli connection object
    */
    public static $conn;
    /** initializes the static class variables. Only runs initialization once.
    * does not return anything.
    */
    public static function initialize()
    {
      $servername = "localhost";
      $username = "root";
      $password = "yourpassword";
      $dbname = "chickencoop";
      if (self::$init===TRUE)return;
      self::$init = TRUE;
      self::$conn = new mysqli($servername, $username, $password, $dbname);
    }
}

function GetLocalTime($utcdatein) {
  $utcdateobj = new DateTime($utcdatein);
  $utcdateymdhis=$utcdateobj->format('Y-m-d H:i:s'); # read format from date() function
  $dateunix = strtotime($utcdateymdhis);
  //echo ' unix ' . $dateunix.'<br />';
  $utc_offset =  date('Z');
  $localdateunix=$dateunix+$utc_offset;
  $localdate = date("Y-m-d H:i:s", $localdateunix);
  return $localdate;
}
function GetSunRiseSunSetLocal($latitude,$longitude,$datein) {
  // call sunrise / sunset api
  $url='https://api.sunrise-sunset.org/json?lat='.$latitude.'&lng='.$longitude.'&formatted=0&date='.$datein;
  $suninfo = file_get_contents($url);
  //echo 'url:'.$url;
  $response=json_decode($suninfo);
  if ($response->status == 'OK') {
    //  $sunriseutc=  $response->{0};
    //  $sunsetutc=  $response->{'sunset'};
    $sunriseutc= $response->results->sunrise;
    $sunsetutc= $response->results->sunset;
    $sunriselocal=GetLocalTime($sunriseutc);
    $sunsetlocal=GetLocalTime($sunsetutc);
//    echo 'SunRiselocal  ' . $sunriselocal.'<br />';
//    echo '<br />';
//    echo 'SunSet: ' .$sunsetutc;
    return array($sunriselocal,$sunsetlocal);
    } else {
      echo $response->status;
    }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function write_history ($historyaction, $actiontimestamp){
  $sql= "INSERT INTO history (Action, ActionTime) VALUES ('".$historyaction."','".$actiontimestamp."')";
//echo $historyaction."-".$sql;
  $result = mysqli_query (Database::$conn, $sql);
}
function open_door(){
  system ("gpio -g mode 17 out");
  system ( "gpio -g write 17 0");
  //echo "Door is Open";
  $now = date('Y-m-d G:i:s');
  $sql = "UPDATE codetable set Date1='".$now."', CharField1='Open' where CodeKey='doorstatus'";
  $result = mysqli_query (Database::$conn, $sql);
  $x=write_history("Door open",$now);
  sleep(30);
}

function close_door(){
  system ("gpio -g mode 17 out");
  system ( "gpio -g write 17 1");
  //echo "Door is closed";
  $now = date('Y-m-d G:i:s');
  $sql = "UPDATE codetable set Date1='".$now."', CharField1='Closed' where CodeKey='doorstatus'";
  $result = mysqli_query (Database::$conn, $sql);
  $x=write_history("Door close",$now);
    sleep(30);
}

function uptime(){

  $data = shell_exec('uptime');
  $uptime = explode(' up ', $data);
  $uptime = explode(',', $uptime[1]);
  $uptime = $uptime[0].', '.$uptime[1];

  //echo ('Current server uptime: '.$uptime.);
return $uptime;
}
?>
