<?php
if (isset($_REQUEST['id'])) {
    require('header.inc.php');
    $statusResponse = $textLocal->getMessageStatus($_REQUEST['id']);
    $statusRequest = $textLocal->getLastRequest();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Txtlocal PHP wrapper - Message Status</title>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<div id="main">
    <form action="messagestatus.php" method="post">
        <fieldset>
            <legend>Message Status</legend>

            <div class="fieldRow">
                <label>Message ID</label>
                <input type="text" name="id"/>
            </div>

            <div class="fieldRow">
                <label>&nbsp;</label>
                <input type="submit" name="btnSend"/>
            </div>

            <?php
            if (isset($statusResponse)) {
                ?>
                <fieldset>
                    <legend>Request</legend>
                    <?php
                    echo '<pre>';
                    print_r($statusRequest);
                    echo '</pre>';
                    ?>
                </fieldset>
                <fieldset>
                    <legend>Response</legend>
                    <?php
                    if ($statusResponse->status == 'success') {
                        ?>
                        <p>Message <?php echo $statusResponse->message->status; ?></p>
                    <?php
                    }
                    echo '<pre>';
                    print_r($statusResponse);
                    echo '</pre>';
                    ?>
                </fieldset>
            <?php
            }

            if (isset($statusResponse->errors)) {
                ?>
                <fieldset>
                    <legend>Errors</legend>
                    <?php
                    foreach ($statusResponse->errors as $error) {
                        echo "$error. " . $SMS->errorDesc($error);
                    }
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