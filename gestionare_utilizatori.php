<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="Biblioteca online cu o selecție vastă de cărți și autori. Citește și descoperă noi titluri în colecția noastră." />
    <title>Gestionare Utilizatori</title>
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
    <h1>Gestionare Utilizatori</h1>

    <h2>Listă de Utilizatori</h2>
    <table border="1">
        <tr>
            <th>Nume</th>
            <th>Prenume</th>
            <th>Email</th>
            <th>Rol Utilizator</th>
            <th>Acțiuni</th>
        </tr>
        <?php
        include('db.php');

        $sql = "SELECT id_utilizator, nume, prenume, email, rol_user FROM utilizatori WHERE rol_user IN ('utilizator', 'bibliotecar')";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['nume'] . "</td>";
                echo "<td>" . $row['prenume'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . ($row['rol_user'] == 'utilizator' ? 'Utilizator' : 'Bibliotecar') . "</td>";
                echo "<td><a href='modificare_utilizator.php?id=" . $row['id_utilizator'] . "'>Modifică</a> | <a href='sterge_utilizatori.php?id=" . $row['id_utilizator'] . "' onclick='return confirm(\"Sunteți sigur că doriți să ștergeți acest utilizator?\")'>Șterge</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nu există utilizatori disponibili.</td></tr>";
        }
        ?>
    </table>
    <button id="generare-pdf">Generează PDF</button>
    <script>
        document.getElementById('generare-pdf').addEventListener('click', function () {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'generare_pdf.php', true);
            xhr.responseType = 'blob';

            xhr.onload = function () {
                if (this.status === 200) {
                    var blob = new Blob([xhr.response], { type: 'application/pdf' });
                    var url = window.URL.createObjectURL(blob);

                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'utilizatori.pdf';
                    document.body.appendChild(a);
                    a.click();

                    window.URL.revokeObjectURL(url);
                }
            };

            xhr.send();
        });
    </script>
</body>
</html>
