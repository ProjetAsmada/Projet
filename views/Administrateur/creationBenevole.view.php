<h1>Page de création des bénévoles</h1>
<form method="POST" action="<?= URL ?>administration/validation_creationBenevole">
    <div class="form-group">
        <label for="login">Login</label>
        <input type="text" class="form-control" id="login" name="login">
    </div>

    <div class="form-group">
        <label for="password">Mot de passe temporaire</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>

    <div class="form-group">
        <label for="mail">Email</label>
        <input type="text" class="form-control" id="mail" name="mail">
    </div>

    <div class="form-group">
        <label for="est_valide">Statut</label>
        <select class="form-select" name="est_valide">
            <option>Compte validé</option>
            <option>Compte non validé</option>
        </select>
    </div>

    <div class="form-group">
        <label for="role">Role</label>
        <select class="form-select" name="role">
            <option>utilisateur</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Valider</button>
</form>