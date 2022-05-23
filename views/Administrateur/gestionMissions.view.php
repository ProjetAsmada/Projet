<h1>Page de gestion des missions</h1>
<table class="table text-center">
    <thead>
        <tr class="table-dark">
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Description</th>
            <th scope="col" colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($missions as $mission) : ?>
                <tr>
                    <td><?= $mission['id_mission'] ?></td>
                    <td><?= $mission['nom_mission'] ?></td>
                    <td><?= $mission['description_mission'] ?></td>
                    <!-- modification !-->
                    <td class="align-middle">
                        <form method="POST" action="<?= URL ?>administration/modification_mission/<?=$mission['id_mission']?>">
                            <input type="hidden" name="id_mission" value="<?= $mission['id_mission'] ?>" />
                            <button class="btn btn-warning" type="submit">Modifier</button>
                        </form>
                    </td>
                    <!-- suppression !-->
                    <td class="align-middle">
                        <form method="POST" action="<?= URL ?>administration/suppression_mission" onclick="return confirm('Supprimer la mission <?= $mission['nom_mission'] ?> ?');">
                            <input type="hidden" name="id_mission" value="<?= $mission['id_mission'] ?>" />
                            <button class="btn btn-danger" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a class="btn btn-success" href="<?= URL ?>administration/ajout_mission">Ajouter</a>