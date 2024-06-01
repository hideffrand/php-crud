<!-- 
Proyek UAS Lab - PW IBDA2012
Deffrand Farera
222201312
-->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="index.css">
  <title>Sign Up | C-Cars</title>
</head>

<body id="signup-body">
  <nav class="w-full h-fit flex items-center justify-center fixed z-20 pt-4">
    <div class="md:w-1/2 w-[95%] flex justify-center items-center gap-12 md:py-4 py-2 md:px-8 px-4 bg-black bg-opacity-20 backdrop-blur-md border border-gray-600 rounded-full text-center">
      <a class="flex items-center gap-2 hover:text-white" href="index.php">
        <ion-icon name="car-sport-outline" class="md:text-3xl text-2xl hover:text-white"></ion-icon>
        Garage
      </a>
      <div class="logo md:text-lg text-xs w-full mb-0">C-Cars</div>
      <span class="flex md:gap-6 gap-2">
        <?php
        if (!isset($_SESSION['email'])) {
          echo <<<END
            <a href="login.php" class="flex gap-2 items-center justify-center">
              Login
              <ion-icon name="log-out-outline" class="md:text-3xl text-2xl hover:text-white"></ion-icon>
            </a>
          END;
        } else {
          echo <<<END
            <a href="signout.php" class="flex gap-2 items-center justify-center">
              Logout
              <ion-icon name="log-out-outline" class="md:text-3xl text-2xl hover:text-white"></ion-icon>
            </a>
            <a href="profile.php" class="flex items-center justify-center">
              <ion-icon name="person-circle-outline" class="md:text-3xl text-2xl hover:text-white"></ion-icon>
            </a>
          END;
        }
        ?>
      </span>
    </div>
  </nav>
  <div class="garage-door">
    <div class="logo">C-Cars</div>
  </div>
  <div class="container flex flex-col items-center justify-center h-screen w-full">
    <h1 class="logo italic text-4xl">C-Cars</h1>
    <form class="md:w-[300px] w-[90%] bg-black bg-opacity-20 backdrop-blur-md py-4 px-6 rounded-md" method="POST">
      <div class="flex flex-col mb-4">
        <label class="form-label" for="form2Example1">Email</label>
        <input type="email" id="form2Example1" name="email" class="px-2 py-2 bg-opacity-20 border border-gray-400 text-black cursor-pointer text-white rounded-md" required />
      </div>

      <div class="flex flex-col mb-4">
        <label class="form-label" for="form2Example2">Password</label>
        <input type="password" id="form2Example2" class="px-2 py-2 bg-opacity-20 border border-gray-400 text-black cursor-pointer text-white rounded-md" name="password" required />
      </div>

      <div class="flex flex-col mb-4">
        <label class="form-label" for="form2Example2">Verify password</label>
        <input type="password" id="form2Example2" class="px-2 py-2 bg-opacity-20 border border-gray-400 text-black cursor-pointer text-white rounded-md" name="confirm_password" required />
      </div>

      <input type="submit" name="submit" value="Sign Up" class="btn btn-primary btn-block mb-4">


      <?php
      include './handlers/connection.php';
      include './handlers/uid.php';
      session_start();

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_uid = 'U-' . strtoupper(create_uid());
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password !== $confirm_password) {
          echo "<p style='color: red;' class='text-center'>Password don't match!</p>";
          exit();
        }

        $q = $con->prepare("SELECT * FROM users WHERE email = ?");
        $q->bind_param("s", $email);
        $q->execute();
        $result = $q->get_result();

        if ($result->num_rows != 0) {
          echo "<p style='color: red;' class='text-center'>User already exist!</p>";
          exit();
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $q = $con->prepare("INSERT INTO users (id, email, password) VALUES (?, ?, ?)");
        $q->bind_param("sss", $new_uid, $email, $hashed_password);
        $res = $q->execute();

        if (!$res) {
          echo "<p style='color: red;' class='text-center'>Failed!</p>";
          exit();
        }

        $_SESSION['email'] = $email;
        $q->close();
        echo "<script>alert('Registration successful. You can now log in.'); window.location.href='index.php';</script>";
        exit();
      }
      ?>


      <div class="text-center">
        <p>Already have an account? <br><a href="login.php">Login</a></p>
      </div>
    </form>
  </div>
  <script src="./scripts/garageDoorAnimation.js"></script>
</body>

</html>