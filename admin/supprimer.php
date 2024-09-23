<?php
    require 'database.php';

    if(!empty($_GET['id'])){
        $id = checkInput($_GET['id']);
    }

    if(!empty($_POST)){
        $id = checkInput($_POST['id']);
        $db = Database::connect();
        $statement = $db->prepare("DELETE FROM items where id = ?");
        $statement->execute(array($id));
        Database::disconnect();
        header("Location: index.php");
    }

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
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <title>Pizza Code Admin Ajouter</title>
</head>

<body>
    <div class="header">
        <div class="titre">
            <h1><i class="fas fa-utensils"></i> <span>PIZZA CODE</span> <i class="fas fa-utensils"></i></h1>
        </div>
    </div>

    <div class="admin">
        <div class="titre">
            <h1><strong>Supprimer un element</strong></h1>
        </div>

        <form action="supprimer.php" role="form" method="post">     <!-- enctype: pour inserer l'image -->

            <input type="hidden" name="id" value="<?php echo $id ?>">
            <p>Etes vous sure de vouloir supprimer ?</p>

            <div class="ajouter">
                <button type="submit">Oui</button>
            </div>
            <div class="retour">
                <button><a href="index.php">Non</a></button>
            </div>
        </form>

    </div>

</body>

</html>