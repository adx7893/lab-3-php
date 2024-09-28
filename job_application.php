<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
}

// Initialize variables
$step = isset($_GET['step']) ? $_GET['step'] : 1;
$successmsg = $errormsg = '';
$steps_total = 3;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($step) {
        case 1:
            $_SESSION['name'] = $_POST['name'] ?? '';
            $_SESSION['email'] = $_POST['email'] ?? '';
            $_SESSION['number'] = $_POST['number'] ?? '';
            break;
        case 2:
            $_SESSION['h_degree'] = $_POST['degree'] ?? '';
            $_SESSION['f_study'] = $_POST['f_study'] ?? '';
            $_SESSION['name_institution'] = $_POST['name_institution'] ?? '';
            $_SESSION['year_graduation'] = $_POST['year_graduation'] ?? '';
            break;
        case 3:
            $_SESSION['p_j_title'] = $_POST['p_j_title'] ?? '';
            $_SESSION['c_name'] = $_POST['c_name'] ?? '';
            $_SESSION['y_exp'] = $_POST['y_exp'] ?? '';
            $_SESSION['key_respo'] = $_POST['key_respo'] ?? '';
            $successmsg = "Form submitted successfully!";
            break;
    }
}

// Navigation handling (Previous/Next)
if (isset($_POST['next'])) {
    if ($step < $steps_total) {
        $step++;
    }
} elseif (isset($_POST['previous'])) {
    if ($step > 1) {
        $step--;
    }
}

// Helper function for progress percentage
function progress_percentage($step, $steps_total) {
    return ($step / $steps_total) * 100;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application - Step <?php echo $step; ?></title>
    <style>
        table {
            margin: 0 auto;
            border-collapse: collapse;
        }
        td, th {
            padding: 10px;
            border: 1px solid #ccc;
        }
        h2 {
            text-align: center;
        }
        .progress {
            width: 80%;
            background-color: #f3f3f3;
            border-radius: 5px;
            margin: 0 auto;
        }
        .progress-bar {
            width: <?php echo progress_percentage($step, $steps_total); ?>%;
            height: 20px;
            background-color: #4caf50;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<h2>Job Application - Step <?php echo $step; ?></h2>

<!-- Progress bar -->
<div class="progress">
    <div class="progress-bar"></div>
</div>
<br>

<?php if ($successmsg): ?>
    <p style="color:green; text-align: center;"><?php echo $successmsg; ?></p>
<?php endif; ?>

<form method="POST" action="job_application.php?step=<?php echo $step; ?>">
    <?php if ($step == 1): ?>
        <fieldset>
            <legend>Personal Information:</legend>
            <table>
                <tr>
                    <th><label for="name">Full Name:</label></th>
                    <td><input type="text" name="name" id="name" value="<?php echo $_SESSION['name'] ?? ''; ?>"></td>
                </tr>
                <tr>
                    <th><label for="email">Email:</label></th>
                    <td><input type="email" name="email" id="email" value="<?php echo $_SESSION['email'] ?? ''; ?>"></td>
                </tr>
                <tr>
                    <th><label for="number">Phone Number:</label></th>
                    <td><input type="number" name="number" id="number" value="<?php echo $_SESSION['number'] ?? ''; ?>"></td>
                </tr>
            </table>
        </fieldset>
    <?php elseif ($step == 2): ?>
        <fieldset>
            <legend>Education Information:</legend>
            <table>
                <tr>
                    <th><label for="degree">Highest Degree:</label></th>
                    <td>
                        <select id="degree" name="degree">
                            <option value="high_school" <?php echo (isset($_SESSION['h_degree']) && $_SESSION['h_degree'] == 'high_school') ? 'selected' : ''; ?>>High School</option>
                            <option value="bachelor" <?php echo (isset($_SESSION['h_degree']) && $_SESSION['h_degree'] == 'bachelor') ? 'selected' : ''; ?>>Bachelor's</option>
                            <option value="master" <?php echo (isset($_SESSION['h_degree']) && $_SESSION['h_degree'] == 'master') ? 'selected' : ''; ?>>Master's</option>
                            <option value="other" <?php echo (isset($_SESSION['h_degree']) && $_SESSION['h_degree'] == 'other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="f_study">Field of Study:</label></th>
                    <td><input type="text" name="f_study" id="f_study" value="<?php echo $_SESSION['f_study'] ?? ''; ?>"></td>
                </tr>
                <tr>
                    <th><label for="name_institution">Institution Name:</label></th>
                    <td><input type="text" name="name_institution" id="name_institution" value="<?php echo $_SESSION['name_institution'] ?? ''; ?>"></td>
                </tr>
                <tr>
                    <th><label for="year_graduation">Year of Graduation:</label></th>
                    <td><input type="number" name="year_graduation" id="year_graduation" value="<?php echo $_SESSION['year_graduation'] ?? ''; ?>"></td>
                </tr>
            </table>
        </fieldset>
    <?php elseif ($step == 3): ?>
        <fieldset>
            <legend>Work Experience:</legend>
            <table>
                <tr>
                    <th><label for="p_j_title">Previous Job Title:</label></th>
                    <td><input type="text" name="p_j_title" id="p_j_title" value="<?php echo $_SESSION['p_j_title'] ?? ''; ?>"></td>
                </tr>
                <tr>
                    <th><label for="c_name">Company Name:</label></th>
                    <td><input type="text" name="c_name" id="c_name" value="<?php echo $_SESSION['c_name'] ?? ''; ?>"></td>
                </tr>
                <tr>
                    <th><label for="y_exp">Years of Experience:</label></th>
                    <td><input type="number" name="y_exp" id="y_exp" value="<?php echo $_SESSION['y_exp'] ?? ''; ?>"></td>
                </tr>
                <tr>
                    <th><label for="key_respo">Key Responsibilities:</label></th>
                    <td><textarea id="key_respo" name="key_respo"><?php echo $_SESSION['key_respo'] ?? ''; ?></textarea></td>
                </tr>
            </table>
        </fieldset>
    <?php endif; ?>

    <!-- Existing button section -->
    <div style="text-align: center;">
        <?php if ($step > 1): ?>
            <button type="submit" name="previous">Previous</button>
        <?php endif; ?>

        <?php if ($step < $steps_total): ?>
            <button type="submit" name="next">Next</button>
        <?php else: ?>
            <button type="submit" name="submit">Submit</button>
        <?php endif; ?>
    </div>

    <!-- Add this section to provide the review link after the form is submitted -->
    <?php if ($step == $steps_total && isset($_POST['submit'])): ?>
        <div style="text-align: center;">
            <a href="review.php">Review Your Application</a>
        </div>
    <?php endif; ?>
</form>

<p style="text-align: center;"><a href="logout.php">Logout</a></p>
</body>
</html>
