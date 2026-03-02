<?php 
session_start();
require_once "../config/db.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["mot_de_passe"];

    $stmt = $pdo->prepare("SELECT * FROM Users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["mot_de_passe"])) {
        $_SESSION["user_id"] = $user["id_user"];
        $_SESSION["role"] = $user["role"];
        header("Location: index.php");
        exit;
    } else {
        $error = "Email ou mot de passe incorrect";
    }
}
?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h4 class="text-center mb-4">Connexion GLRB</h4>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Mot de passe</label>
                    <input type="password" name="mot_de_passe" class="form-control" required>
                </div>

                <button class="btn btn-primary w-100">Connexion</button>
            </form>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>