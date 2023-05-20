<?php
function login($pdo){
        $salt = 'XyZzy12*_';
        if  (isset($_POST['dopost']) && $_POST['dopost'] == "Log In"){
            unset($_SESSION['name']); //Если каким-то образом есть информация о залогиненном пользователе, выходим из аккаунта
            $statement = $pdo->query("select * from users where email = '".$_POST['email']."'");
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            print(print_r($row));
            if (isset($row['password'])){
                if  (hash('md5', $salt.htmlentities($_POST['pass'])) != $row['password']){
                    $_SESSION['error'] = 'Incorrect password';
                    error_log("Login fail ".$_POST['email'].' '.hash('md5', $salt.htmlentities($_POST['pass'])));
                    header('Location: login.php');
                    return;
                }   else    {
                    $_SESSION['name'] = $_POST['email'];
                    $_SESSION['user_id'] = $row['user_id'];
                    header("Location: index.php");
                    error_log("Login success ".$_SESSION['email']);
                    return;
                }
            }else{
                $_SESSION['error'] = 'Incorrect email';
                    error_log("Login fail ".$_POST['email'].' '.hash('md5', $salt.htmlentities($_POST['pass'])));
                    header('Location: login.php');
                    return;
            }
        }
    }

function data_insert($pdo){
    if (isset($_POST['dopost'])){
        if (error_handler_insert_edit()){
            header('Location: '.$_SERVER['PHP_SELF']);
            return;
        }
        else{
            $stmt = $pdo->prepare('INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary)VALUES ( :uid, :fn, :ln, :em, :he, :su)');
            $stmt->execute(array(
                ':uid' => $_SESSION['user_id'],
                ':fn' => $_POST['first_name'],
                ':ln' => $_POST['last_name'],
                ':em' => $_POST['email'],
                ':he' => $_POST['headline'],
                ':su' => $_POST['summary'])
            );
            header('location: index.php');
            $_SESSION['success'] = 'Record inserted';
            return;
        }
    }
}
?>