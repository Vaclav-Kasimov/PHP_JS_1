<!DOCTYPE html>

<html>
    <head><title>Kasimov Viacheslav</title></head>
    <body>
        <h1>Please log in</h1>
        <?= $err_msg ?>
        <form method="post">
            <div>
                <span>Email </span>
                <input type="text" name="email" size="40">
            </div>
            <div>
                <span>Password </span>
                <input type="password" name="pass" size="40">
            </div>
            <div>
                <input type="submit" name="dopost" value="Log In">
                <input type="button" name="escape" onclick="location.href='/index.php'; return false;" value="Cancel">
            </div>
        </form>
    </body>
</html>