<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <script src="menu.js"></script>
    <title>Pizza Code</title>
</head>

<body>
    <div class="conteneur">
        <div class="header">
            <div class="titre">
                <h1><i class="fas fa-utensils"></i> <span>PIZZA CODES</span> <i class="fas fa-utensils"></i></h1>
            </div>

            <div class="navbar">

                <?php
                    
                    require "admin/database.php";
                    echo '<nav>
                            <ul>';
                    $db = Database::connect();
                    $statement = $db->query("SELECT * FROM categories");
                    $categories = $statement->fetchAll();  //utilises fetchAll() pour récupérer tous les résultats sous forme d'un tableau.
                    foreach($categories as $categorie)
                    {
                        if($categorie['id'] == 1)
                            echo '<li><a href="#' . $categorie['id'] . '" class="tab-link" data-tab="tab' . $categorie['id'] . '">' . $categorie['nom'] . '</a></li>';
                        else
                            echo '<li><a href="#' . $categorie['id'] . '" class="tab-link" data-tab="tab' . $categorie['id'] . '">' . $categorie['nom'] . '</a></li>';
                    }
                    echo '</ul>
                        </nav>';
                ?>
            </div>
        </div>

        <?php
            foreach($categories as $categorie)
            {
                echo '<div class="corps" id="tab' . $categorie['id'] . '">
                            <div class="ligne">';
                $statement = $db->prepare("SELECT * FROM items WHERE categorie = ?");
                $statement->execute(array($categorie['id']));
                while ($item = $statement->fetch())
                {
                    echo '
                            <div class="block">
                                <div class="image">
                                    <img src="images/' . $item['image'] . '" alt="">
                                </div>
                                <div class="information">
                                    <h3 class="soustitre">' . $item['nom'] . '</h3>
                                    <p class="prix">' . number_format((float)$item['prix'], 2, '.', '') . '$</p>
                                    <p class="description">' . $item['description'] . '</p>
                                </div>
                                <div class="boutton">
                                    <button><i class="fas fa-shopping-cart"></i> Commander</button>
                                </div>
                            </div>';
                }
                echo '</div>
                    </div>';
            }
            Database::disconnect();
        ?>
    </div>
</body>

</html>