<?php
//high error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

//collect apis
require('api/yocto_api.php');
require('api/yocto_humidity.php');
require('api/yocto_temperature.php');
require('api/yocto_pressure.php');


// Get access to the device, through the VirtualHub running locally
yRegisterHub('http://127.0.0.1:4444/',$errmsg);

include('templates/header.php');

if( $errmsg ){
  echo "<pre>$errmsg</pre>";
}else{
  
  $temp = yFirstTemperature()-> get_currentValue();
  $hum  = yFirstHumidity()-> get_currentValue();
  $pres = yFirstPressure()-> get_currentValue();
}

//make db available
require('db_connect.php');

//get last hour of data (3600s)
$postquem = time() - 3600;
$stm = $conn->query("SELECT * FROM data WHERE ts > $postquem");
$data = $stm->fetchAll(PDO::FETCH_ASSOC);
?>
<script type="text/javascript">
  var data = <?php echo json_encode($data);?>;
</script>

<h1> Atmospheric </h1>

<div class="graph">
  <canvas id="temp_chart"></canvas>
</div>
<div class="graph">
  <canvas id="hum_chart"></canvas>
</div>
<div class="graph">
  <canvas id="press_chart"></canvas>
</div>
<div class="block">
  <h2>Current Temperature</h2>
  <?php echo "$temp C <br>"; ?>
</div>
<div class="block">
  <h2>Current Humidity</h2>
  <?php echo "$hum %RH <br>"; ?>
</div>
<div class="block">
  <h2>Current Pressure</h2>
  <?php echo "$pres mm/hG <br>"; ?>
</div>
<div class="block">
  <h2>Control</h2>
  <ul class="nav">
    <li><a href="actions.php?act=purge">purge database</a></li>
  </ul>
</div>




<?php include('templates/footer.php'); ?>
