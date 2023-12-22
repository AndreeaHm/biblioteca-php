<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <title>Sign Up</title>
</head>
<body>
  <h2>Sign Up</h2>
  
 <?php
  include 'db.php';

  $notification = 'Eroare verificare reCAPTCHA.';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nume = htmlspecialchars($_POST['nume'], ENT_QUOTES, 'UTF-8');
      $prenume = htmlspecialchars($_POST['prenume'], ENT_QUOTES, 'UTF-8');
      $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
      $parola = htmlspecialchars($_POST['parola'], ENT_QUOTES, 'UTF-8');

      $checkEmailQuery = "SELECT * FROM utilizatori WHERE Email = '$email'";
      $result = mysqli_query($conn, $checkEmailQuery);

      if (mysqli_num_rows($result) > 0) {
          $notification = "Adresa de email există deja!";
      } else {
          if (!preg_match("/^[a-zA-Z0-9]*$/", $nume) || !preg_match("/^[a-zA-Z0-9]*$/", $prenume)) {
              $notification = "Numele și prenumele pot conține doar caractere alfanumerice!";
          } else {
              $recaptcha_secret = '6Le3PTcpAAAAANsqMsO4OPChHBVWh81R342p0fGK';
              $recaptcha_response = $_POST['g-recaptcha-response'];

              $url = 'https://www.google.com/recaptcha/api/siteverify';
              $data = array(
                  'secret' => $recaptcha_secret,
                  'response' => $recaptcha_response
              );

              $options = array(
                  'http' => array(
                      'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                      'method' => 'POST',
                      'content' => http_build_query($data)
                  )
              );

              $context = stream_context_create($options);
              $result = file_get_contents($url, false, $context);
              $result = json_decode($result, true);

              if (!$result['success']) {
                  $notification = "reCAPTCHA verification failed!";
              } else {
                  $stmt = $conn->prepare("INSERT INTO utilizatori (Nume, Prenume, Email, Parola) VALUES (?, ?, ?, ?)");
                  $stmt->bind_param("ssss", $nume, $prenume, $email, $parola);

                  if ($stmt->execute()) {
                      $notification = "Datele au fost înregistrate cu succes!";
                      header('Location: index.php');
                      exit();
                  } else {
                      $notification = "Eroare la înregistrarea datelor." . $stmt->error;
                  }

                  $stmt->close();
              }
          }
      }

      mysqli_close($conn);
  }
  ?>

  <?php
  if (!empty($notification)) {
      echo '<script>alert("' . $notification . '");</script>';
  }
  ?>

  <form id="signupForm" method="post" action="">
    <label for="nume">Nume:</label>
    <input type="text" id="nume" name="nume" required>

    <label for="prenume">Prenume:</label>
    <input type="text" id="prenume" name="prenume" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="parola">Parola:</label>
    <input type="password" id="parola" name="parola" required>

    <div class="g-recaptcha" data-sitekey="6Le3PTcpAAAAAJCWfgcBCmsdbXsDevvpXxqtj4WG"></div>
    <button type="submit">Sign Up</button>
  </form>
</body>
</html>
