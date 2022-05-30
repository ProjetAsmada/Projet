<h1>Création de compte</h1>
<form method="POST" action="validation_creerCompte">
    <div class="mb-3">
        <label for="login" class="form-label">Login</label>
        <input type="text" class="form-control" id="login" name="login" required>
    </div>
    <div class="mb-3">
        <label for="prenom" class="form-label">Prenom</label>
        <input type="text" class="form-control" id="prenom" name="prenom" required>
    </div>
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" required>
    </div>
    <div class="mb-3">
        <label for="telephone" class="form-label">Telephone</label>
        <input type="text" class="form-control" id="telephone" name="telephone" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="mail" class="form-label">mail</label>
        <input type="mail" class="form-control" id="mail" name="mail" required>
    </div>

    <button type="submit" class="btn btn-primary">Créer !</button>
</form>