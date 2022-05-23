<h1>Page de gestion des administrateurs</h1>
<table class="table text-center">
        <tr class="table-dark">
            <th>Login</th>
            <th>Statut du compte</th>
            <th>Rôle</th>
            <th colspan="2">Actions</th>
        </tr>
        <?php foreach ($administrateurs as $administrateur) : ?>
            <tr>
                <td><?= $administrateur['login'] ?></td>
                <!-- choix de la validité du compte !-->
                <td>
                    <form method="POST" action="<?= URL ?>administration/validation_modificationValidationCompteAdministrateur">
                        <input type="hidden" name="login" value="<?= $administrateur['login'] ?>" />
                        <select class="form-select" name="est_valide" onchange="confirm('confirmez vous la modification ?') ? submit() : document.location.reload()">
                            <option value=1 <?= $administrateur['est_valide'] === 1 ? "selected" : "" ?>>Compte validé</option>
                            <option value=0 <?= $administrateur['est_valide'] === 0 ? "selected" : "" ?>>Compte non validé</option>
                        </select>
                    </form>
                </td>
                <!-- choix du role !-->
                <td>
                    <form method="POST" action="<?= URL ?>administration/validation_modificationRoleAdministrateur">
                        <input type="hidden" name="login" value="<?= $administrateur['login'] ?>" />
                        <select class="form-select" name="role" onchange="confirm('confirmez vous la modification ?') ? submit() : document.location.reload()">
                            <option value="utilisateur" <?= $administrateur['role'] === "utilisateur" ? "selected" : "" ?>>Utilisateur</option>
                            <option value="administrateur" <?= $administrateur['role'] === "administrateur" ? "selected" : "" ?>>Administrateur</option>
                        </select>
                    </form>
                </td>
                <!-- suppression !-->
                <td class="align-middle">
                    <form method="POST" action="<?= URL ?>administration/suppression_administrateur" onclick="return confirm('Supprimer l\'administrateur <?= $administrateur['login'] ?> ?');">
                        <input type="hidden" name="login" value="<?= $administrateur['login'] ?>" />
                        <button class="btn btn-danger" type="submit" >Supprimer</button>
                    </form>
                </td>

            </tr>
        <?php endforeach; ?>
</table>
<a class="btn btn-success" href="<?= URL ?>administration/ajout_administrateur">Ajouter</a>