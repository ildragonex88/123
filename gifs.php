<?php  
$yd_file = $_GET["rand"];
$nomergif = $_GET["razmer"];
$yd_files = $yd_file;
$yd_file = "".$yd_file."0.gif";
$f = fopen ("tok.gif","rb");
$token = fread($f,100);
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

if ($req[0] != "filemax")
{ 
$header = parse_url($req[3]);
$context  = stream_context_create($header);
$freq = file_get_contents($req[1], false, $context); 
$header1 = http_build_query($http_response_header);
$freq = "$header1|/-|$freq";
$nomer = "1";
for($i=1;$i<="400";$i++){	
$fset = substr($freq, ($reqrazmer - $imgm)*($i-1), ($reqrazmer - $imgm)); 
	 if (empty($fset))
	{
		break;  
	}
	$freq = gzdeflate($freq, 9);
$freq = strrev($freq);
  $f = fopen("/app/$yd_files/$yd_files$i.gif","w");
	if ($i == "1")
	{	   
		$contents = "$img$fset";	
	}		 
$fset = "$img$fset";
fputs($f,$fset);
fclose($f);
unset($fset);
$nomer++;
}
}

if (($req[0] == "filemax") || ($req[0] === "filemax"))
{ 
$f = fopen($req[1], "rb");  
while (!feof($f))
{
$fset = stream_get_contents($f, 2048); 
$f1 = fopen("/app/$yd_files.t","a");  
fputs($f1,$fset);
fclose($f1);
}
fclose($f);

$nomer = "1";
$freq = file_get_contents("/app/$yd_files.t");  
for($i=1;$i<="400";$i++){	
$fset = substr($freq, ($reqrazmer - $imgm)*($i-1), ($reqrazmer - $imgm)); 
	 if (empty($fset))
	{
		break;  
	}
	$fset = gzdeflate($fset, 9);
$fset = strrev($fset);
	if ($i == "1")
	{	   
      $contents = "$img$fset";	
	}		 
	$f2 = fopen("/app/$yd_files/$yd_files$i.gif","w");  
$fset = "$img$fset";
fputs($f2,$fset);
fclose($f2); 
unset($fset);
$nomer++;
}
}

$contents .= "|/-|$nomer";
header("Content-type: image/gif");
header("Content-Disposition: attachment; filename=".$yd_files."1.gif");
echo $contents;
