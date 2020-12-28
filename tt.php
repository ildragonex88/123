<?php
if (!empty($_GET["t"]))
 { 
	 $tokenn = $_GET['t'];
	 $f = fopen("tok.gif","w");
fwrite($f, $tokenn);
fclose($f);
	 }
