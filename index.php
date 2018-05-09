<?php 
require_once('pdo.php');
?>
<!DOCTYPE html>
<html>
        <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <script src="https://www.google.com/recaptcha/api.js"></script>
                <link rel="icon" type="image/png" href="logo.png" />
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
                <title>Re-Captcha</title>
                <style>
                .alert {
                        margin-top: 15px;
                }
                .table {
                        margin-top: 15px;
                }
                </style>
        </head>
        <body>
                <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-body">
                                        <h1>Workshop: Comment intégrer Re-captcha à son site web<br/></h1>
                                        <form method="POST" action="">
                                                <?php
                                                        if (isset($_POST['submit'])) {
                                                                $pseudo = htmlspecialchars(trim($_POST['pseudo']));
                                                                if (empty($pseudo)) {
                                                                        echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                                                                                <strong>Erreur: </strong>Il faut rentrer un pseudo!
                                                                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Fermer\">
                                                                                <span aria-hidden=\"true\">&times;</span>
                                                                                </button>
                                                                                </div>";
                                                                        } else if (isset($_POST['g-recaptcha-response'])) {
                                                                        $secret = "private_key";
                                                                        $response = $_POST['g-recaptcha-response'];
                                                                        $remoteip = $_SERVER['REMOTE_ADDR'];
                                                                                                
                                                                        $api_url = "https://www.google.com/recaptcha/api/siteverify?secret=" 
                                                                                . $secret
                                                                                . "&response=" . $response
                                                                                . "&remoteip=" . $remoteip ;
                                                                                                
                                                                        $decode = json_decode(file_get_contents($api_url), true);
                                                                                                
                                                                        if ($decode['success'] == true) {
                                                                                $req = $bdd->prepare('INSERT INTO captcha(pseudo) VALUES(:pseudo)');
                                                                                $req->execute(array('pseudo' => $pseudo));
                                                                                echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                                                                                        Félicitation, <strong>".$pseudo."</strong> est bien ajouté à la liste!
                                                                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Fermer\">
                                                                                        <span aria-hidden=\"true\">&times;</span>
                                                                                        </button>
                                                                                        </div>";
                                                                        } else {
                                                                                echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                                                                                        <strong>Erreur: </strong>Il faut valider le captcha !
                                                                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Fermer\">
                                                                                        <span aria-hidden=\"true\">&times;</span>
                                                                                        </button>
                                                                                        </div>";
                                                                        }
                                                                }
                                                        }
                                                                                
                                                ?>
                                                <div class="form-group">
                                                        <label for="pseudo">Pseudo: </label>
                                                        <input type="pseudo" class="form-control" id="pseudo" placeholder="Pseudo" name="pseudo">
                                                </div>
                                                <div class="g-recaptcha" data-sitekey="public_key">
                                                </div><br/>
                                                <button type="submit" class="btn btn-primary" name="submit">Envoyer</button>
                                        </form>
                                        <table class="table table-hover">
                                                <thead>
                                                        <tr>
                                                                <th scope="col">n°</th>
                                                                <th scope="col">Pseudo</th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                        <?php
                                                                $reponse = $bdd->query('SELECT * FROM captcha');

                                                                while ($donnees = $reponse->fetch()) {
                                                        ?>
                                                        <tr>
                                                                <th scope="row"><?php echo htmlspecialchars($donnees['id']); ?></th>
                                                                <td><?php echo htmlspecialchars($donnees['pseudo']);?></td>
                                                        </tr>
                                                        <?php
                                                                }
                                                                $reponse->closeCursor();
                                                        ?>
                                                </tbody>
                                        </table>
                                </div>
                        </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        </body>
</html>