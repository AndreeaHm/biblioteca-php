<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="Biblioteca online cu o selecție vastă de cărți și autori. Citește și descoperă noi titluri în colecția noastră." />
    <title>Pagina Principală</title>
    <script async src="https://www.googletagmanager.com/gtag/js?id=6651754646"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());
  gtag('config', '6651754646');
</script>

    <style>
        ul.menu {
            list-style-type: none;
            padding: 0;
            margin: 0;
            background-color: #333;
            overflow: hidden;
        }

        ul.menu li {
            float: left;
        }

        ul.menu li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        ul.menu li a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>
<body>
    <h1>Bine ați venit pe Biblioteca Online</h1>

    <ul class="menu">
        <li><a href="?section=carti">Cărți</a></li>
        <li><a href="?section=lista-lectura">Lista de Lectură</a></li>
        <li><a href="?section=adaugac">Adaugă Carte</a></li>
        <li><a href="?section=adaugaa">Adaugă Autor</a></li>
        <li><a href="?section=carusel">Biblioteci Carusel</a></li>
        <li><a href="?section=setari">Setări</a></li>
    </ul>

    <div id="content">
        <?php
        session_start();

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

$email = $_SESSION['email'];
        $section = isset($_GET['section']) ? $_GET['section'] : 'carti';
        switch ($section) {
            case 'carti':
                include('carti.php');
                break;
            case 'lista-lectura':
                include('lista_lectura.php');
                break;
            case 'adaugac':
                include('adauga_carte_request.php');
                break;
            case 'adaugaa':
                include('adauga_autor_request.php');
                break;
            case 'carusel':
                include('carusel.php');
                break;
            case 'setari':
                include('setari.php');
                break;
        }
        ?>
    </div>
</body>
</html>
