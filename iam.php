<?php
$data['time'] = gmdate('l, d-M-Y H:i:s T');
$data['server'] = `hostname -s`;
// $data['serverip'] = `hostname -i`;
$data['serverip'] = gethostbyname($_SERVER['SERVER_NAME']);
$data['serverregion'] = 'AS';
$data['servercountry'] = 'Singapore';
$data['servercountrycode'] = 'SG';
$data['servercity'] = 'Singapore';

$rtt = `ss -it | grep -A1 {$_SERVER['REMOTE_ADDR']}`;
$rtt = explode(PHP_EOL, $rtt);
$rtt = array_map('trim', $rtt);
foreach ($rtt as $k => $v) {
  if (strpos($v, ':http') !== false) {
    $rttLine = str_replace('cubic ', '', $rtt[$k+1]);
    preg_match_all("/(\w+):([\w\s\.\,\/]+[^\w+:])/", $rttLine, $m);
    $rttArr = array_combine($m[1], $m[2]);
    $rttArr['minrtt'] .= substr($rttLine, -2);
    list($rttArr['rtt'], $rttArr['rtt_var']) = explode('/', $rttArr['rtt'], 2);
    break;
  }
}
?>
<html>
  <head>

  </head>
  <body>
    <a href="https://5centscdn.net"><img src="https://cp.5centscdn.net/logo-blacknobg.svg" title="5centsCDN.net" vspace="5" width="10%"/></a>
    <table>
      <tr><td align='left'>GMT date:</td><td align='left'><?php echo $data['time'] ?></td></tr>
      <tr height='15'><td align='left'></tr>
      <tr><td align='left'>Server:</td><td align='left'><?php echo $data['server'] ?> (try <a href="/speedtest">speedtest</a>)</td></tr>
      <tr><td align='left'>Server IP:</td><td align='left'><?php echo $data['serverip'] ?></td></tr>
      <tr><td align='left'>Server Region:</td><td align='left'><?php echo $data['serverregion'] ?></td></tr>
      <tr><td align='left'>Server Country:</td><td align='left'><?php echo $data['servercountry'] ?></td></tr>
      <tr><td align='left'>Server Country code:</td><td align='left'><?php echo $data['servercountrycode'] ?></td></tr>
      <tr><td align='left'>Server City:</td><td align='left'><?php echo $data['servercity'] ?></td></tr>
      <tr height='15'><td align='left'></tr>
      <tr><td align='left'>Client IP:</td><td align='left'><?php echo $_SERVER['REMOTE_ADDR'] ?></td></tr>
      <tr><td align='left'>Client Continent:</td><td align='left'><?php echo $_SERVER['GEOIP_CITY_CONTINENT_CODE'] ?></td></tr>
      <tr><td align='left'>Client Country:</td><td align='left'><?php echo $_SERVER['GEOIP_CITY_COUNTRY_NAME'] ?></td></tr>
      <tr><td align='left'>Client Country code:</td><td align='left'><?php echo $_SERVER['GEOIP_CITY_COUNTRY_CODE'] ?></td></tr>
      <tr><td align='left'>Client City:</td><td align='left'><?php echo $_SERVER['GEOIP_CITY'] ?></td></tr>
      <tr><td align='left'>Client LatLong:</td><td align='left'><?php echo $_SERVER['GEOIP_LATITUDE'].','.$_SERVER['GEOIP_LONGITUDE'] ?></td></tr>
      <tr height='15'><td align='left'></tr>
      <tr><td align='left'>User-agent:</td><td align='left'><?php echo $_SERVER['HTTP_USER_AGENT'] ?></td></tr>
      <tr><td align='left'>TCP rtt:</td><td align='left'><?php echo $rttArr['rtt'] ?> ms</td></tr>
      <tr><td align='left'>TCP rtt-var:</td><td align='left'><?php echo $rttArr['rtt_var'] ?> ms</td></tr>
      <tr><td align='left'>TCP cwnd:</td><td align='left'><?php echo $rttArr['cwnd'] ?> segments</td></tr>
      <tr><td align='left'>TCP rcv-space:</td><td align='left'><?php echo $rttArr['rcv_space'] ?> bytes</td></tr>
    </table>
  </body>
</html>