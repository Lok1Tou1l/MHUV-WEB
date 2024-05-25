<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>YOUR NAME | Log in</title>
    <link rel="stylesheet" href="../Style/style.css" />
  </head>
  <body>
  <?php
include "database.php";

session_start();
if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $errors = array();

    if (empty($email) OR empty($password)) {
        array_push($errors,"All fields are required");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }

    if (count($errors) == 0) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_stmt_init($db);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

        if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                if (password_verify($password, $row['password'])) {
                    $_SESSION['user'] = $row['id'];
                    echo "<div class='alert alert-success'>You are logged in successfully.</div>";
                    header('location:home.php');
                } else {
                    echo "<div class='alert alert-danger'>Incorrect password.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Email does not exist.</div>";
            }
        } else {
            die("Something went wrong");
        }
    } else {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>
    <div class="container">
      <div class="image">
        <img
          src="https://images.unsplash.com/photo-1615033997119-42ce44dfe094?q=80&w=1901&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
          alt=""
          style="
            width: 100%;
            height: 100%;
            border-radius: 10px;
            object-fit: cover;
            object-position: bottom;
          "
        />
      </div>
      <div>
        <div>
          <!-- form -->
          <form method ="POST" action ="login.php">
            <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 20px">
              LOGO/NAME
            </h1>
            <p
              style="
                font-size: 18px;
                opacity: 0.75;
                margin-bottom: 10px;
                text-align: center;
              "
            >
              • Log in •
            </p>

            <div>
              <label for="email">Your email</label>
              <input
                type="email"
                id="email"
                name = "email"
                placeholder="example@mail.com"
                required
              />
            </div>
            <div>
              <label for="password">Your password</label>
              <input
                type="password"
                id="password"
                name = "password"
                placeholder="•••••••"
                required
              />
            </div>

            <div>
              <button class="buttons" type="submit" name="submit">Log in</button>
              <a class="link" href="registration.php">Create an account?</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
