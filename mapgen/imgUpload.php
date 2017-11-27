<?php
	$url = $_POST['url'];
	$fileName = $_POST['name'];
	$filePath = 'mapimgs/'.$fileName.'.png';
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	$img = curl_exec($curl);
	curl_close($curl);
	file_put_contents($filePath, $img);
	print_r('ok');
?>