<?php
     ini_set('display_errors', 1);
     ini_set('display_startup_errors', 1);
     error_reporting(E_ALL);

    require 'database.php';

    if(!empty($_GET['id'])){
        $id = checkInput($_GET['id']);
    }

    $nomErreur = $descriptionErreur = $prixErreur = $categorieErreur = $imageErreur = $nom = $description = $prix = $categorie = $image = "";

    if(!empty($_POST))
    {
        $nom                    = checkInput($_POST['nom']);
        $description            = checkInput($_POST['description']);
        $prix                   = checkInput($_POST['prix']);
        $categorie              = checkInput($_POST['categorie']);
        $image                  = checkInput($_FILES['image']['name']);
        $imagePath              = '../images/' . basename($image);
        $imageExtension         = pathinfo($imagePath, PATHINFO_EXTENSION);    //png ou gif ou gpg
        $isSuccess              = true;

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
            $isImageUpdated = false;
        }
        else{
            $isImageUpdated = true;
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

        if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated))
        {
            $db = Database::connect();
            if ($isImageUpdated)
            {
                $statement = $db->prepare("UPDATE items set nom= ?, description= ?, prix= ?, categorie= ?, image= ? WHERE id= ?");
                $statement->execute(array($nom,$description,$prix,$categorie,$image,$id));
            }
            else
            {
                $statement = $db->prepare("UPDATE items set nom= ?, description= ?, prix= ?, categorie= ? WHERE id= ?");
                $statement->execute(array($nom,$description,$prix,$categorie,$id));
            }
            Database::disconnect();
            header("Location: index.php");     //retourne à la page index.php
        } 
        else if($isImageUpdated && !$isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("SELECT image FROM items WHERE id = ?");
            $statement->execute(array($id));
            $items = $statement->fetch();
            $image            = $items['image'];
            Database::disconnect();
        }

    }
    else
    {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM items WHERE id = ?");
        $statement->execute(array($id));
        $items = $statement->fetch();
        $nom              = $items['nom'];
        $description      = $items['description'];
        $prix             = $items['prix'];
        $categorie        = $items['categorie'];
        $image            = $items['image'];
        Database::disconnect();
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
    <title>Pizza Code Modifier</title>
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
                <h1><strong>Modifier un elements</strong></h1>
            </div>

            <form action="<?php echo 'modifier.php?id=' . $id;?>" role="form" method="post"
                enctype="multipart/form-data">
                <!-- enctype: pour inserer l'image -->
                <div class="champ">
                    <label for="nom">Nom:</label><br>
                    <input type="text" id="nom" name="nom" placeholder="Nom" value="<?php echo $nom;?>" required>
                    <span class="erreur"><?php echo $nomErreur; ?></span>
                </div>
                <div class="champ">
                    <label for="description">Description:</label><br>
                    <input type="text" id="description" name="description" placeholder="Description"
                        value="<?php echo $description; ?>">
                    <span class="erreur"><?php echo $descriptionErreur; ?></span>
                </div>
                <div class="champ">
                    <label for="prix">Prix: (en $)</label><br>
                    <input type="number" step="0.01" id="prix" name="prix" placeholder="Prix"
                        value="<?php echo $prix; ?>">
                    <span class="erreur"><?php echo $prixErreur; ?></span>
                </div>
                <div class="champ">
                    <label for="categorie">Categorie:</label><br>
                    <select id="categorie" name="categorie" value="<?php echo $categorie;?>">
                        <?php
                        $db = Database::connect();
                        foreach($db->query('SELECT * FROM categories') as $row)         //voici une autre maniere d'ecrire. Je pense que tu peut commême utiliser statement='REQUETTE'  
                        {
                            if ($row["id"] == $categorie)
                                echo '<option selected="selected" value="' . $row['id'] .'">' .$row['nom'] . '</option>';
                            else 
                                echo '<option value="' . $row['id'] .'">' .$row['nom'] . '</option>';
                        }
                        Database::disconnect(); 
                    ?>
                    </select>
                    <span class="erreur"><?php echo $categorieErreur; ?></span>
                </div>
                <div class="champ">
                    <label for="">Image:</label>
                    <p><?php echo $image; ?></p>
                    <label for="image">Selectionner une image</label>
                    <input type="file" id="image" name="image" value="<?php echo $image; ?>">
                    <span class="erreur"><?php echo $imageErreur; ?></span>
                </div>

                <div class="ajouter">
                    <button type="submit"><i class="fas fa-plus"></i> Modifier</button>
                </div>
                <div class="retour">
                    <button><a href="index.php">retour</a></button>
                </div>
            </form>
        </div>
        <div class="colone2">
            <div class="block">
                <div class="image">
                    <img src="<?php echo '../images/' . $image;?>" alt="">
                </div>
                <div class="information">
                    <h3 class="soustitre"><?php echo ' ' . $nom ?></h3>
                    <p class="prix"><?php echo ' ' . number_format($prix, 2, '.', '') . '£'; ?></p>
                    <p class="description"><?php echo ' ' . $description; ?></p>
                </div>
                <div class="boutton">
                    <button><i class="fas fa-shopping-cart"></i> Commander</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>