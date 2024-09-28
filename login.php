<?php
session_start();
$error = '';
if($_SERVER ['REQUEST_METHOD']==='POST')
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    if(!empty($username) && !empty($password))
    {
        $userFile = 'users.json';
        $users = json_decode(file_get_contents($userFile), true) ?: [];

        $userFound = false;
        foreach ($users as $user) {
            if($user['username']===$username && password_verify($password, $user['password'])){
                $userFound = true;
                $_SESSION['username'] = $username;
                if($remember)
                {
                    setcookie('username', $username, time() + (86400*7), "/");
                }
                else{
                    setcookie('username', '', time() - 3600, "/");
                }
                header('Location: job_application.php');
                exit();
            }
        }
        if(!$userFound)
        {
            $error = "Username or Password is invalid!!";
        }
        else{
            $error = "Some field is empty!!!";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        table {
            margin: 0 auto; /* Center the table */
            border-collapse: collapse;
        }
        td, th {
            padding: 10px;
            border: 1px solid #ccc; /* Add borders to the table cells */
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Login Here</h2>
    <?php if ($error): ?>
        <p style="color: red; text-align: center;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <table>
            <tr>
                <th><label for="username">Username:</label></th>
                <td><input type="text" id="username" name="username" required></td>
            </tr>
            <tr>
                <th><label for="password">Password:</label></th>
                <td><input type="password" id="password" name="password" required></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button type="submit">Login</button>
                </td>
            </tr>
        </table>
    </form>
    <p style="text-align: center;">Don't have an account? <a href="register.php">Register here</a>.</p>
</body>
</html>
