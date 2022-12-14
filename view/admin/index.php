<?php

require_once("../../config/config.php");

if (($_SESSION['user'] == null)  ||  ($_SESSION['role'] != "ADMIN")) {
    header("Location: ../account_auth.php");
}

require_once("../../include/html.header.inc.php");


?>

<nav id="header_nav">
    <h1>Gestionnaire de paiements</h1>
    <h2 id="name"> <?= $_SESSION['prenom'] . " " . $_SESSION['nom'] ?></h2>
    <a onclick="logout()" href="../index.php">Deconnexion</a>
</nav>
<article class="flex_column m-auto mt-5">
    <h1>Ajouter un compte client</h1>



    <dialog id="dialog_transac">
        <div class="dialog_header">
            <button id="dialog_close" onclick="close_dialog()">X</button><br><br>
            <h1 class="dialog_title"></h1>
        </div>
        <div class="dialog_content">
        </div>
    </dialog>
    <script defer>
        function open_dialog() {
            console.log("open dialog");
            document.getElementById("dialog_transac").showModal();
        }

        function close_dialog() {
            console.log("close dialog");
            document.getElementById("dialog_transac").close();
        }
        // click outside the dialog 
        document.getElementById("dialog_transac").addEventListener("click", function(event) {
            if (event.target == this) {
                close_dialog();
            }
        });
    </script>

    <form class="admin_form">
        <div>
            <input id="SIREN" type="text" placeholder="SIREN" min="9" max="9">
        </div>
        <div>
            <input id="libelle" type="text" placeholder="Raison sociale" min="1" max="50">
        </div>
        <div>
            <input id="login" type="text" placeholder="Identifiant de connexion">
        </div>
        <div>
            <input id="email" type="email" placeholder="tran@capgemini.eu">
        </div>
        <div>
            <input id="nom" type="text" placeholder="TRAN">
        </div>
        <div>
            <input id="prenom" type="text" placeholder="Louis">
        </div>

        <div>
            <input id="password" type="password" placeholder="Mot de passe">
        </div>
        <div>
            <input id="password_confirm" type="password" placeholder="Confirmer Mot de passe">
        </div>
        <!-- Add a check box -->
        <div>
            <input type="checkbox" id="checkbox" name="checkbox" value="checkbox" required>
            <label for="checkbox">J'ai eu l'accord du PO</label>
        </div>
        <button id="btn_recherche">Ajouter</button>



    </form>

    <script defer>
        
        // make post request to API
        const btn_recherche = document.getElementById("btn_recherche");
        const password = document.getElementById("password");
        const password_confirm = document.getElementById("password_confirm");


        btn_recherche.addEventListener("click", function() {
            event.preventDefault();
            // check if the checkbox is checked

            const checkbox = document.getElementById("checkbox");
            if (!checkbox.checked) {
                alert("Vous devez avoir l'accord du PO Mr Tran pour réaliser cette action !!!");
            }
            else if (password.value != password_confirm.value) {
                alert("Les mots de passe ne correspondent pas");
            } else
            
            {
                const data = {
                    "SIREN": document.getElementById("SIREN").value,
                    "libelle": document.getElementById("libelle").value,
                    "login": document.getElementById("login").value,
                    "password": document.getElementById("password").value,
                    "email": document.getElementById("email").value,
                    "nom": document.getElementById("nom").value,
                    "prenom": document.getElementById("prenom").value,
                    "role": "CLIENT"
                }
                const options = {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data),
                    credentials: "include"

                }

                fetch("../../api/compte.php", options)
                    .then(response => response.json())
                    .then(data => {
                        showStatus(200);
                    })
                    .catch(error => {
                        showStatus("error");
                    });






            }
        });


        function showStatus(status) {
            const dialog_title = document.querySelector(".dialog_title");
            const dialog_content = document.querySelector(".dialog_content");

            if (status == 200) {
                dialog_title.innerHTML = "Compte ajouté avec succès";
                dialog_content.innerHTML = "Le compte et le client ont été ajoutés avec succès. <br> Il peut désormais se connecter avec les identifiants fournis.<br> RAPPEL :";
                dialog_content.innerHTML += "<br>Identifiant : " + document.getElementById("login").value;
                dialog_content.innerHTML += "<br>SIREN: " + document.getElementById("SIREN").value;

            } else {
                dialog_title.innerHTML = "Erreur lors de l'ajout du compte";
                dialog_content.innerHTML = "Certaines informations sont manquantes ou invalides. Veuillez vérifier les informations saisies.";
            }
            open_dialog();
            // $("form").trigger("reset");
        }
    </script>
</article>