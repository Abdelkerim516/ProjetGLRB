<?php
session_start();
require_once "../../config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $code_unique = $_POST["code_unique"];
    $type_materiel = $_POST["type_materiel"];
    $emplacement = $_POST["emplacement"];
    $status = $_POST["status"];

    $stmt = $pdo->prepare("
        INSERT INTO Echantillons 
        (code_unique, type_materiel, emplacement, status)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $code_unique,
        $type_materiel,
        $emplacement,
        $status
    ]);

    header("Location: ../index.php");
    exit;
}
?>

<div class="container mt-4">
    <h4>Ajouter un échantillon</h4>

    <form method="post" class="card p-4 shadow-sm mt-3">

        <div class="mb-3">
            <label>Code unique</label>
            <input type="text" name="code_unique" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Type de matériel</label>
            <input type="text" name="type_materiel" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Emplacement</label>
            <input type="text" name="emplacement" class="form-control">
        </div>

        <div class="mb-3">
            <label>Statut</label>
            <select name="status" class="form-select">
                <option value="recu">Reçu</option>
                <option value="en_cours">En cours</option>
                <option value="termine">Terminé</option>
            </select>
        </div>

        <button class="btn btn-primary">Enregistrer</button>
        <a href="../index.php" class="btn btn-secondary">Annuler</a>

    </form>
</div>

<?php include "../../includes/footer.php"; ?>