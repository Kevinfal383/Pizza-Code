<?php
    require 'database.php';

    if (!empty($_GET['id']))    //si tu accèdes à une page avec une URL comme page.php?id=123, le paramètre id sera récupéré et traité.
    {
        $id = checkInput($_GET['id']);    //Si le paramètre id n'est pas vide, il est récupéré via $_GET['id'] et passé à la fonction checkInput() pour être nettoyé avant de l'utiliser.
    }

    $db = Database::connect();
    $statement = $db->prepare('SELECT items.id, items.nom, items.description, items.prix, items.image, categories.nom AS categorie
                                            FROM items LEFT JOIN categories ON items.categorie = categories.id
                                            WHERE items.id = ?');
    $statement->execute(array($id));    //Rehefa prepare dia manao execute satria io no hanoloana ilay ? .Le tableau array($id) remplace le ? dans la requête avec la valeur réelle de $id (qui est sécurisée en amont avec la fonction checkInput() pour éviter les injections SQL).
    $items = $statement->fetch();
    Database::disconnect();



    function checkInput($data){    //pour sécuriser l'input
        $data = trim($data);                    //Supprime les espaces (ou autres caractères définis) en début et fin de chaîne.
        $data = stripslashes($data);            //Supprime les antislashs () ajoutés par certaines fonctions pour échapper des caractères spéciaux (comme ' ou "). Cela protège contre l'ajout non désiré de slashes.
        $data = htmlspecialchars($data);        //Convertit les caractères spéciaux en entités HTML (par exemple, < devient &lt;, > devient &gt;, etc.). Cela protège contre les attaques XSS (injections de code HTML ou JavaScript dans une page web).
        return $data;
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <style>
        .block {
    border: 4px solid white;
    border-radius: 5px;
    width: 30%;
  }
  .block .image {
    background: rgb(255, 213, 0);
    width: 100%;
  }
  .block .image img {
    width: 100%;
    height: 100%;
  }
  .block .information {
    padding: 6px;
    background: white;
  }
  .block .information h3 {
    color: rgb(238, 91, 6);
    padding-bottom: 5px;
  }
  .block .information .prix {
    background: #5cb85c;
    box-shadow: 0 1px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 0 1px rgba(0, 0, 0, 0.2);
    -webkit-box-shadow: 0 1px rgba(0, 0, 0, 0.2);
    color: #fff;
    text-shadow: 2px 2px #333;
    position: absolute;
    margin-top: -18.5%;
    margin-left: 15.3%;
    padding: 5px 10px;
    font-size: 20px;
    border-radius: 3px;
    width: 4.7%;
    font-size: 14px;
  }
  .block .information .prix:before {
    border: 4px solid transparent;
    border-bottom: 4px solid #4a934a;
    border-left: 4px solid #4a934a;
    content: "";
    position: absolute;
    right: 1px;
    top: -8px;
  }
  .block .information p {
    color: rgb(68, 68, 68);
    font-size: 14px;
  }
  .block .boutton {
    padding: 6px;
    background: white;
  }
  .block .boutton button {
    color: white;
    padding: 10px;
    background: rgb(238, 91, 6);
    width: 100%;
    border: none;
    border-radius: 4px;
    font-family: "Holtwood One SC", serif;
    text-shadow: black 2px 2px 0px;
  }
  .block .boutton button:hover {
    background: rgb(198, 78, 9);
  }
    </style>

    <title>Pizza Code Admin Voir</title>
</head>

<body>
    <div class="header">
        <div class="titre">
            <h1><i class="fas fa-utensils"></i> <span>PIZZA CODE</span> <i class="fas fa-utensils"></i></h1>
        </div>
    </div>

    <div class="admin">
        <div class="colone1">
            <div class="titre">
                <h1><strong>Voir les elements</strong></h1>
            </div>

            <form action="">
                <div class="info">
                    <label>Nom:</label><?php echo ' ' . $items['nom']; ?>
                </div>
                <div class="info">
                    <label>Description:</label><?php echo ' ' . $items['description']; ?>
                </div>
                <div class="info">
                    <label>Prix:</label><?php echo ' ' . number_format((float)$items['prix'], 2, '.', '') . '£'; ?>
                </div>
                <div class="info">
                    <label>Categorie:</label><?php echo ' ' . $items['categorie']; ?>
                </div>
                <div class="info">
                    <label>Image:</label><?php echo ' ' . $items['image']; ?>
                </div>
            </form>

            <div class="retour">
                <button><a href="index.php">retour</a></button>
            </div>
        </div>

        <div class="colone2">
            <div class="block">
                <div class="image">
                    <img src="<?php echo '../images/' . $items['image'];?>" alt="">
                </div>
                <div class="information">
                    <h3 class="soustitre"><?php echo ' ' . $items['nom']; ?></h3>
                    <p class="prix"><?php echo ' ' . number_format($items['prix'], 2, '.', '') . '£'; ?></p>
                    <p class="description"><?php echo ' ' . $items['description']; ?></p>
                </div>
                <div class="boutton">
                    <button><i class="fas fa-shopping-cart"></i> Commander</button>
                </div>
            </div>
        </div>
    </div>

</body> 

</html>