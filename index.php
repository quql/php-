<?php
// 你的 APPID AK SK
const APP_ID = '14486893';
const API_KEY = 'mMfhh8WgHPpNKbQk8Ufg4sWc';
const SECRET_KEY = '22S21FXIaQfMTFICsgoSKxF1eqGavPsg ';
session_start();
$filename = 'audio.mp3';
if(empty($_SESSION['post'])){
	// ob_flush();
 //    flush();
 //    ob_clean(); //不太懂ob_clean的作用
	if($_POST&&$_POST['speak']){
		$_SESSION['post']=1;
		require_once 'AipSpeech.php';
		

		$client = new AipSpeech(APP_ID, API_KEY, SECRET_KEY);

		$result = $client->synthesis($_POST['speak'], 'zh', 1, array(
		    'vol' => 5,
		));

		// 识别正确返回语音二进制 错误则返回json 参照下面错误码
		if(!is_array($result)){
		    file_put_contents($filename, $result);
		}

		echo "<audio id='audio' src=$filename autoplay='true' style='display:none;'></audio>";
		exit('结束');
	}
}else{
	$url = $_SERVER['REQUEST_URI'];
	// ob_flush();
 //    flush();
 //    ob_clean(); //不太懂ob_clean的作用
	unset($_SESSION['post']);
	if(file_exists($filename)){
		unlink($filename);
	}
	header("Location: {$url}");
}


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="" method="post">
		<input type="text" name="speak">
		<button>提交</button>
	</form>
</body>
</html>