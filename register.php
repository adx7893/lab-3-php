<?php
if($_SERVER['REQUEST_METHOD']=== 'POST')
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($username) && !empty($email) && !empty($password))
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userFile = 'users.json';
        $users = json_decode(file_get_contents($userFile), true)?: [];
        $users[] = ['username' => $username, 'email' => $email, 'password' => $hashedPassword];
        file_put_contents($userFile, json_encode($users, JSON_PRETTY_PRINT));
        echo "Registration Successful!";
    }
    else{
        echo "Please fill in all fields";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
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
    <h2 style="text-align: center;">Register Yourself Here</h2>
    <form method="POST" action="register.php">
        <table>
            <tr>
                <th><label for="username">Username:</label></th>
                <td><input type="text" id="username" name="username" required></td>
            </tr>
            <tr>
                <th><label for="email">Email:</label></th>
                <td><input type="email" id="email" name="email" required></td>
            </tr>
            <tr>
                <th><label for="password">Password:</label></th>
                <td><input type="password" id="password" name="password" required></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button type="submit">Register</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
