<?php
require_once("../config/config.php");
require_once("../include/html.header.inc.php");
if (isset($_SESSION['user'])) {
    header("Location: ./index.php");
    exit();
}
?>

<body>
    <main style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <section style="margin-top: 10%; margin-bottom: 5%; ">
            <h1>Bienvenue sur votre gestionnaire des paiements et impayés !</h1>
        </section>
        <div>
            <a id="logBtn" href="#">Se connecter</a>
            <a id="regBtn" href="#">S'inscrire</a>
        </div>
        <section class="login-section" style="width: 30%; display:none;">
            <form class="form" action="./controller/authentification.php" method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Identifiant</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Identifiant">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Mot de passe</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe">
                </div>
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>

            </form>
        </section>
        <section class="register-section" style="width: 30%;">
            <form class="form" action="./controller/authentification.php" method="POST">
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