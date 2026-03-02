<?php
session_start();
require_once "../config/db.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Analyses urgentes
$stmtUrgent = $pdo->query("
    SELECT COUNT(*) AS total 
    FROM Analyses 
    WHERE observations IS NOT NULL
");
$urgentAnalyses = $stmtUrgent->fetch()["total"];

// Total échantillons
$stmtSamples = $pdo->query("
    SELECT COUNT(*) AS total 
    FROM Echantillons
");
$totalSamples = $stmtSamples->fetch()["total"];

// Stock critique
$stmtStock = $pdo->query("
    SELECT COUNT(*) AS total 
    FROM Stock 
    WHERE quantite <= seuil_alerte
");
$stockCritique = $stmtStock->fetch()["total"];

// Échantillons récents
$stmtRecent = $pdo->query("
    SELECT id_echantillon, code_unique, type_materiel, status
    FROM Echantillons
    ORDER BY date_prelevement DESC
    LIMIT 5
");
$echantillons = $stmtRecent->fetchAll();

$stmtUrgent = $pdo->query("
    SELECT COUNT(*) AS total
    FROM Echantillons
    WHERE status IN ('recu','en_cours')
");
$urgentAnalyses = $stmtUrgent->fetch()["total"];

?>


<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar vh-100 p-3">
            <h5 class="mb-4 text-primary fw-bold">GLRB Lab</h5>

            <ul class="nav flex-column gap-2">
                <li class="nav-item">
                    <a class="nav-link active fw-semibold" href="#">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Échantillons</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Analyses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Inventaire</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Paramètres</a>
                </li>
            </ul>

            <div class="position-absolute bottom-0 start-0 p-3 w-100">
                <small class="text-muted">Connecté : <?= $_SESSION["role"] ?></small>
            </div>
        </nav>

        <!-- MAIN CONTENT -->
        <main class="col-md-10 ms-sm-auto px-md-4 py-4">

            <!-- TOPBAR -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <input type="search" class="form-control w-50" placeholder="Rechercher échantillon, analyse...">
                <div>
                    <button class="btn btn-outline-secondary btn-sm">🔔</button>
                    <button class="btn btn-outline-secondary btn-sm">⚙️</button>
                </div>
            </div>

            <!-- STAT CARDS -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Analyses urgentes</h6>
                            <h3 class="text-danger"><?= $urgentAnalyses ?></h3>
                            <small class="text-danger">Action immédiate requise</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h6 class="text-muted">Stock critique</h6>
            <h3 class="text-warning"><?= $stockCritique ?></h3>
            <small>Produits sous le seuil</small>
        </div>
    </div>
</div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Température</h6>
                            <h5>Freezer -80°C : <span class="text-success">OK</span></h5>
                            <small class="text-success">Dans la norme</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Total échantillon</h6>
                            <h3><?= $totalSamples ?></h3>
                            <small>3 terminées • 5 en attente</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLE + ACTIVITY -->
            <div class="row">

                <!-- TABLE -->
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="mb-3">Échantillons récents</h6>

                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Statut</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php if (count($echantillons) === 0): ?>
    <tr>
        <td colspan="4" class="text-center text-muted">
            Aucun échantillon enregistré
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($echantillons as $e): ?>
        <tr>
            <td><?= htmlspecialchars($e["code_unique"]) ?></td>
            <td><?= htmlspecialchars($e["type_materiel"]) ?></td>
            <td>
                <?php
switch ($e["status"]) {
    case "recu":
        echo '<span class="badge bg-warning">Reçu</span>';
        break;

    case "en_cours":
        echo '<span class="badge bg-info">En cours</span>';
        break;

    case "termine":
        echo '<span class="badge bg-success">Terminé</span>';
        break;

    default:
        echo '<span class="badge bg-secondary">Inconnu</span>';
}
?>
            </td>
            <td>
                <a href="/public/echantillons/ajouteEchan.php" class="btn btn-sm btn-outline-primary">+ Ajouter</a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
</tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ACTIVITY -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="mb-3">Activités récentes</h6>
                            <ul class="list-group list-group-flush small">
                                <li class="list-group-item">Analyse BL-2026-003 terminée</li>
                                <li class="list-group-item">Stock réactif faible</li>
                                <li class="list-group-item">Nouvel échantillon ajouté</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>
</div>

<?php include "../includes/footer.php"; ?>