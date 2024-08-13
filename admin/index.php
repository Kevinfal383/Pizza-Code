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
                        // require 'database.php';
                        // $db = Database::connect();
                        // $statement = $db->query('SELECT items.id, items.name, items.description, items.price, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id ORDER BY items.id DESC');
                        // while($item = $statement->fetch()) 
                        // {
                        //     echo '<tr>';
                        //     echo '<td>'. $item['name'] . '</td>';
                        //     echo '<td>'. $item['description'] . '</td>';
                        //     echo '<td>'. number_format($item['price'], 2, '.', '') . '</td>';
                        //     echo '<td>'. $item['category'] . '</td>';
                        //     echo '<td width=300>';
                        //     echo '<a class="btn btn-default" href="view.php?id='.$item['id'].'"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
                        //     echo ' ';
                        //     echo '<a class="btn btn-primary" href="update.php?id='.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                        //     echo ' ';
                        //     echo '<a class="btn btn-danger" href="delete.php?id='.$item['id'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
                        //     echo '</td>';
                        //     echo '</tr>';
                        // }
                        // Database::disconnect();
                      ?>
            </tbody>
        </table>
    </div>


</body>

</html>