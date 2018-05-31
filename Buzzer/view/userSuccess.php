<div class="jumbotron">
  <?php $admin = $context->status == "admin"; ?>
  <h1 class="display-3">Bienvenue sur <?php echo ($admin?"votre Buzzer ":"le Buzzer de ");?> <span id="name"><?php echo $context->name;?></span></h1>
  <?php if($admin):  ?>
  <?php if(!$context->running): ?>
  <div id="startAdmin">
    <p class="lead">Posez la question aux étudiants, puis appuyez sur le boutton "Commencer".</p>
    <button type="button" onclick="start()" class="btn btn-primary btn-lg btn-block">Commencer</button>
    <button type="button" onclick="endSession()" class="btn btn-primary btn-lg btn-block">Fin de session</button>
  </div>
  <?php else: ?>
  <div id="resultsAdmin">
    <button type="button" onclick="show()" class="btn btn-primary btn-lg btn-block">Afficher les résultats</button>
    <div id="res">
      <button type="button" onclick="stop()" class="btn btn-primary btn-lg btn-block">Arrêter le buzzer</button>
      <p class="lead">Voici les résultats en direct.</p>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">position</th>
          </tr>
        </thead>
        <tbody id="studResult">
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>
  <?php else: ?>
  <?php if($context->running): ?>
  <p id="letsbuzz" class="lead">Cliquez sur le buzzer ou la barre espace <span class="pseudo"><?php echo (isset($_COOKIE["pseudo"])?$_COOKIE["pseudo"]:""); ?></span>.</p>
  <small id="nope" class="text-danger">Vous devez choisir un identifiant</small>
  <?php if(!isset($_COOKIE["pseudo"])): ?>
  <div id="idInfo">
    <div class="form-group">
      <label for="pseudo">Identidifiant</label>
      <input class="form-control" id="pseudo" aria-describedby="pseudo" placeholder="Entrez votre identidifiant" type="text">
    </div>
    <button type="button" onclick="validatePseudo()" class="btn btn-primary">S'identifier</button>
  </div>
  <?php endif; ?>
  <div class="buzz">
    <img src="images/buzz.jpg" onclick="buzz()" alt="buzzer">
  </div>
  <p id="buzzed" class="lead">Merci d'avoir buzzé <span class="pseudo"><?php echo (isset($_COOKIE["pseudo"])?$_COOKIE["pseudo"]:""); ?></span>.</p>
  <p id="alreadybuzzed" class="lead">Vous avez déjà buzzé. Veuillez attendre la prochaine question.</p>
  <?php else: ?>
  <p class="lead">Le buzzer n'est pas encore disponible, veuillez attendre le signal du professeur.</p>
  <?php endif; ?>
  <?php endif; ?>
  <hr class="my-4">

</div>

<script src="js/user.js">
</script>