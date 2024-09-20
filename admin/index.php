<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
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
                <button><a href="ajouter.php"><i class="fas fa-add"></i>Ajouter</a></button>
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