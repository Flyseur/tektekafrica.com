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

// Sélectionner tous les messages approuvés
$sql = "SELECT name, message, submission_date FROM contacts WHERE approved = TRUE ORDER BY submission_date DESC";
$result = $conn->query($sql);
?>

<section class="testimonials-section">
    <div class="container">
        <h2 class="section-title">Témoignages Clients</h2>
        <div class="testimonials-grid">
            <?php
            if ($result->num_rows > 0) {
                // Sortir chaque témoignage
                while($row = $result->fetch_assoc()) {
                    echo '<div class="testimonial-card">';
                    echo '<h4>' . htmlspecialchars($row['name']) . '</h4>';
                    echo '<p class="testimonial-text">' . htmlspecialchars($row['message']) . '</p>';
                    echo '<p class="testimonial-date">' . htmlspecialchars($row['submission_date']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>Aucun témoignage disponible pour le moment.</p>';
            }
            ?>
        </div>
    </div>
</section>

<?php
$conn->close();
?>
