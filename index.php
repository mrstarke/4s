<?php
include 'config.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);
session_id($sessionid);
session_start();

include 'commands.php';

if ($obj->message->text[0] == '/'){
    $comm = substr($obj->message->text,1);
    file_put_contents('/tmp/filename.txt', print_r($obj, true));
    $output = $comm();
}
else{
    $_SESSION['parameter'] = $obj->message->text;
}
if (isset($output)){
    foreach ($output as $line){
        exec('curl https://api.telegram.org/bot'.$bot_id.'/sendMessage -X POST -F text="' . $line . '" -F chat_id="'. $chat_id .'"');
    }
}
?>
