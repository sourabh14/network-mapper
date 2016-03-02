<?php
require('../textlocal.class.php');

$textlocal = new Textlocal('demo@txtlocal.com', 'apidemo123');

$groupId = 228839;
$sender = 'Textlocal';
$message = 'This is a group message';

try {
    $result = $textlocal->sendSmsGroup($groupId, $message, $sender);
    print_r($result);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>