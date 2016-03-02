<?php
require('header.inc.php');

/** Get the groups list */
$groupResponse = $textLocal->getGroups();

/** Get the sender name list */
$senderResponse = $textLocal->getSenderNames();

if (isset($_POST['btnSend'])) {

    /** Handle schedule time */
    if (isset($_POST['chkSched'])) {
        if ($_POST['txtSched'] != '' && $_POST['txtSchedTime'] != '') {
            $sched = strtotime($_POST['txtSched'] . ' ' . $_POST['txtSchedTime']);
        } else $sched = null;
    } else $sched = null;

    if ($_POST['rdTo'] == 'numbers')
        $sendResponse = $textLocal->sendSMS($_POST['txtNumbers'], $_POST['txtMessage'], $_POST['lstFrom'], $sched);
    else $sendResponse = $textLocal->sendGroupSMS($_POST['lstGroup'], $_POST['txtMessage'], $_POST['lstFrom'], $sched);

    $sendRequest = $textLocal->getLastRequest();

    if ($sendResponse->status == 'success') {
        $sendResponse->batch->id = '<a href="batchstatus.php?id=' . $sendResponse->batch->id . '">' . $sendResponse->batch->id . '</a><br />';

        if (isset($sendResponse->batch->messages)) {
            foreach ($sendResponse->batch->messages as $message) {
                $message->id = '<a href="messagestatus.php?id=' . $message->id . '">' . $message->id . '</a><br />';
            }
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Txtlocal PHP wrapper - Send SMS</title>
    <link href="./css/styles.css" rel="stylesheet" type="text/css"/>
    <link href="./css/smoothness/jquery-ui-1.8.20.custom.css" rel="stylesheet" type="text/css"/>
    <link href="./css/jquery.ptTimeSelect.css" rel="stylesheet" type="text/css"/>
    <script src="./js/jquery-1.7.2.min.js"></script>
    <script src="./js/jquery-ui-1.7.2.min.js"></script>
    <script src="./js/jquery.ptTimeSelect.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#txtSched").datepicker({dateFormat: "d MM yy", minDate: new Date(), maxDate: '+12m'});
            $('#txtSchedTime').ptTimeSelect();

            $('#chkSched').change(function () {
                if ($(this).attr('checked') == 'checked') {
                    $("#txtSched").removeAttr('disabled', 'disabled').val("<?php echo date('d M Y');?>");
                    $("#txtSchedTime").removeAttr('disabled', 'disabled').val('12:00');
                }
                else {
                    $("#txtSched").attr('disabled', 'disabled');
                    $("#txtSchedTime").attr('disabled', 'disabled');
                }
            });
        });
    </script>
</head>

<body>
<div id="main">
    <form action="sendsms.php" method="post">
        <fieldset>
            <legend>Send SMS</legend>
            <div class="fieldRow">
                <label>
                    <input type="radio" name="rdTo" value="numbers" checked="checked"/>
                    Number(s)
                </label>
                <input type="text" name="txtNumbers" size="40"/>
            </div>
            <div class="fieldRow">
                <label>
                    <input type="radio" name="rdTo" value="group"/>
                    Group
                </label>
                <select name="lstGroup">
                    <?php
                    foreach ($groupResponse->groups as $group) {
                        ?>
                        <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?>
                            (<?php echo $group->size; ?> contacts)
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="fieldRow">
                <label>From</label>
                <select name="lstFrom">
                    <?php
                    foreach ($senderResponse->sender_names as $senderName) {
                        ?>
                        <option value="<?php echo $senderName; ?>"><?php echo $senderName; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="fieldRow">
                <label>Message</label>
                <textarea name="txtMessage" class="wide" rows="6"></textarea>
            </div>

            <div class="fieldRow">
                <label>Schedule time</label>
                <input type="checkbox" name="chkSched" id="chkSched"/>
                <input type="text" name="txtSched" id="txtSched" disabled="disabled" style="width: 100px;"/>
                <input type="text" name="txtSchedTime" id="txtSchedTime" disabled="disabled" style="width: 60px;"/>
            </div>

            <div class="fieldRow">
                <label>&nbsp;</label>
                <input type="submit" name="btnSend" value="Send Message"/>
            </div>

            <?php
            if (isset($sendResponse)) {
                ?>
                <fieldset>
                    <legend>Request</legend>
                    <?php
                    echo '<pre>';
                    print_r($sendRequest);
                    echo '</pre>';
                    ?>
                </fieldset>
                <fieldset>
                    <legend>Response</legend>
                    <?php
                    echo '<pre>';
                    print_r($sendResponse);
                    echo '</pre>';
                    ?>
                </fieldset>
            <?php
            }
            if (isset($sendResponse->errors)) {
                ?>
                <fieldset>
                    <legend>Errors</legend>
                    <?php
                    foreach ($sendResponse->errors as $id => $error) {
                        echo "$id. " . $error;
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