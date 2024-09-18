<?php 

if (isset($_POST['nom']) && isset($_POST['prenom'])){
echo 'Bonjour' . $_POST['nom'] . ' ' . $_POST['prenom'];
}


echo '<form action="supprimer.php" method="post">
<label for="nom">Nom:</label>
<input type="text" name="nom" placeholder="Nom">
<label for="prenom">Prenom:</label>
<input type="text" name="prenom" placeholder="Prenom">

<button type="submit">Envoyer</button>
</form>'
;
?>

