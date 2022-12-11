<?php
require_once("../config/config.php");
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Projet du BUT Informatique">
    <meta name="author" content="Delmas Denis, Edmee Léon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../files/style.css?v<?= time() ?>">

    <title>💸Capgénépi Banque💸</title>
    <link rel="icon" href="../files/img/genepi.png">
</head>
<?php
if (isset($_SESSION['user'])) {
    header("Location: ./index.php");
    exit();
}

// bootstrap alert
$display = "none";
$alert = "alert-danger";
$message = "Attention : Ceci est votre dernier essai";

$bloquer_formulaire = false;

if (isset($_SESSION["wrong_auth"])) {
    if ($_SESSION["wrong_auth"] == 2) {
        $display = "block";
    } else {
        $display = "none";
    }
}
if (isset($_SESSION["connexion_blocked"]) && $_SESSION["connexion_blocked"] == true) {
    $display = "block";
    $alert = "alert-danger";
    $message = "Vous avez entré trop de mauvais identifiants. Vous êtes bloqué";
    $bloquer_formulaire = true;
}


?>

<body>
    <style>
        body {
            background-image: url("../files/img/genepi.png");
            background-repeat: no-repeat;
            background-size: 47%;

        }


        section {
            font-weight: bold;
        }
    </style>
    <main style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <section style="margin-top: 10%; margin-bottom: 5%; ">
            <h1><strong> Bienvenue sur votre gestionnaire des paiements et impayés !</strong></h1>
        </section>
        <div>
            <h1>Se connecter</h1>
        </div>
        <section class="login-section" style="width: 30%; ">
            <fieldset id="fieldset" <?php if ($bloquer_formulaire) {
                                        echo "disabled";
                                    }   ?>>
                <form class="form" method="POST" action="../controller/login.php" disabled>
                    <div class="form-group">
                        <label for="login">Identifiant</label>
                        <input type="text" class="form-control" id="login" name="login" aria-describedby="emailHelp" placeholder="Identifiant" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                        <!-- show password -->
                        <a href="#" id="click-password" onclick="showPassword()">
                            <input type="checkbox" id="cb-password">👁️Afficher le mot de passe 👀
                        </a>
                    </div>
                    <br>
                    <small id="emailHelp" class="form-text text-muted">Nous ne partagerons jamais votre mot de passe avec qui que ce soit, faites-en de même</small>

                    <br>
                    <button type="submit" class="btn btn-primary"> 😜 Se connecter 😛</button>
                </form>
            </fieldset>
            <!-- bootstrap alert -->
            <div class="alert <?= $alert ?>" role="alert" style="display: <?= $display ?>; margin-top: 10px;">
                <?= $message ?>
            </div>
        </section>



    </main>
    <script>
        function showPassword() {
            var inputPassword = document.getElementById("password");
            var checkBoxPassword = document.getElementById("cb-password");
            var fieldset = document.getElementById("fieldset");
            if (fieldset.disabled == true) {
                return;
            }
            if (inputPassword.type === "password") {
                checkBoxPassword.checked = true;
                inputPassword.type = "text";
            } else {
                checkBoxPassword.checked = false;
                inputPassword.type = "password";
            }
        }
    </script>











</body>