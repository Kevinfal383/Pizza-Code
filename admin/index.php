<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="admin.css"> -->
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Holtwood+One+SC&family=Raleway:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap");

        * {
            margin: 0;
            padding: 0;
        }

        body {
            background-image: url("../images/bg.png");
        }

        .admin {
            width: 70%;
            margin: auto;
            font-family: sans-serif;
            background: white;
            border-radius: 5px;
            padding: 20px 8px;
        }

        .header .titre h1 {
            font-family: "Holtwood One SC", serif;
            text-align: center;
            color: rgb(238, 91, 6);
            font-weight: bold;
            margin-top: 35px;
            margin-bottom: 35px;
        }

        .header .titre h1 i {
            color: rgb(255, 213, 0);
        }

        .header .titre h1 span {
            text-shadow: white 2px 2px 0px;
        }

        .admin .titre {
            display: flex;
        }

        .admin .titre .ajouter {
            margin-left: 8px;
        }

        .admin .titre .ajouter button {
            color: white;
            padding: 8px;
            background: rgb(3, 134, 3);
            border: none;
            border-radius: 4px;
            font-size: 18px;
        }

        .admin .titre .ajouter button:hover {
            background: rgb(0, 80, 0);
        }

        .admin .tableau thead th{
            border: 2px solid white;
        }

        .admin .tableau {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .admin .tableau thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
            font-weight: bold;
        }

        .tableau th,
        .tableau td {
            padding: 12px 15px;
            border-bottom: 1px solid #dddddd;
        }

        .tableau tbody tr {
            border-bottom: 1px solid #dddddd;
            transition: background-color 0.3s ease;
        }

        .tableau tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .tableau tbody tr:hover {
            background-color: #f1f1f1;
        }

        .tableau tbody td {
            position: relative;
        }

        .tableau tbody td:last-child {
            display: flex;
            gap: 10px;
        }

        .tableau tbody button {
            padding: 6px 12px;
            background-color: #009879;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .tableau tbody button:hover {
            background-color: #00795a;
        }

        .tableau tbody button a{
            color: white;
            text-decoration: none;
        }

        .tableau tbody button:focus {
            outline: none;
        }
    </style>
    
    <title>Pizza Code Admin</title>
</head>



<body>
    <div class="header">
        <div class="titre">
            <h1><i class="fas fa-utensils"></i> <span>PIZZA CODE</span> <i class="fas fa-utensils"></i></h1>
        </div>
    </div>

    <div class="admin">
        <div class="titre">
            <h1><strong>Liste des elements</strong></h1>
            <div class="ajouter">
                <button><i class="fas fa-add"></i> Ajouter</button>
            </div>
        </div>

        <table class="tableau">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require 'database.php';
                    $db = Database::connect();
                    $statement = $db->query('SELECT items.id, items.nom, items.description, items.prix, categories.nom AS categorie
                                            FROM items LEFT JOIN categories ON items.categorie = categories.id
                                            ORDER BY items.id DESC');

                    while($items = $statement->fetch())  //recupere une ligne
                    {
                        echo '<tr>';
                        echo '<td>' . $items['nom'] . '</td>';
                        echo '<td>' . $items['description'] . '</td>';
                        echo '<td>' . number_format((float)$items['prix'],2, '.', '') . '£'. '</td>';
                        echo '<td>' . $items['categorie'] . '</td>';
                        
                        echo '<td>';
                            echo '<button><a href="voir.php?id=' . $items['id'] . '">Voir</a></button>';
                            echo '<button><a href="modifier.php?id=' . $items['id'] . '">Modifier</a></button>';
                            echo '<button><a href="supprimer.php?id=' . $items['id'] . '">Supprimer</a></button>';
                        echo '</td>';
                        echo '</tr>';

                    }
                    Database::disconnect();

                ?>
            </tbody>
        </table>
    </div>

</body>

</html>