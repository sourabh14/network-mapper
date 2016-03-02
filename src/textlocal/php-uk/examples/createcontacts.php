<?php

require('header.inc.php');

$groupResponse = $textLocal->getGroups();

if (isset($_POST['btnCreate'])) {
    if ($_POST['rgMethod'] == 'numbers') {
        $createResponse = $textLocal->createContacts($_POST['txtNumbers'], $_POST['slGroup']);
    } elseif ($_POST['rgMethod'] == 'group') {

        $contacts = array();

        // Build the contacts array
        for ($i = 0; $i < sizeof($_POST['txtNumber']); $i++) {

            // Skip any empty rows
            if (!is_numeric($_POST['txtNumber'][$i]))
                continue;

            // $contacts[] = new Contact(number, firstname, lastname, custom1, custom2, custom3);
            $contacts[] = new Contact($_POST['txtNumber'][$i], $_POST['txtFirstname'][$i], $_POST['txtLastname'][$i], $_POST['txtCustom1'][$i], $_POST['txtCustom2'][$i], $_POST['txtCustom3'][$i]);
        }

        $createResponse = $textLocal->createContactsBulk($contacts, $_POST['slGroup']);
    }

    $createRequest = $textLocal->getLastRequest();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Txtlocal PHP wrapper - Send SMS</title>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    <link href="./css/smoothness/jquery-ui-1.8.20.custom.css" rel="stylesheet" type="text/css"/>
    <script src="./js/jquery-1.7.2.min.js"></script>
    <script src="./js/jquery-ui-1.7.2.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {

            $('#rgMethodNumbers').click(function () {
                $('#tblContacts').hide(500);
                $('#divNumbers').show(500);

            });

            $('#rgMethodBulk').click(function () {
                $('#tblContacts').show(500);
                $('#divNumbers').hide(500);
            });

        });

    </script>
</head>

<body>
<div id="main">
    <form action="createcontacts.php" method="post">
        <fieldset>
            <legend>Create Contacts</legend>

            <div class="fieldRow">
                <label>Group</label>
                <select name="slGroup">
                    <?php
                    foreach ($groupResponse->groups as $group) {
                        ?>
                        <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="fieldRow">
                <label for="rgMethodNumbers">Standard</label>
                <input type="radio" name="rgMethod" value="numbers" id="rgMethodNumbers" checked="checked"/>
            </div>
            <div class="fieldRow">
                <label for="rgMethodBulk">Bulk</label>
                <input type="radio" name="rgMethod" value="group" id="rgMethodBulk"/>
            </div>

            <div class="fieldRow" id="divNumbers">
                <label>Number(s)</label>
                <input name="txtNumbers" type="text" size="40"/>
            </div>

            <table border="0" id="tblContacts" style="display:none">
                <tr>
                    <th>Number</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Custom 1</th>
                    <th>Custom 2</th>
                    <th>Custom 3</th>
                </tr>
                <tr>
                    <td><input name="txtNumber[0]" type="text" size="10"/></td>
                    <td><input name="txtFirstname[0]" type="text" size="10"/></td>
                    <td><input name="txtLastname[0]" type="text" size="10"/></td>
                    <td><input name="txtCustom1[0]" type="text" size="10"/></td>
                    <td><input name="txtCustom2[0]" type="text" size="10"/></td>
                    <td><input name="txtCustom3[0]" type="text" size="10"/></td>
                </tr>
                <tr>
                    <td><input name="txtNumber[1]" type="text" size="10"/></td>
                    <td><input name="txtFirstname[1]" type="text" size="10"/></td>
                    <td><input name="txtLastname[1]" type="text" size="10"/></td>
                    <td><input name="txtCustom1[1]" type="text" size="10"/></td>
                    <td><input name="txtCustom2[1]" type="text" size="10"/></td>
                    <td><input name="txtCustom3[1]" type="text" size="10"/></td>
                </tr>
                <tr>
                    <td><input name="txtNumber[2]" type="text" size="10"/></td>
                    <td><input name="txtFirstname[2]" type="text" size="10"/></td>
                    <td><input name="txtLastname[2]" type="text" size="10"/></td>
                    <td><input name="txtCustom1[2]" type="text" size="10"/></td>
                    <td><input name="txtCustom2[2]" type="text" size="10"/></td>
                    <td><input name="txtCustom3[2]" type="text" size="10"/></td>
                </tr>
            </table>


            <div class="fieldRow">
                <label>&nbsp;</label>
                <input type="submit" name="btnCreate"/>
            </div>

            <?php
            if (isset($createResponse)) {
                ?>
                <fieldset>
                    <legend>Request</legend>
                    <?php
                    echo '<pre>';
                    print_r($createRequest);
                    echo '</pre>';
                    ?>
                </fieldset>
                <fieldset>
                    <legend>Response</legend>
                    <?php
                    echo '<pre>';
                    print_r($createResponse);
                    echo '</pre>';
                    ?>
                </fieldset>
            <?php
            }
            ?>
        </fieldset>
    </form>
</div>

</body>
</html>