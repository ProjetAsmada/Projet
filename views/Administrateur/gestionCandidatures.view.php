<h1>Page de gestion des candidatures</h1>
<table class="table text-center">
    <thead>
        <tr class="table-dark">
            <th>Prénom du candidat</th>
            <th>Nom du candidat</th>
            <th>Mission</th>
            <th>Catégorie du questionnaire</th>
            <th>Score</th>
            <th scope="col" colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($candidatures as $candidature) : ?>
                <tr>
                <td><?= $candidature['prenom'] ?></td>
                <td><?= $candidature['nom'] ?></td>
                <td><?= $candidature['nom_mission'] ?></td>
                <td>Catégorie du questionnaire</td>
                <td>Score</td>
                <td><button>Accepter</button></td>
                <td><button>Refuser</button></td>
                </tr>
        <?php endforeach; ?>
    </tbody>
</table>