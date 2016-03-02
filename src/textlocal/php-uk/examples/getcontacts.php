<?php
require('../textlocal.class.php');

$textlocal = new Textlocal('demo@txtlocal.com', 'apidemo123');

$groupId = 228839;
$startPos = 0;
$limit = 1000;

try {
    $result = $textlocal->getContacts($groupId, $limit, $startPos);

    /** Loop through contacts */
    foreach ($result->contacts as $contact) {
        $number = $contact->number;
        $firstName = $contact->first_name;
        $lastName = $contact->last_name;
        $custom1 = $contact->custom1;
        $custom2 = $contact->custom2;
        $custom3 = $contact->custom3;
    }

    print_r($result);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>