<?php
    function print_err(){
        $result = '';
        if (isset($_SESSION['success'])){
            $result.='<div style="color:green;">'.$_SESSION['success'].'</div>';
            unset($_SESSION['success']);
            unset($_SESSION['error']);
        }elseif (isset($_SESSION['error'])){
            $result.='<div style="color:red;">'.$_SESSION['error'].'</div>';
            unset($_SESSION['error']);
        }
        
        return $result;
    }

    function check_permission(){
        // проверка на логин
        if (! isset($_SESSION['name'])) {
            die('ACCESS DENIED');
        }
    }

    function generate_html_index($pdo){
        if (isset($_SESSION['name'])){
            $data = print_db($pdo);
            $result='<div><a href="logout.php">Logout</a></div><div>'.$data.'</div><div><a href="add.php">Add New Entry</a></div>';
        }else{
            $result = '<div><a href="login.php">Please log in</a></div>';
        }
        return $result;
    }

    function error_handler_insert_edit(){
        if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1|| strlen($_POST['summary']) < 1){
            $_SESSION['error'] ='All fields are required';
            return true;
        }   elseif ( stristr($_POST['email'], '@') === false ){
            $_SESSION['error'] ='Email address must contain @';
            return true;
        }   else{
            return false;
        }
    }


    function print_db($pdo){
        $statement = $pdo->query('SELECT * FROM Profile');
            $result = '<table><tr><th>Name</th><th>Headline</th><th>Action</th></tr>';
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $links = '<a href ="edit.php?profile_id='.
                        $row['profile_id'].
                    '">Edit</a> <a href ="delete.php?profile_id='.
                        $row['profile_id'].
                    '">Delete</a>';
                $result.=(
                    '<tr><td>'
                        .'<a href = "view.php?profile_id='.$row['user_id'].'">'
                        .$row['first_name'].' '.$row['last_name'].'</a>'.
                    '</td><td>'
                        .$row['headline'].
                    '</td><td>'.
                        $links.
                    '</td></tr>'
                );
            
            }
            if ($result == '<table><tr><th>Name</th><th>Headline</th><th>Action</th></tr>'){
                $result = '';
            }else{
                $result.='</table>';
            }
            return ($result);
    }

    function get_row($pdo){
        if (!check_user_id($pdo)){
            header('Location: index.php');
            return false;
        }   else{
            return find_by_primary_key($pdo,$_GET['profile_id']);
        }
    }

    function profile_info($pdo){
        $row = get_row($pdo);
        if ($row === false){
            return false;
        }else{
            return "<p>First Name: ".$row['first_name']."</p><p>Last Name: ".$row['last_name']."</p><p>Email: ".$row['email']."</p><p>Headline: ".$row['headline']."</p><p>Summary: ".$row['summary']."</p>";
        }
    }
?>