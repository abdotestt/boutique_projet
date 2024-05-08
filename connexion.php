<?php
// Fonction pour rechercher un utilisateur par email dans le fichier CSV
function rechercherUtilisateur($email,$password, $fichierCSV) {
    // Ouvrir le fichier CSV en mode lecture
    $handle = fopen($fichierCSV, "r");
    if ($handle !== FALSE) {
        // Parcourir chaque ligne du fichier CSV
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Vérifier si l'email correspond à celui recherché
            if ($data[0] === $email && $data[1]===$password) {
                fclose($handle); // Fermer le fichier
                return $data; // Retourner les données de l'utilisateur
            }
        }
        fclose($handle); // Fermer le fichier s'il n'y a pas de correspondance
    }
    return NULL; // Retourner NULL si l'utilisateur n'est pas trouvé
}

// Exemple d'utilisation :
$emailRecherche = $_POST['email'];
$pwd =$_POST['password'];
$fichierCSV = "data.csv";

// Rechercher l'utilisateur dans le fichier CSV
$utilisateurTrouve = rechercherUtilisateur($emailRecherche,$pwd, $fichierCSV);

// Afficher les données de l'utilisateur s'il est trouvé
if ($utilisateurTrouve !== NULL) {
    session_start();
    $_SESSION['email'] =  $utilisateurTrouve[0];
    $_SESSION['name'] =  $utilisateurTrouve[2];
    $_SESSION['categories'] =  $utilisateurTrouve[3];
    $newURL = "index.php";
    header('Location: '.$newURL);
    echo "Utilisateur trouvé : " . $utilisateurTrouve[0];
} else {
    echo "Utilisateur non trouvé.";
}
?>

