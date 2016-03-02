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

$numbers = array('447403142134');
$message = 'This is an MMS message';

try {
    $result = $textlocal->sendMms($numbers, $file, $message);
    print_r($result);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>