<?php

include('./config/db_connect.php');

$email = "";
$title = "";
$ingredients = "";

$errors = array('email' => "", "title" => "", "ingredients" => "");

if (isset($_POST['submit'])) {


    //check email

    if (empty($_POST['email'])) {
        $errors["email"] = "An email is required <br>";
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "email must be a valid email address";
        }
    }

    if (empty($_POST['title'])) {
        $errors["title"] = "An title is required <br>";
    } else {
        $title = $_POST['title'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
            $errors["title"] = "Title must be letters and spaces only";
        };
    }

    if (empty($_POST['ingredients'])) {
        $errors["ingredients"] = "At least one ingredient is required <br>";
    } else {
        $ingredients = $_POST['ingredients'];

        if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
            $errors["ingredients"] = "ingredients must be a comma separated list";
        };
    }

    if (array_filter($errors)) {
        echo "errors in the form";
    } else {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

        //create sql

        $sql = "INSERT INTO pizzas(title,email,ingredients) VALUES('$email','$title','$ingredients')";


        //save to db and check

        if (mysqli_query($conn, $sql)) {
            // success
            header("Location: index.php");
        } else {
            // error
            echo "query error" . mysqli_error($conn);
        }
    }
    //end of the post check
}



?>
<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php') ?>
<section class="container grey-text">
    <h4 class="center">Add a Pizza</h4>
    <form class="white" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <label for="email">Your Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email) ?>">
        <div class="red-text"><?php echo $errors["email"] ?></div>
        <label for="title">Pizza Title:</label>
        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($title) ?>">
        <div class="red-text"><?php echo $errors["title"] ?></div>
        <label for="ingredients">Ingredients (comma separated) :</label>
        <input type="text" name="ingredients" id="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
        <div class="red-text"><?php echo $errors["ingredients"] ?></div>
        <div class="center">
            <input type="submit" value="submit" name="submit" id="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>
<?php include('templates/footer.php') ?>
</body>

</html>