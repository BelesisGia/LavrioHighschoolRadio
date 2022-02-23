<?php 
	header('Content-Type: application/json; charset=utf-8');	
	include('utils.php');

	$ip = 'http://78.129.229.122:28014/7.html';

	$opts = array('http'=>array(
				'method'=>'GET',
				'header'=>'User-Agent: Mozilla/5.0'
			));

	$html = file_get_contents($ip,false,stream_context_create($opts));

	if ($html === false){
		$response = new Response(500,'Internal Error!',null);
		$response->send();
	}
	
	$pattern = "~<body>(?'listeners'\d+),(?'status'\d+),(?'listenerPeak'\d+),(?'maxListeners'\d+),(?'uniqueListeners'\d+),(?'bitrate'\d+),(?'song'.*)<\/body>~";
	preg_match($pattern, $html,$captures);

	if (count($captures) == 0){
		$response = new Response(500,'Internal Error!',null);
		$response->send();
	}

	$data['status'] = $captures['status'];
	$data['listeners'] = $captures['listeners'];
	$data['listenerPeak'] = $captures['listenerPeak'];
	$data['maxListeners'] = $captures['maxListeners'];
	$data['uniqueListeners'] = $captures['uniqueListeners'];
	$data['bitrate'] = $captures['bitrate'];
	$data['song'] = $captures['song'];

	$response = new Response(200,'success',$data);
	$response->send();
 ?>