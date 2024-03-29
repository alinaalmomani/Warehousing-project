<?php
// Require the validation file
require_once "validation.php";

// Get the email of the logged-in user from the session
$email = $_SESSION['email'];

// Check if the user is not logged in
if ($email == false) {
    // If not, redirect to the login page
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Code Verification</title>
    <link rel="icon" type="image/x-icon" href="../logo/icon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,400;0,600;1,200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../css/css.css" rel="stylesheet" />
</head>

<body id="login">
    <section>
        <div class="container p-5 my-5">
            <div class="row">
                <div class="col-md-4 offset-md-4 form">
                    <form action="reset-code.php" method="POST" autocomplete="off">
                        <!--this form is validated in the validation.php-->
                        <h2 class="text-center">Code Verification</h2>
                        <!--this php code is to display the error messages-->
                        <?php
                        if (isset($_SESSION['info'])) {
                        ?>
                            <div class="alert alert-success text-center" style="padding: 0.4rem 0.4rem">
                                <?php echo $_SESSION['info']; ?>
                            </div>
                        <?php
                            unset($_SESSION['info']);
                        }
                        ?>
                        <?php
                        if (count($errors) > 0) {
                        ?>
                            <div class="alert alert-danger text-center">
                                <?php
                                foreach ($errors as $showerror) {
                                    echo $showerror;
                                }
                                unset($errors);
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="form-group mb-3">
                            <input class="form-control" type="number" name="otp" placeholder="Enter code" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control button" type="submit" name="check-reset-otp" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
    </section>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="../js/login.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

</html>