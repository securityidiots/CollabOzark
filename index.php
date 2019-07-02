<?php
//Check if the directory with the name already exists
if (!is_dir('mmMiJS0n1q')) {
//Create our directory if it does not exist
mkdir('mmMiJS0n1q');
}

//Clearing up the logs if DELETE Type request is found.
if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    $files = scandir('./mmMiJS0n1q/');
    foreach($files as $file) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;
        unlink("mmMiJS0n1q/".$file);
    }
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>C0ll4bOz4rk</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="Bootstrap expanding rows example." />
        <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
        <!--[if lt IE 9]>
          <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="apple-touch-icon" href="/bootstrap/img/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/bootstrap/img/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/bootstrap/img/apple-touch-icon-114x114.png">
        <!-- CSS code from Bootply.com editor -->
        <style type="text/css">
        </style>
    </head>
    <body >
            <div class="col-lg-6" style="width:100%;">
        	  <div class="panel panel-default">
            <div class="panel-heading"><h3>CollabOzark External Resource Access Logs Panel - Securityidiots</h3></div>
            <div class="panel-body">
<table class="table table-condensed" style="border-collapse:collapse;">
    <thead>
        <tr><th>&nbsp;</th>
            <th>Type</th>
            <th>IP</th>
            <th>Domain/Path/Email</th>
            <th>Time</th>
            <th>IP Organisation</th>
        </tr>
    </thead>
    <tbody>
<?php
//You can set your Own TIME ZONE over here
date_default_timezone_set('Asia/Kolkata');

//Function for time based comparison for usort.
function cmp($a, $b) {
  if(!isset($a['time']))
    return 0;
  if ($a['time'] == $b['time']) {
    return 0;
  }
  return ($a['time'] > $b['time']) ? -1 : 1;
}

//JSON Array to collect all data
$json_data[]=array();

//Collecting all the files under mmMiJS0n1q to fetch the data
$files = scandir('./mmMiJS0n1q/');
if(!empty($files))
foreach($files as $file) {
    if ('.' === $file) continue;
    if ('..' === $file) continue;
    $json = json_decode(file_get_contents("mmMiJS0n1q/".$file),true);
    foreach($json as $valjson){
        //var_dump($valjson);
        //echo "<br><br>";
        if(!empty($valjson))
            $json_data[] = $valjson;
    }
}

//Collecting BURP Polling results (UPDATE YOUR biid here)
$file_data = file_get_contents('http://polling.burpcollaborator.net/burpresults?biid=YOUR_TOKEN_HERE');

//Extracting IP details using iplocate API
if($file_data != "{}"){
    $json_new = json_decode($file_data,true);;
    $js_array = array();
    foreach($json_new['responses'] as $valjson){
        $valjson['interactionString'] = file_get_contents('https://www.iplocate.io/api/lookup/'.htmlentities($valjson['client']));
        if(!empty($valjson))
            $js_array[] = $valjson;
    }
    uasort($js_array, 'cmp');
    file_put_contents('mmMiJS0n1q/'.time().'.json', json_encode($js_array));
    foreach($json_data as $valjson){
        if(!empty($valjson))
            $js_array[]=$valjson;
    }
    $json_data = $js_array;
    }elseif(empty($json_data)){
        exit();
    }

//Time based Sorting the gathered data
uasort($json_data, 'cmp');

$i=0;
//presenting the complete data.
foreach($json_data as $value){
        if(empty($value)) continue;
        $request = '';
        $path = '';
        $ip_details = $value['interactionString'];
        $array_ip_details = json_decode($ip_details,true);
        if($value['protocol']=='http' || $value['protocol']=='https' ){
                $request = base64_decode($value['data']['request']);
                $path = explode(" ",$request);
                $path = $path[1];
                $expand_data = '<p>'.nl2br(htmlentities($request)).'</p>';
        }elseif($value['protocol']=='smtp' || $value['protocol']=='dns'){
                $expand_data = '<table class="table table-bordered" style="width:30%;">
                  <tr ><td><b>Organisation</b></td><td>'.$array_ip_details['org'].'</td></tr>
                  <tr ><td><b>Country</b></td><td>'.$array_ip_details['country'].'</td></tr>
                  '.($array_ip_details['city']!=NULL ? '<tr><td><b>City</b></td><td>'.$array_ip_details['city'].'</td></tr>':'').'
                  '.($array_ip_details['time_zone']!=NULL ? '<tr><td><b>Time Zone</b></td><td>'.$array_ip_details['time_zone'].'</td></tr>':'').'
                  '.($array_ip_details['postal_code'] != NULL ? '<tr ><td><b>Postal Code</b></td><td>'.$array_ip_details['postal_code'].'</td></tr>':'').'
                  <tr ><td><b>ASN</b></td><td><a href="https://ipinfo.io/'.$array_ip_details['asn'].'" target="_blank">'.$array_ip_details['asn'].'</a></td></tr>
                  '.($array_ip_details['subdivision']!=NULL?'<tr ><td><b>Subdivision 1</b></td><td>'.$array_ip_details['subdivision'].'</td></tr>':'').'
                  '.($array_ip_details['subdivision2']!=NULL?'<tr ><td><b>Subdivision 2</b></td><td>'.$array_ip_details['subdivision2'].'</td></tr>':'').'
                  <tr ><td><b>Map</b></td><td><a href="http://maps.google.com/?q='.$array_ip_details['latitude'].','.$array_ip_details['longitude'].'" target="_Blank">'.$array_ip_details['latitude'].','.$array_ip_details['longitude'].'</a></td></tr>';
                  if($value['protocol']=='smtp'){
                    $path = base64_decode($value['data']['sender']);
                      foreach($value['data']['recipients'] as $rcpt){
                          $expand_data .= '<tr ><td><b>Receipts</b></td><td>'.htmlentities(base64_decode($rcpt)).'</td></tr>';
                      }
                  }else{
                      $path = $value['data']['subDomain'];
                  }
                 	$expand_data .= '</table>';
        }
        $column = '<tr data-toggle="collapse" data-target="#demo'.++$i.'" class="accordion-toggle" bgcolor='.(strpos( htmlentities($value['protocol']), 'http' ) !== false ? '"#E5FFCC"' : (htmlentities($value['protocol']) === 'dns'? '"lavender"' : '"#FB9A8D"')).'>
                  <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
            <td width="100">'.htmlentities($value['protocol']).'</td>
            <td width="150">'.htmlentities($value['client']).'</td>
            <td>'.htmlentities($path).'</td>
            <td>'.htmlentities(date('jS F Y h:i:s A (T)',substr_replace($value['time'] ,"", -3))).'</td>
            <td>'.$array_ip_details['org'].'</td>
        </tr>
        <tr>
            <td colspan="12" class="hiddenRow"><div class="accordian-body collapse" id="demo'.$i.'">
              '.$expand_data.'
              </div></td>
        </tr>';
        echo $column."\n";
}

?>
</tbody>
</table>
        </div>
  <center><a href="/" onclick='sendDelete(event)'><button  class="btn btn-danger">Clear Logs</button></a></center>
<br>
      </div>

  </div>
</div>
    <script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type='text/javascript' src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
   <script>
    function sendDelete(event){
        var xhttp = new XMLHttpRequest();
        event.preventDefault();
        xhttp.open("DELETE", "./index.php", true);
        xhttp.send();
        window.location.replace("./");
    }
   </script>
    <!-- JavaScript Reloader
    <script>
    setTimeout(function() {
      location.reload();
    }, 10000);
    </script>
       -->
</body>
</html>
