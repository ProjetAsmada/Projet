<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- VISITEUR VOIT ACCUEIL/CONSULTATION MISSIONS/CREER COMPTE/SE CONNECTER !-->
    <!-- UTILISATEUR VOIT ACCUEIL/PROFIL/POSTULER MISSIONS/SE DECONNECTER !-->
    <!-- ADMINISTRATEUR VOIT ACCUEIL/SE DECONNECTER/ADMINISTRATION !-->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <?php if (!Securite::estConnecte()) : ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="https://www.asmada.org">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= URL; ?>missions">Consultation des missions</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= URL; ?>creerCompte">Créer compte</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= URL; ?>login">Se connecter</a>
          </li>
        <?php endif; ?>
        <?php if (Securite::estConnecte() && Securite::estUtilisateur()) : ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= URL; ?>accueil">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= URL; ?>compte/profil">Profil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= URL; ?>compte/missions">Candidater aux Missions</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= URL; ?>compte/mesCandidatures">Mes candidatures</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= URL; ?>compte/autoevaluation">S'auto évaluer</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= URL; ?>compte/deconnexion">Se déconnecter</a>
          </li>
        <?php endif; ?>
        <?php if (Securite::estConnecte() && Securite::estAdministrateur()) : ?>
          <a class="nav-link" aria-current="page" href="<?= URL; ?>accueil">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= URL; ?>compte/deconnexion">Se déconnecter</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Administration
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="<?= URL; ?>administration/gestionBenevoles">Gérer les bénévoles</a></li>
              <li><a class="dropdown-item" href="<?= URL; ?>administration/gestionAdministrateurs">Gérer les administrateurs</a></li>
              <li><a class="dropdown-item" href="<?= URL; ?>administration/gestionMissions">Gérer les missions</a></li>
              <li><a class="dropdown-item" href="<?= URL; ?>administration/gestionCandidatures">Gérer les candidatures</a></li>
              <li><a class="dropdown-item" href="<?= URL; ?>administration/gestionTests">Gérer les tests</a></li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>