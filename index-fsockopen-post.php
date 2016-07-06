<?php

function GetFile($host,$port,$data) {
  $fp = fsockopen($host, intval($port), $errno, $errstr, 30);
  if (!$fp) {
    echo "$errstr (error number $errno) \n";
  } else {
    #$out = $data;
    $out = "GET $data HTTP/1.1\r\n";
    $out .= "Host: $host\r\n";
    $out .= "Connection: Close\r\n\r\n";
    $out .= "\r\n";
    fwrite($fp, $out);
    $contents="";
    while (!feof($fp)) { $contents .= fgets($fp, 1024); }
    fclose($fp);
    return $contents;
  }
}
echo '<!DOCTYPE HTML><html><head><title>SSRF Me</title><meta charset="utf-8" /></head><body><h2>Server Side Request Forgery Demo - fsockopen()</h2>
<form method="post" id="ssrf_data" name="ssrf_data" action="'.htmlentities($_SERVER['PHP_SELF']).'">
<h3>HOST:</h3><input name="host" id="host" size="100" style="width:500px" type="text">
<h3>PORT:</h3><input name="port" id="port" size="100" style="width:100px" type="text">
<h3>URL:</h3><input name="data" id="data" size="100" style="width:500px" type="text">
<br><br><input value="Go" type="submit" style="height:50px; width:100px"></form><br><h3>Response:</h3>';
if ( isset($_POST['host']) && isset($_POST['port']) && isset($_POST['data']) ) {
  echo GetFile($_POST['host'],$_POST['port'],$_POST['data']);
}
echo '</body></html>';
?>