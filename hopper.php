<?php
//high error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

//collect apis
require('api/yocto_api.php');
require('api/yocto_humidity.php');
require('api/yocto_temperature.php');
require('api/yocto_pressure.php');


//make db available
$conn = new PDO('mysql:host=localhost;dbname=atmospheric','root','code');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

YAPI::RegisterHub("callback");

$temp = YTemperature::FirstTemperature()->get_currentValue();
if (is_null($temp)){
    die("No temperature sensor found");
}
$press = YPressure::FirstPressure()->get_currentValue();
if (is_null($press)) {
    die("No pressure sensor found");
}
$hum = YHumidity::FirstHumidity()->get_currentValue();
if (is_null($hum)) {
    die("No humidity sensor found");
}
$now = time();

$stm = $conn->prepare("INSERT INTO data(ts, temp_value, hum_value, press_value) VALUES(?, ?, ?, ?)");
$stm->execute(array($now, $temp, $hum, $press));

die("success!");


//DB Schema:
// 1 table: "data", 5 rows:
// id, time, temp_value, hum_value, press_value

?>
