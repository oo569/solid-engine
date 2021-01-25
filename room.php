<?php

ob_start();
define('API_KEY','');
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
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

include "id.php";
include "admins.php";
include "banlist.php";
$update = json_decode(file_get_contents('php://input'));
$sudo = 325384922;
$message = $update->message;
$chat_id = $message->chat->id;
$text1 = $message->text;
$from_id = $message->from->id;
$chat_id2 = $update->callback_query->message->chat->id;
$message_id = $update->callback_query->message->message_id;
$data = $update->callback_query->data;
$id2 = $update->callback_query->message->from->id;
$reply = $message->reply_to_message;
$reply_id = $message->reply_to_message->forward_from->id;
$reply_user = $message->reply_to_message->forward_from->username;
$from_user = $message->from->username;
$dont_send = array('/ban','/unban','/kick','/promote','/demote','/help');
$inch = file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@Set_Web&user_id=".$from_id);
 
 $inlineqt = $update->inline_query->query;
bot('answerInlineQuery',[
        'inline_query_id'=>$update->inline_query->id,    
        'results' => json_encode([[
            'type'=>'article',
            'id'=>base64_encode(rand(5,555)),
            'title'=>'مشاركة مع اصدقائك',
            'input_message_content'=>['parse_mode'=>'HTML','message_text'=>"مرحبا بكم ✨ في بوت الدردشة 📩\nتواصل 📫 مع مستخدمي تليجرام 🚹\nبصورة امتع ✳️ انضم الان ‼️"],
            'reply_markup'=>['inline_keyboard'=>[
                [
                ['text'=>'للدخول الى البوت اضغط هنا ♻️','url'=>'https://telegram.me/ChRoom_Bot']
                ],
                [
                ['text'=>'تابع جديدنا ✨', 'url'=>'https://telegram.me/Set_Web'] 
                ],
                [
                ['text'=>'مطور البوت 🕴', 'url'=>'https://telegram.me/omar_real'] 
                ]
             ]]
        ]])
    ]);
 
 if (strpos($inch , '"status":"left"') !== false ){
bot('sendMessage', [
'chat_id'=>$chat_id,
'parse_mode'=>'Markdown',
'text'=>"عذرا ❗يجب عليك الدخول للقناة 🕴🔹\n لكي يمكنك استخدام البوت 🤖🍁" . "\n\n" . "Sorry 📪 You can't Use❗️This bot 🤖\nYou have to ❌ join to the bot channel ♻️",
'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [
          ['text'=>'اضغط هنا للدخول ☘', 'url'=>"https://telegram.me/set_web"]
        ],
         [
          ['text'=>'Click here to join ❇️' , 'url'=>"https://telegram.me/set_web"]
        ],
]

])
]);
}


if($text1 == "/start" && !in_array($from_id, $id_chat) && !strpos($inch , '"status":"left"') !== false){
bot('sendmessage', [
'chat_id'=>$chat_id,
    'text'=>"اهلا ✨ بك عزيزي في بوت 🤖🍁 \n ال Rooms 💭 تواصل مع مستخدمين 🚹\nتليجرام بصورة امتع ✳️ انتبه لالفاضك ‼️",
    'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [
         ['text'=>'ابدٲ❕', 'callback_data'=>"begin"]
        ],
        [
         ['text'=>'تابعنا ✨', 'callback_data'=>'channel']
        ],
        [
         ['text'=>'المطور 🔭', 'url'=>'https://telegram.me/omar_real']
        ],
        [
        ['text'=>'شارك البوت 🚹', 'switch_inline_query'=>""]
        ],
    ]
    ])
  ]);
}


if($data=="channel" && !strpos($inch , '"status":"left"') !== false){
   bot('editMessageText',[
   'chat_id'=>$chat_id2,
    'message_id'=>$message_id,
    'text'=>'تابعنا عبر الروابط للتالية 📩',
   'reply_markup'=>json_encode([
'inline_keyboard'=>[
        [
          ['text'=>'القناة الرسمية ✅', 'url'=>"https://telegram.me/set_web"]
        ],
        [
        ['text'=>'تيم EVS ✨', 'url'=>"https://telegram.me/TeamEVS"]
        ],
        [
        ['text'=>'فريق لمسة 💡', 'url'=>"https://telegram.me/touch_t"]
        ],
        [
        ['text'=>'الصفحة الرئيسية 📩️', 'callback_data'=>"omar"]
        ]
      ]
    ])
        ]);

         }
         
  
if($text1 == "/help" && $from_id == in_array($from_id, $admin_id)){
bot('sendMessage', [
'chat_id'=>$chat_id,
'text'=>"
الاوامر المتاحة 📋:
\n\n
/kick ~ لطرد عضو
\n
/ban ~ لحضر عضو
\n
/unban ~ لالغاء الحضر
"
]);
}

if($text1 == "/start" && in_array($from_id, $id_chat) && !in_array($from_id, $bans) && !strpos($inch , '"status":"left"') !== false){
bot('sendMessage', [
'chat_id'=>$chat_id,
'text'=>'انت الان 🚹 داخل باب الشرجي 👥♻️',
'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [
         ['text'=>'خروج❕', 'callback_data'=>"leav"]
        ]
]
])
]);
}

if($data == "leav"){
$o = file_get_contents('id.php');
if (in_array($chat_id2,$id_chat)) {
$o = file_get_contents('id.php');
$o = str_replace($chat_id2,"0",$o);
$o = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $o);
file_put_contents('id.php', $o);
}
bot('editMessageText', [
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
    'text'=>"اهلا ✨ بك عزيزي في بوت 🤖🍁 \n ال Rooms 💭 اختر الدردشة التي تناسبك ♦️",
    'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [
         ['text'=>'باب الشرجي ☘', 'callback_data'=>"chat"]
        ],
      [
      ['text'=>'الصفحة الرئيسية 📩', 'callback_data'=>'omar']
      ]
      ]
    ])
  ]);
}

if($data == "chat" && !in_array($chat_id2, $bans)){
file_put_contents('id.php', "\n" . '$id_chat[] =  ' . $chat_id2 . ";", FILE_APPEND);
bot('editMessageText', [
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"لقد دخلت 🚹 الى الدردشة 💭 ارسل الان ما تشاء ♦️\n\n/out للخروج من الجات 🚹 ",
]);
}


if($text1 == "/out" && in_array($from_id, $id_chat) && !strpos($inch , '"status":"left"') !== false){
$o = file_get_contents('id.php');
if (in_array($from_id,$id_chat)) {
$o = file_get_contents('id.php');
$o = str_replace($from_id,"0",$o);
$o = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $o);
file_put_contents('id.php', $o);
}

bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>'لقد قمت بل خروج ❌ من المجموعة 👥✅',
'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [
         ['text'=>'صفحة الغرف 📫️', 'callback_data'=>"begin"]
        ],
        [
         ['text'=>"عودة للمجموعة 👥", 'callback_data'=>"chat"]
        ]
]
])
]);
}

if($data == "begin"){
bot('editMessageText', [
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
    'text'=>"اهلا ✨ بك عزيزي في بوت 🤖🍁 \n ال Rooms 💭 اختر الدردشة التي تناسبك ♦️",
    'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [
         ['text'=>'باب الشرجي ☘', 'callback_data'=>"chat"]
        ],
      [
      ['text'=>'الصفحة الرئيسية 📩', 'callback_data'=>'omar']
      ]
      ]
    ])
  ]);
}

if($data == "omar"){
bot('editMessageText', [
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
    'text'=>"اهلا ✨ بك عزيزي في بوت 🤖🍁 \n ال Rooms 💭 تواصل مع مستخدمين 🚹\nتليجرام بصورة امتع ✳️ انتبه لالفاضك ‼️",
    'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [
         ['text'=>'ابدٲ❕', 'callback_data'=>"begin"]
        ],
        [
         ['text'=>'تابعنا ✨', 'callback_data'=>'channel']
        ],
        [
         ['text'=>'المطور 🔭', 'url'=>'https://telegram.me/omar_real']
        ],
        [
        ['text'=>'شارك البوت 🚹', 'switch_inline_query'=>""]
        ],
    ]
    ])
  ]);
}

if($text1 != "/start" && !$reply && $text1 != "/out" && in_array($from_id, $id_chat) && !in_array($from_id, $bans) && !in_array($text1, $dont_send) && !strpos($inch , '"status":"left"') !== false){
$o = file_get_contents('id.php');
if (in_array($from_id,$id_chat)) {
$o = file_get_contents('id.php');
$o = str_replace($from_id,"0",$o);
$o = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $o);
file_put_contents('id.php', $o);
}

$o = file_get_contents('id.php');
if (in_array($from_id,$id_chat)) {
$o = file_get_contents('id.php');
$o = str_replace($from_id,"0",$o);
$o = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $o);
file_put_contents('id.php', $o);
}

for($y=0;$y<count($id_chat); $y++){
bot('forwardMessage', [
'chat_id'=>$id_chat[$y],
'from_chat_id'=>$chat_id,
'message_id'=>$message->message_id,
'text'=>$text1,
]);
}

file_put_contents('id.php', "\n" . '$id_chat[] =  ' . $chat_id . ";", FILE_APPEND);
}

if($reply && $text1 != in_array($text1, $dont_send)){
bot('sendMessage',[
'chat_id'=>$reply_id,
'text'=>'المستخدم 🚹 : @' . $from_user . " ارسل لك رسالة 📩" . "\nالرسالة : " . $text1
]);
}

if($text1 == "/promote" && $reply && $from_id == $sudo && !in_array($reply_id, $admin_id)){
file_put_contents('admins.php', "\n" . '$admin_id[] = ' . $reply_id . ";", FILE_APPEND);
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>'العضو 🚹 : @' . $reply_user . " تم ترقيته ✅",
'reply_to_message_id'=>$message->message_id
]);

bot('sendMessage',[
'chat_id'=>$reply_id,
'text'=>"لقد تم ✅ ترقيتك لتصبح ادمن 🚹" . "\n/help ~ لعرض اوامر الادمن"
]);
}

if($text1 == "/demote" && $reply && $from_id == $sudo && in_array($reply_id, $admin_id)){
$o = file_get_contents('admins.php');
if (in_array($reply_id,$admin_id)) {
$o = file_get_contents('admins.php');
$o = str_replace($reply_id,"0",$o);
$o = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $o);
file_put_contents('admins.php', $o);

bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"العضو 🚹 : @" . $reply_user . " تم ازالته من الادمنية ♻️‼️",
'reply_to_message_id'=>$message->message_id,
]);
bot('sendmessage',[
'chat_id'=>$reply_id,
'text'=>'لقد تم ✅ ازالتك من الادمنية 👥🔶',
]);
}
}

if($text1 == "/kick" && $reply && $reply_id != in_array($reply_id, $admin_id) && $chat_id == in_array($from_id, $admin_id)){
$o = file_get_contents('id.php');
if (in_array($reply_id,$id_chat)) {
$o = file_get_contents('id.php');
$o = str_replace($reply_id,"0",$o);
$o = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $o);
file_put_contents('id.php', $o);
}

bot('sendMessage', [
'chat_id'=>$chat_id,
'text'=>"العضو 🚹 : @" . $reply_user . " تم طرده من الغرفة 👥✅",
'reply_to_message_id'=>$message->message_id,
]);

bot('sendMessage', [
'chat_id'=>$reply_id,
'text'=>'لقد قام 🚹 : @' . $from_user . " بطردك من الدردشة 👥‼️"
]);
}

if($text1 == "/kick" && $reply && $reply_id == in_array($reply_id, $admin_id)){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"عذرا ❗️لا يمكنك طرد الادمنية🕴🔹",
'reply_to_message_id'=>$message->message->id,
]);
}

if($text1 == "/ban" && $reply && !in_array($reply_id, $bans) && $reply_id != in_array($reply_id, $admin_id)){
$o = file_get_contents('id.php');
if (in_array($reply_id,$id_chat)) {
$o = file_get_contents('id.php');
$o = str_replace($reply_id_id,"0",$o);
$o = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $o);
file_put_contents('id.php', "\n" . $o . " ");
}
$o = file_get_contents('id.php');
if (in_array($reply_id,$id_chat)) {
$o = file_get_contents('id.php');
$o = str_replace($reply_id,"0",$o);
$o = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $o);
file_put_contents('id.php', $o);
}
file_put_contents('banlist.php', "\n" . '$bans[] = ' . $reply_id . ";", FILE_APPEND);
bot('sendMessage', [
'chat_id'=>$chat_id,
'text'=> 'العضو 🚹 : @' . $reply_user . ' تم حضره 📵✅',
'reply_to_message_id'=>$message->message_id
]);

bot('sendMessage',[
'chat_id'=>$reply_id,
'text'=>'لقد قام 🚹 : @' . $from_user . ' بحضرك من الدردشة 📵‼️'
]);
}

if($data == "chat" && in_array($chat_id2, $bans)){
bot('editMessageText',[
'chat_id'=>$chat_id2,
'text'=>'المعذرة ‼️ لا يمكنك الدخول انت محضور 🚹✅',
'message_id'=>$message_id
]);
}

if($text1 == "/unban" && $reply && $reply_id != in_array($reply_id, $admin_id) && $reply_id == in_array($reply_id, $bans)){
$o = file_get_contents('banlist.php');
if (in_array($reply_id,$bans)) {
$o = file_get_contents('banlist.php');
$o = str_replace($reply_id,"0",$o);
$o = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $o);
file_put_contents('banlist.php', $o);
}

bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>'العضو 🚹 : @' . $reply_user . " تم الغاء حضره ‼️✅",
'reply_to_message_id'=>$message->message_id
]);

bot('sendMessage',[
'chat_id'=>$reply_id,
'text'=>'قام 🚹 : @' . $from_user . ' بٲلغاء حضرك ‼️✅'
]);
}a