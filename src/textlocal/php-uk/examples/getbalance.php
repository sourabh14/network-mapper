<?php
require('../textlocal.class.php');

$textlocal = new Textlocal('demo@txtlocal.com', 'apidemo123');

try {
    $result = $textlocal->getBalance();
    print_r($result);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>