<?php
require('../textlocal.class.php');

$textlocal = new Textlocal('demo@txtlocal.com', 'apidemo123');

/**
 * MMS file. Can either be a fully-formed local path
 *                                C:\path\to\your\file.jpg
 *            or a valid URL
 *                                http://yourdomain.com/file.jpg
 */
$file = dirname(__FILE__) . '/mms-file.jpg';

$groupId = 228839;
$message = 'This is an MMS group message';

try {
    $result = $textlocal->sendMmsGroup($groupId, $file, $message);
    print_r($result);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>