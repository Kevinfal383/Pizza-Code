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

        /* .admin .tableau{
    margin-top: 10px;
    border: 2px solid black; 
}

.admin .tableau thead th{
    border-left: 1px solid black;
    border: 2px solid black;
    padding: 5px;
} */

        .admin .tableau {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            font-family: Arial, sans-serif;
            text-align: left;
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
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .tableau tbody button:hover {
            background-color: #00795a;
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
                    include 'database.php';
                    $sql = "SELECT nom, description, prix, categorie FROM items";
                    $statement = $conn->prepare($sql);
                    $statement->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['prix']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                        echo "</tr>";
                    }

                    //AVERENO ny connection @ base de donner anao dia araho ilay tuto 
                ?>

                <tr>
                    <td>Nom</td>
                    <td>Sandwich: Burger, Salade, Tomate, Cornichon + Frit...</td>
                    <td>8.50</td>
                    <td>Menu</td>
                    <td>
                        <button><a href="voir.php">Voir</a></button>
                        <button><a href="modifier.php">Modifier</a></button>
                        <button><a href="supprimer.php">Supprimer</a></button>
                    </td>
                </tr>
                <tr> 
                    <td>Nom</td>
                    <td>Sandwich: Burger, Salade, Tomate, Cornichon + Frit...</td>
                    <td>8.50</td>
                    <td>Menu</td>
                    <td>
                        <button><a href="voir.php">Voir</a></button>
                        <button><a href="modifier.php">Modifier</a></button>
                        <button><a href="supprimer.php">Supprimer</a></button>
                    </td>
                </tr>
                <tr>
                    <td>Nom</td>
                    <td>Sandwich: Burger, Salade, Tomate, Cornichon + Frit...</td>
                    <td>8.50</td>
                    <td>Menu</td>
                    <td>
                        <button><a href="voir.php">Voir</a></button>
                        <button><a href="modifier.php">Modifier</a></button>
                        <button><a href="supprimer.php">Supprimer</a></button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

</body>

</html>