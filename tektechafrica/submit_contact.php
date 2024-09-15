<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";  // Remplacez par votre nom d'utilisateur MySQL
$password = "";      // Remplacez par votre mot de passe MySQL
$dbname = "tektech_africa";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données du formulaire et les assainir
$name = htmlspecialchars($_POST['name']);
$contact = htmlspecialchars($_POST['contact']);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars($_POST['message']);

// Vérifier si l'e-mail est valide
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>
            alert('Erreur : Veuillez entrer une adresse e-mail valide.');
            window.history.back(); // Retour à la page précédente
          </script>";
    exit();
}

// Vérifier si le domaine de l'e-mail existe
$domain = substr(strrchr($email, "@"), 1); // Extraire le domaine de l'email
if (!checkdnsrr($domain, "MX")) {
    echo "<script>
            alert('Erreur : Le domaine de l’adresse e-mail n’existe pas.');
            window.history.back(); // Retour à la page précédente
          </script>";
    exit();
}

// Utiliser une requête préparée pour éviter les injections SQL et ajouter automatiquement les messages
$stmt = $conn->prepare("INSERT INTO contacts (name, contact, email, message, approved) VALUES (?, ?, ?, ?, ?)");
$approved = TRUE; // Mettre à TRUE pour approuver automatiquement
$stmt->bind_param("ssssi", $name, $contact, $email, $message, $approved);

if ($stmt->execute()) {
    // Afficher un message de succès et rediriger vers la page d'accueil
    echo "<script>
            alert('Votre message a été envoyé avec succès.');
            window.location.href='index.html';
          </script>";
} else {
    // Afficher un message d'erreur si l'insertion échoue
    echo "Erreur : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>


