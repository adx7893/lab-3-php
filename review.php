<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
}

// Initialize success message
$successmsg = '';

if (isset($_POST['submit'])) {
    // Here you can handle form submission (e.g., save to the database)
    $successmsg = "Your application has been submitted successfully!";
    // Clear session data after submission if needed
    // session_destroy(); // Uncomment to clear session after submission
}

// Helper function to display session data
function display_data($label, $data) {
    return "<tr><th>{$label}:</th><td>{$data}</td></tr>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Application</title>
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
    </style>
</head>
<body>

<h2>Review Your Application</h2>

<?php if ($successmsg): ?>
    <p style="color:green; text-align: center;"><?php echo $successmsg; ?></p>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Display collected information from session
        echo display_data("Full Name", $_SESSION['name'] ?? '');
        echo display_data("Email", $_SESSION['email'] ?? '');
        echo display_data("Phone Number", $_SESSION['number'] ?? '');
        echo display_data("Highest Degree", $_SESSION['h_degree'] ?? '');
        echo display_data("Field of Study", $_SESSION['f_study'] ?? '');
        echo display_data("Institution Name", $_SESSION['name_institution'] ?? '');
        echo display_data("Year of Graduation", $_SESSION['year_graduation'] ?? '');
        echo display_data("Previous Job Title", $_SESSION['p_j_title'] ?? '');
        echo display_data("Company Name", $_SESSION['c_name'] ?? '');
        echo display_data("Years of Experience", $_SESSION['y_exp'] ?? '');
        echo display_data("Key Responsibilities", nl2br($_SESSION['key_respo'] ?? ''));
        ?>
    </tbody>
</table>

<div style="text-align: center; margin-top: 20px;">
    <form method="POST" action="job_application.php?step=1">
        <button type="submit">Edit Personal Information</button>
    </form>
    <form method="POST" action="job_application.php?step=2">
        <button type="submit">Edit Education Information</button>
    </form>
    <form method="POST" action="job_application.php?step=3">
        <button type="submit">Edit Work Experience</button>
    </form>
    <form method="POST" action="review.php">
        <button type="submit" name="submit">Submit Application</button>
    </form>
</div>

<p style="text-align: center;"><a href="logout.php">Logout</a></p>
</body>
</html>
