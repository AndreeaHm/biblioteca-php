<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Biblioteca online cu o selecție vastă de cărți și autori. Citește și descoperă noi titluri în colecția noastră." />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Login</title>
    <script async src="https://www.googletagmanager.com/gtag/js?id=6651754646"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());
  gtag('config', '6651754646');
</script>

</head>
<body>
    <h2>Login</h2>

    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>

        <label for="parola">Parola:</label>
        <input type="password" id="parola" name="parola" required>

        <button type="submit">Login</button>
        <div class="g-recaptcha" data-sitekey="6Le3PTcpAAAAAJCWfgcBCmsdbXsDevvpXxqtj4WG"></div>
    </form>

    <p>Don't have an account? <a href="signup.php">Sign up here</a>.</p>

<?php
session_start();

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['parola'])) {
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
        $parola = htmlspecialchars($_POST['parola'], ENT_QUOTES, 'UTF-8');

        $recaptchaSecretKey = '6Le3PTcpAAAAANsqMsO4OPChHBVWh81R342p0fGK';
        $recaptchaResponse = $_POST['g-recaptcha-response'];

        $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify";
        $recaptchaData = [
            'secret' => $recaptchaSecretKey,
            'response' => $recaptchaResponse,
        ];

        $recaptchaOptions = [
            'http' => [
                'method' => 'POST',
                'content' => http_build_query($recaptchaData),
            ],
        ];

        $recaptchaContext = stream_context_create($recaptchaOptions);
        $recaptchaResult = file_get_contents($recaptchaUrl, false, $recaptchaContext);
        $recaptchaResult = json_decode($recaptchaResult, true);

        if (!$recaptchaResult['success']) {
            echo '<script>alert("Eroare verificare reCAPTCHA.");</script>';
            exit();
        }

        $stmt = $conn->prepare("SELECT * FROM utilizatori WHERE email = ? AND parola = ?");
        $stmt->bind_param("ss", $email, $parola);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $userRole = $row['rol_user'];
            $_SESSION['user_role'] = $userRole;
            $_SESSION['email'] = $email;

            if ($userRole == 'utilizator') {
                header('Location: utilizator.php');
                exit();
            } elseif ($userRole == 'bibliotecar') {
                header('Location: bibliotecar.php');
                exit();
            } elseif ($userRole == 'admin') {
                header('Location: admin.php');
                exit();
            } else {
                echo '<script>alert("Rol necunoscut!");</script>';
            }
        } else {
            echo '<script>alert("Date incorecte/insuficiente.");</script>';
        }
    }
}

session_regenerate_id(true);
session_unset();
session_destroy();
?>
</body>
</html>
