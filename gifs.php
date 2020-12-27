<?php  
$yd_file = $_GET["rand"];
$nomergif = $_GET["razmer"];

$yd_files = $yd_file;

$yd_file = "".$yd_file."0.gif";

$f = fopen ("tok.gif","rb");
$token = fread($f,1000);
fclose($f);

  if (empty($token))
	 {
$contents = "";
 header("Content-type: image/gif");
 header("Content-Disposition: attachment; filename=".$yd_files."1.gif");
 echo($contents);
exit;
	 }	
	 
$ch = curl_init('https://cloud-api.yandex.net/v1/disk/resources/download?path=' . urlencode($yd_file));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $token));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$req = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$req = explode(':"', $req);
$req = str_replace('https:','http:',$req[1]);
$req = file_get_contents($req);

$img  = substr($req, 0, $nomergif);
$req  = substr($req, $nomergif);

$imgm = strlen($img);


 


$req = strrev($req);
$req = gzinflate($req);
$req = explode("|/-|",$req);	

$reqrazmer = $req[2];
  
 
mkdir("/app/$yd_files");
 
 
if (($req[0] == "POST") || ($req[0] == "GET"))
{ 
$header = parse_url($req[3]);
$context  = stream_context_create($header);
$freq = file_get_contents($req[1], false, $context); 
$freqtest = $freq;
$header1 = http_build_query($http_response_header);
$freq = "$header1|/-|$freq";
$freq = gzdeflate($freq, 9);
$freq = strrev($freq);

$ft = fopen("/app/$yd_files.txt","w");
fputs($ft,$freqtest);
fclose($ft);

$nomer = "1";
 
for($i=1;$i<="200";$i++){	
$fset = substr($freq, ($reqrazmer - $imgm)*($i-1), ($reqrazmer - $imgm)); 
	 if (empty($fset))
	{
		break;  
	}
  $f = fopen("/app/$yd_files/$yd_files$i.gif","a");
	if ($i == "1")
	{	   
		$contents = "$img$fset";	
	}		 
$fset = "$img$fset";
fputs($f,$fset);
fclose($f); 
	$nomer++;
}
}

if ($req[0] == "filemax")
{ 
   $f = fopen($req[1], "rb");
   $i = 1;
   $nomer = 1;
while (!feof($f)) {
	
$fset = fread($f, $reqrazmer - $imgm); 
$fset = gzdeflate($fset, 9);
$fset = strrev($fset);

$f1 = fopen("/app/$yd_files/$yd_files$i.gif","a");
 
if ($i == "1")
	{	   
		$contents = "$img$fset";	
	}		
	 
$fset = "$img$fset";	
fputs($f1,$fset);
fclose($f1);
$i++;
 $nomer++;
}
fclose($f);
}

 
$contents .= "|/-|$nomer";
header("Content-type: image/gif");
header("Content-Disposition: attachment; filename=".$yd_files."1.gif");
echo($contents);
