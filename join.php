<?php

ob_start();
error_reporting(0);
define("TOKEN",'BOT TOKENI YOZILADI');
$admin = "BOT ADMINI ID SI";
$bot = "BOT USERNAMESI @ SIZ";
$botid = "BOT ID SI";


function bot($method, $datas=[]){
	$url = "https://api.telegram.org/bot".TOKEN."/$method";
	$ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas); 
    $res = curl_exec($ch);
    if(curl_error($ch)){
    var_dump(curl_error($ch));
    }else{
    return json_decode($res);
}
}


$update = json_decode(file_get_contents("php://input"));
$msg = $update->message;
$mid = $msg->message_id;
$cid = $msg->chat->id;
$chat_id = $msg->chat->id;
$username = $msg->from->username;
$fid = $msg->from->id;
$text = $msg->text;
$type = $msg->chat->type;
$title = $msg->chat->title;
$uid = $msg->from->id;
$uid2 = $update->callback_query->from->id;
$name = $msg->chat->first_name;
$new = $msg->new_chat_member;
$left = $msg->left_chat_member;
$leftid = $msg->left_chat_member->id;
$newid = $msg->new_chat_member->id;
$newname = $msg->new_chat_member->first_name;
$from_id = $msg->from->id;

//callback

$data = $update->callback_query->data;
$call_id = $update->callback_query->id;
$call_text = $update->callback_query->message->text;
$call_fromid = $update->callback_query->from->id;
$callmid = $update->callback_query->message->message_id;
$callcid = $update->callback_query->message->chat->id;

// reply_to_message

$reply = $msg->reply_to_message;
$rep_text = $msg->reply_to_message->text;
$rep_id = $msg->reply_to_message->from->id;
$rep_mid = $msg->reply_to_message->message_id;
$rep_name = $msg->reply_to_message->from->first_name;
$rep_username = $msg->reply_to_message->from->username;

mkdir("data");
mkdir("data/user_tili/$callcid");
mkdir("data/user_tili/$cid");

$lichka = get("data/users.txt");

$type = $msg->chat->type;

if($type == "private"){
   if(strpos($lichka,"$chat_id") !==false){
}else{
   put("data/users.txt","$lichka\n$chat_id");
   bot('sendmessage', [
       'chat_id' =>$admin,
       'text' => "<b>😄 Yangi aʼzo</b>\n\n<i>👤 Ismi:</i> <b>$name</b>\n<i>🆔 raqami:</i> <code>$fid</code>\n<i>✳️ Usernamesi:</i> @$username",
       'parse_mode' => "html",
       'reply_markup' => json_encode([
        'inline_keyboard' => [
            [["text"=>"💡Lichka","url"=>"tg://user?id=$fid"]],
            ]
        ])
    ]);
}
}

if($text == "/stat" and $chat_id == $admin){

$lichka = get("data/users.txt");
$lich = substr_count($lichka,"\n");
           
bot('sendMessage',[
    'chat_id' =>$chat_id,
    'text' => "*📊 Bot Statistikasi\n👤A'zolar:* $lich",
    'parse_mode' => 'markdown',
  ]);
}

if($text == "/start" and $type == "private"){
	bot('sendmessage',[
	'chat_id'=>$cid,
	'text'=>"*👋🏻Assalomu alaykum botga xush kelibsiz!*\n\n_ℹ️Guruhlarda kirdi-chiqdini tozalovchi bot!\n🤖Botni ishlatish uchun guruhga qoʻshing va admin bering!_",
	'parse_mode'=>"markdown",
	'reply_markup'=>json_encode([
    'inline_keyboard'=>[
        [['text'=>"➕ Guruhga Qoʻshish",'url'=>"http://t.me/$bot?startgroup=new"]],
        ]
    ])
]);
}

if($newid == $botid){
   bot('sendmessage',[
   'chat_id'=>$cid,
   'text'=>"<i>🤖Bot</i> <b>$title</b> <i>guruhida ishga tushdi!</i>\n\n<i>🚫To'liq ishlashi uchun admin berishingiz kerak!</i>",
   'parse_mode'=>"html",
   'reply_markup'=>json_encode([
    'inline_keyboard'=>[
        [['text'=>"➕ Guruhga Qoʻshish",'url'=>"http://t.me/$bot?startgroup=new"]],
        ]
    ])
]);
}

if($new){
	if($newid == $uid){
    bot('DeleteMessage',[
    'chat_id'=>$cid,
    'message_id'=>$mid,
]);
	bot('SendMessage',[
	'chat_id'=>$cid,
	'message_id'=>$mid,
	'text'=>"<b>👋🏻Assalomu alekum <a href='tg://user?id=$newid'>$newname</a> guruhimizga xush kelibsiz!</b>",
	'parse_mode'=>"html",
	'reply_markup'=>json_encode([
    'inline_keyboard'=>[
        [['text'=>"➕ Guruhga Qoʻshish",'url'=>"http://t.me/$bot?startgroup=new"]],
        ]
    ])
]);
}
}

if($left){
  bot('DeleteMessage',[
    'chat_id'=>$cid,
    'message_id'=>$mid,
]);
}

?>