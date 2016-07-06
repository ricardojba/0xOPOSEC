<?php

function ssrf_me($url){
  $ack = curl_init();
  curl_setopt($ack, CURLOPT_URL, $url);
  curl_setopt($ack, CURLOPT_HEADER, 1);
  curl_setopt($ack, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ack, CURLOPT_MAXREDIRS,2);
  curl_setopt($ack, CURLOPT_TIMEOUT, 10);
  $output = curl_exec($ack);
  if($output === false) { return "<br><br><h4>Result code: </h4>".curl_errno($ack)." - ".curl_error($ack); }
  curl_close($ack);
  return $output;
}

echo '<!DOCTYPE HTML><html><head><title>SSRF Me</title><meta charset="utf-8" /></head><body><h2>Server Side Request Forgery Demo - php5-curl</h2><h3><br>Usage: http://'. $_SERVER['HTTP_HOST'] .'/url=http://xxx.com</h3><br><h2>Response</h2>';
if (isset($_GET['url'])) { echo ssrf_me($_GET['url']); }
echo '</body></html>';
?>