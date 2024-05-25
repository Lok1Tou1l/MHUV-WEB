    <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>YOUR NAME | Registration</title>
      <link rel="stylesheet" href="../Style/style.css" />
    </head>
    <body>
    <?php
    include "database.php";
   if (isset($_POST["submit"])) {
    $fullName = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["confirmPassword"];
    $role = "user";
    
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $errors = array();
    
    if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
     array_push($errors,"All fields are required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     array_push($errors, "Email is not valid");
    }
    if (strlen($password)<8) {
     array_push($errors,"Password must be at least 8 characters long");
    }
    if ($password!==$passwordRepeat) {
     array_push($errors,"Password does not match");
    }
    require_once "database.php";
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($db, $sql);
    $rowCount = mysqli_num_rows($result);
    if ($rowCount>0) {
     array_push($errors,"Email already exists!");
    }
    if (count($errors)>0) {
     foreach ($errors as  $error) {
         echo "<div class='alert alert-danger'>$error</div>";
     }
    }else{
     
     $sql = "INSERT INTO users (username,password,email,role) VALUES ( ?, ?, ? , ?)";
     $stmt = mysqli_stmt_init($db);
     $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
     if ($prepareStmt) {
         mysqli_stmt_bind_param($stmt,"ssss",$fullName,$passwordHash, $email,$role);
         mysqli_stmt_execute($stmt);
         echo "<div class='alert alert-success'>You are registered successfully.</div>";
     }else{
         die("Something went wrong");
     }
    }
  }
  ?>
      <div class="container">
        <div>
          <div>
            <!-- form -->
            <form method="POST" action="registration.php">
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
                • Registration •
              </p>
              <div>
                <label for="name">Your Name</label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  placeholder="Username"
                  required
                />
              </div>
              <div>
                <label for="email">Your email</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  placeholder="example@mail.com"
                  required
                />
              </div>
              <div>
                <label for="password">Your password</label>
                <input
                  type="password"
                  id="password"
                  name="password"
                  placeholder="•••••••"
                  required
                />
              </div>
              <div>
                <label for="confirmPassword">Confirm password</label>
                <input
                  type="password"
                  id="confirmPassword"
                  name="confirmPassword"
                  placeholder="•••••••"
                  required
                />
              </div>
              <div>
                <button class="buttons" type="submit" name="submit">Create an account</button>
                <a class="link" href="login.php">Already have an account?</a>
              </div>
            </form>
          </div>
        </div>
        <div class="image">
          <img
            src="https://images.unsplash.com/photo-1542871307-52aab5e79317?q=80&w=1921&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
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
      </div>
    </body>
  </html>
