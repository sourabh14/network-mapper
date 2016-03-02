<?php
require('../textlocal.class.php');

$textlocal = new Textlocal('demo@txtlocal.com', 'apidemo123');

$numbers = array(447123456789);
$sender = 'Textlocal';
$message = 'This is a message';

try {
    $result = $textlocal->sendSms($numbers, $message, $sender);
    print_r($result);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>