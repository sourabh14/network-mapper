<?php
require('../textlocal.class.php');
$textlocal = new Textlocal('demo@txtlocal.com', 'apidemo123');

try {
    $result = $textlocal->getGroups();

    /** Loop through groups */
    foreach ($result->groups as $group) {
        $groupName = $group->name;
        $groupId = $group->id;
        $groupSize = $group->size;
    }

    print_r($result);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>