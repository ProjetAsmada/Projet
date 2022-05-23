<h1>Page de gestion des bénévoles</h1>
<table class="table text-center">
        <tr class="table-dark">
            <th>Login</th>
            <th>Statut du compte</th>
            <th>Rôle</th>
            <th colspan="1">Actions</th>
        </tr>
        <?php foreach ($utilisateurs as $utilisateur) : ?>
            <tr>
                <td><?= $utilisateur['login'] ?></td>
                <!-- choix de la validité du compte !-->
                <td>
                    <form method="POST" action="<?= URL ?>administration/validation_modificationValidationCompte">
                        <input type="hidden" name="login" value="<?= $utilisateur['login'] ?>" />
                        <select class="form-select" name="est_valide" onchange="confirm('confirmez vous la modification ?') ? submit() : document.location.reload()">
                            <option value=1 <?= $utilisateur['est_valide'] === 1 ? "selected" : "" ?>>Compte validé</option>
                            <option value=0 <?= $utilisateur['est_valide'] === 0 ? "selected" : "" ?>>Compte non validé</option>
                        </select>
                    </form>
                </td>
                <!-- choix du role !-->
                <td>
                    <form method="POST" action="<?= URL ?>administration/validation_modificationRole">
                        <input type="hidden" name="login" value="<?= $utilisateur['login'] ?>" />
                        <select class="form-select" name="role" onchange="confirm('confirmez vous la modification ?') ? submit() : document.location.reload()">
                            <option value="utilisateur" <?= $utilisateur['role'] === "utilisateur" ? "selected" : "" ?>>Utilisateur</option>
                            <option value="administrateur" <?= $utilisateur['role'] === "administrateur" ? "selected" : "" ?>>Administrateur</option>
                        </select>
                    </form>
                </td>
                <!-- suppression !-->
                <td class="align-middle">
                    <form method="POST" action="<?= URL ?>administration/suppression_utilisateur" onclick="return confirm('Supprimer l\'utilisateur <?= $utilisateur['login'] ?> ?');">
                        <input type="hidden" name="login" value="<?= $utilisateur['login'] ?>" />
                        <button class="btn btn-danger" type="submit" >Supprimer</button>
                    </form>
                </td>

            </tr>
        <?php endforeach; ?>
  
</table>
<a class="btn btn-success" href="<?= URL ?>administration/ajout_utilisateur">Ajouter</a>