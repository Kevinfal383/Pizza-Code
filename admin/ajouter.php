<?php
    require 'database.php';

    $nomErreur = $descriptionErreur = $prixErreur = $categorieErreur = $imageErreur = $nom = $description = $prix = $categorie = $image = "";

    if(!empty($_POST))
    {
        $nom                    = checkInput($_POST['nom']);
        $description            = checkInput($_POST['description']);
        $prix                   = checkInput($_POST['prix']);
        $categorie              = checkInput($_POST['categorie']);
        $image                  = checkInput($_FILES['image']['name']);
        $imagePath              = '../images/' . basename($image);
        $imageExtension        = pathinfo($imagePath, PATHINFO_EXTENSION);    //png ou gif ou gpg
        $isSuccess              = true;
        $isUploadSuccess        = false;

        if(empty($nom)){
            $nomErreur = 'Veuiller remplir ce champ.';
            $isSuccess = false;
        }
        if(empty($description)){
            $descriptionErreur = 'Veuiller remplir ce champ.';
            $isSuccess = false;
        }
        if(empty($prix)){
            $prixErreur = 'Veuiller remplir ce champ.';
            $isSuccess = false;
        }
        if(empty($categorie)){
            $categorieErreur = 'Veuiller remplir le champ.';
            $isSuccess = false;
        }
        if(empty($image)){
            $imageErreur = 'Ce champ ne peut pas etre vide';
            $isSuccess = false;
        }
        else{
            $isUploadSuccess = true;
            if ($imageExtension != "jpg" && $imageExtension != "jpeg" && $imageExtension != "png" && $imageExtension != "gif")
            {
                $imageErreur = "Les fichiers autorisés sont: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }
            if(file_exists($imagePath))
            {
                $imageErreur = "Le fichier existe deja";
                $isUploadSuccess = false;
            }
            if($_FILES['image']['size'] > 500000)
            {
                $imageErreur = "Le fichier ne doit pas depasser les 500KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess)
            {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath))
                {
                    $imageErreur = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                }
            }
        }

        if($isSuccess && $isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO items (nom, description, prix, categorie, image) values(?, ?, ?, ?, ?)");
            $statement->execute(array($nom, $description, $prix, $categorie, $image));
            Database::disconnect();
            header("Location: index.php");     //retourne à la page index.php
        }
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
            <h1><strong>Ajouter un element elements</strong></h1>
            <div class="ajouter">
                <button><i class="fas fa-add"></i> Ajouter</button>
            </div>
        </div>

        <form action="ajouter.php" role="form" method="post" enctype="multipart/form-data">     <!-- enctype: pour inserer l'image -->
            <div class="champ"> 
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" placeholder="Nom" value="<?php echo $nom;?>" required>
                <span class="erreur"><?php echo $nomErreur; ?></span>
            </div>
            <div class="champ">
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                <span class="erreur"><?php echo $descriptionErreur; ?></span>
            </div>
            <div class="champ">
                <label for="prix">Prix: (en $)</label>
                <input type="number" step="0.01" id="prix" name="prix" placeholder="Prix" value="<?php echo $prix; ?>">
                <span class="erreur"><?php echo $prixErreur; ?></span>
            </div>
            <div class="champ">
                <label for="categorie">Categorie:</label>
                <select id="categorie" name="categorie" value="<?php echo $categorie;?>">
                    <?php
                        $db = Database::connect();
                        foreach($db->query('SELECT * FROM categories') as $row)         //voici une autre maniere d'ecrire. Je pense que tu peut commême utiliser statement='REQUETTE'  
                        {
                            echo '<option value="' . $row['id'] .'">' .$row['nom'] . '</option>';
                        }
                        Database::disconnect();


                    ?>
                </select>
                <span class="erreur"><?php echo $categorieErreur; ?></span>
            </div>
            <div class="champ">
                <label for="image">Selectionner une image</label>
                <input type="file" id="image" name="image" value="<?php echo $image; ?>">
                <span class="erreur"><?php echo $imageErreur; ?></span>
            </div>

            <div class="ajouter">
                <button type="submit"><i class="fas fa-plus"></i> Ajouter</button>
            </div>
            <div class="retour">
                <button><a href="index.php">retour</a></button>
            </div>
        </form>

    </div>

</body>

</html>