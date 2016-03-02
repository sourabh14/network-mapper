<?php
require('../textlocal.class.php');

$textlocal = new Textlocal('demo@txtlocal.com', 'apidemo123');

$groupName = 'New group';

try {
    $result = $textlocal->createGroup($groupName);
    print_r($result);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>