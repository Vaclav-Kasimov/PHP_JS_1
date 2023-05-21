<?php
session_start();

require_once('PDO_connect.php');
require_once('model.php');
require_once('controller.php');

check_permission();
$err_msg = print_err();
$row = get_row($pdo);
data_edit($pdo);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Viacheslav Kasimov</title>
    </head>
    
    <body>
        <h1>Editing Profile for UMSI</h1>
        <?= $err_msg ?>
        <form method="post">
            <p>First Name:
                <input type="text" name="first_name" value="<?= $row['first_name'] ?>" size="60"/></p>
            <p>Last Name:
                <input type="text" name="last_name" value="<?= $row['last_name'] ?>" size="60"/></p>
            <p>Email:
                <input type="text" name="email" value="<?= $row['email'] ?>" size="30"/></p>
            <p>Headline:<br/>
                <input type="text" name="headline" value="<?= $row['headline'] ?>" size="80"/></p>
            <p>Summary:<br/>
                <textarea name="summary" rows="8" cols="80"><?= $row['summary'] ?></textarea>
            <p>
                <input type="submit" name="dopost" value="Save">
                <input type="button" name="cancel" onclick="location.href='/index.php'; return false;" value="cancel">
            </p>
        </form>
    </body>
</html>
