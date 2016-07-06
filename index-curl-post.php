<?php

function ssrf_me($url, $data){
  $ack = curl_init();
  curl_setopt($ack, CURLOPT_URL, $url);
  curl_setopt($ack, CURLOPT_POST, count($data));
  curl_setopt($ack, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ack, CURLOPT_HEADER, 1);
  curl_setopt($ack, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ack, CURLOPT_MAXREDIRS,2);
  curl_setopt($ack, CURLOPT_TIMEOUT, 10);
  $output = curl_exec($ack);
  if($output === false) { return "<br><br><h4>Result code: </h4>".curl_errno($ack)." - ".curl_error($ack); }
  curl_close($ack);
  return $output;
}

echo '<!DOCTYPE HTML><html><head><title>SSRF Me</title><meta charset="utf-8" /></head><body><h2>Server Side Request Forgery Demo - php5-curl</h2>
<form method="post" id="ssrf_data" name="ssrf_data" action="'.htmlentities($_SERVER['PHP_SELF']).'">
<h3>URL:</h3><input name="url" id="url" style="width:700px" type="text">
<h3>Data:</h3><textarea id="data" form="ssrf_data" rows="10" style="width:700px" name="data"></textarea>
<br><br><input value="Go" type="submit" style="height:50px; width:100px"></form><br><h3>Response:</h3>';

if (isset($_POST['url'])) {
  if (isset($_POST['data'])) {
     $ssrf_data = [ 'ssrf_data' => $_POST['data'] ];
  } else {$ssrf_data = ""; }
  echo ssrf_me($_POST['url'], $ssrf_data);
}
echo '</body></html>';
?>