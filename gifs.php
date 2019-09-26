<?php  
$yd_file = $_GET["rand"];
$nomergif = $_GET["razmer"];
$yd_files = "$yd_file";
$yd_file = "$yd_file.gif";
$path = __DIR__; 
 $f   = fopen ("tok.gif","rb");
$token = fread($f,100000);
fclose($f);
$ch = curl_init('https://cloud-api.yandex.net/v1/disk/resources/download?path=' . urlencode($yd_file));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $token));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$res = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($http_code == 201) {
       // echo 'Файл успешно загружен  с жд';
    }
$res = explode(':"', $res);
$freq = str_replace('https:','http:',$res[1]);
$freq = file_get_contents($freq);
$f = fopen("$yd_file","w");
fwrite($f,$freq);
fclose($f);

$f   = fopen ("$yd_file","rb");
$req = fread($f,filesize($yd_file));
fclose($f);  
$req1=$req;
$req  = substr($req, $nomergif);

$img  = substr($req1, 0, $nomergif);
$imgm = strlen($img);
$req = base64_decode($req);
 $req = explode("||",$req);	
$reqrazmer = $req[4];
$optspost = array('http' =>
    array(
        'method'  => 'POST',
	     'content' => $req[1],
		  'user-agent'=> 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36',
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n" .
		  "Cookie:".$req[2]."\r\n"               
    )
); 
$optsget = array('http' =>
    array(
        'method'  => "GET",
		 'user-agent'=> 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36',
          'header'    => "Accept-language: en\r\n" . 
		                    "Cookie: ".$req[2]."r\n"
						   ) 
						   
);





if ($req[0] == "post")
{ 
$context  = stream_context_create($optspost);
	$freq = file_get_contents($req[3], false, $context);
	$freq = "$cookies1||$freq";
	$cookies = array();
foreach ($http_response_header as $hdr) {
    if (preg_match('/^Set-Cookie:\s*([^;]+)/', $hdr, $matches)) {
        parse_str($matches[1], $tmp);
        $cookies += $tmp;
		
    }
}

$cookies1 = print_r($cookies,true);
mkdir("/app/$yd_files");
}




if ($req[0] == "get")
{
	$context  = stream_context_create($optsget);
	$freq = file_get_contents($req[3], false, $context);
	//$context  = stream_context_create($optsget);
	$freq = "$cookies1||$freq";
	$cookies = array();
foreach ($http_response_header as $hdr) {
    if (preg_match('/^Set-Cookie:\s*([^;]+)/', $hdr, $matches)) {
        parse_str($matches[1], $tmp);
        $cookies += $tmp;
		
    }
}

$cookies1 = print_r($cookies,true);
mkdir("/app/$yd_files");
}



if ($req[0] == "file")
{ 
$freq = file_get_contents($req[3]);
 mkdir("/app/$yd_files");
}
if ($req[0] == "filemax")
{ 
function download($file_source, $file_target) {
    $rh = fopen($file_source, 'rb');
    $wh = fopen($file_target, 'w');
    if (!$rh || !$wh) {
        return false;
    }
    while (!feof($rh)) {
        if (fwrite($wh, fread($rh, 4096)) === FALSE) {
            return false;
        }
         
        flush();
    }
    fclose($rh);
    fclose($wh);
   
}
mkdir("/app/$yd_files");
  $result = download($req[3],"/app/$yd_files/prosto.zz");
$f1   = fopen ("/app/$yd_files/prosto.zz","rb");
$freq = fread($f1,filesize($f1));
 fclose($f1);
 }

 

 
 




 
 
$nomer ="0";
$freq = base64_encode( $freq);
for($i=1;$i<="100";$i++){
	 
 
	 
$fset = substr($freq, ($reqrazmer - $imgm)*($i-1), ($reqrazmer - $imgm));
	 
		
	 
	   $fset = strrev($fset);
  $f = fopen("/app/$yd_files/$i.gif","a");
	 
	 if (empty($fset))
	{
		break;
	}
	    
	$fset = "$img$fset";
fputs($f,$fset);
fclose($f); 
	
	$nomer++;
}
$contents = "$img$nomer";
header("Content-type: image/gif");
header("Content-Disposition: attachment; filename=$yd_file(1)");
echo($contents);
 
