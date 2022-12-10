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
    <link rel="stylesheet" href="../files/style.css">

    <title>Capgénépi Banque</title>
    <link rel="icon" href="../files/img/genepi.png">
</head>
<?php
if (isset($_SESSION['user'])) {
    header("Location: ./index.php");
    exit();
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
            <h1>Bienvenue sur votre gestionnaire des paiements et impayés !</h1>
        </section>
        <div>
            <a id="logBtn" href="#">Se connecter</a>
            <a id="regBtn" href="#">S'inscrire</a>
        </div>
        <section class="login-section" style="width: 30%; ">
            <form class="form" method="POST" action="../controller/login.php">
                <div class="form-group">
                    <label for="exampleInputEmail1">Identifiant</label>
                    <input type="text" class="form-control" id="login" name="login" aria-describedby="emailHelp" placeholder="Identifiant" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                </div>
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>

            </form>
        </section>
        <section class="register-section" style="width: 30%; display:none; ">
            <form class="form" action="./controller/auth.php" method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Identifiant</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Identifiant">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Mot de passe</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Courriel</label>
                    <input type="mail" class="form-control" id="exampleInputPassword1" placeholder="exemple@mail.fr">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Nom</label>
                    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Tran">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Prénom</label>
                    <input type="prenom" class="form-control" id="exampleInputPassword1" placeholder="Louis">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Jeton d'inscription</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="E45745ABD">
                </div>
                <button type="submit" class="btn btn-primary">Créer le compte</button>
            </form>

            </form>
        </section>


    </main>


    <script>
        const loginBtn = document.querySelector("#logBtn");
        const resisterBtn = document.querySelector("#regBtn");
        const loginSection = document.querySelector(".login-section");
        const registerSection = document.querySelector(".register-section");
        loginBtn.addEventListener("click", () => {
            loginSection.style.display = "block";
            registerSection.style.display = "none";
        })
        resisterBtn.addEventListener("click", () => {
            loginSection.style.display = "none";
            registerSection.style.display = "block";
        })
    </script>









</body>