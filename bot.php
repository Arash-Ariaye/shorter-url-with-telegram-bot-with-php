<?php//code by arash-asadi in github
//url https://github.com/Arash-Asadi
//Bot Info
	define('API_KEY', '425776110:AAFpDy5Ptt76U2SH479jFE1YGQaNHnx3O9U'); //token
//Bot Connection With Telegram
	function bot($method,$datas=[]){ // Send Method Functhion
		$url = "https://api.telegram.org/bot".API_KEY."/".$method;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
		$res = curl_exec($ch);
		if(curl_error($ch)){
			var_dump(curl_error($ch));
		}else {
			return json_decode($res);
		}	
	}
//Get Arry From Bot Token
	$content = file_get_contents("php://input");
	$update = json_decode($content, true);
	$message = $update['message'];
	$chat_id = $update['message']['chat']['id'];
	$text = $update['message']['text'];
	$from = $update['message']['from']['id'];
//Bot Action
	if (isset($text)) { // If Isset Text From Telegrom
		if ($text == "/start") { // If Isset Text Equal /start 
			bot('sendMessage',array( // Start Bot Function And Send Welcome Messages
				'chat_id'=>$chat_id,
				'text'=>"✋🏼 به ربات کوتاه کننده لینک <b>bpqd</b> خوشامدید \n
	💪🏻 قدرت گرفته از شاه سرور \n
	<a href='http://shahserver.ir'>شاه سرور </a>",
				'parse_mode'=>'HTML'
  			));
		}elseif (!preg_match('/^([Hh]ttp|[Hh]ttps)(.*)/',$text)) { // If Isset Text Unequal Url Start Bot Function And Send Message 
			bot('sendMessage',array('chat_id'=>$chat_id,'text'=>'لطفا یک url بفرستید 😉'));
		}else {
			bot('sendMessage',array('chat_id'=>$chat_id,'text'=>'لطفا صبر کنید 😉'));// Start Bot Function And Send wait Message
			bot('sendChatAction',array('chat_id'=>$chat_id,'action'=>'typing'));// Start Bot Function And Send Short Url Message
			$get = curl_init();
				curl_setopt($get,CURLOPT_URL,"http://llink.ir/yourls-api.php?signature=a13360d6d8&action=shorturl&url=".$text."&format=sample");
				curl_setopt($get,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($get,CURLOPT_HEADER, false);
				$result=curl_exec($get);
				curl_close($get);
			bot('sendMessage',[
				'chat_id'=>$chat_id,
				'text'=>"لینک کوتاه شده شما👇🏼\n<b>url</b> : ".$result."\n آماده برایه کوتاه کردن لینک دیگر",
				'parse_mode'=>'HTML'
			]);	
		}
	}
?>
