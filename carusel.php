<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carusel cu Imagini și Nume de Biblioteci</title>
    <style>
        .carusel-container {
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            height: 400px;
        }

        .carusel {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .carusel div {
            width: 300px;
            text-align: center;
            margin-right: 10px;
        }

        .carusel img {
            width: 100%;
            height: auto;
        }

        .nume-biblioteca {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="carusel-container">
        <div class="carusel">
            <?php
            include("db.php");

            $query = "SELECT page_id, nume FROM biblioteci";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $pageId = $row["page_id"];
                    $numeBiblioteca = $row["nume"];
                    $imageUrl = "https://upload.wikimedia.org/wikipedia/commons/" . $pageId;
                    echo '<div>';
                    echo '<img src="' . $imageUrl . '" alt="Imagine">';
                    echo '<div class="nume-biblioteca">' . $numeBiblioteca . '</div>';
                    echo '</div>';
                }
            } else {
                echo "Nu s-au găsit înregistrări în tabela biblioteci.";
            }

            $conn->close();
            ?>
        </div>
    </div>
    <script>
        var carusel = document.querySelector('.carusel');
        var divs = carusel.querySelectorAll('div');
        var index = 0;

        setInterval(function () {
            divs[index].style.display = 'none';
            index = (index + 1) % divs.length;
            divs[index].style.display = 'block';
        }, 1500);
    </script>
</body>
</html>
