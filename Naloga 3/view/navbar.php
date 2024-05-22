<nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="position: sticky; top: 0; z-index: 10;">
  <a class="navbar-brand" href="<?=BASE_URL . "index"?>">FilmBuzz</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?=BASE_URL . "view/add-film"?>">Dodaj film</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <?php if (isset($_SESSION["username"])) { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL . "user/info"?>"><?=$_SESSION["username"]?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" style="color: red;" href="<?= BASE_URL . "user/logout"?>">Odjava</a>
        </li>
      <?php } else { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL . "view/login"?>">Prijava</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL . "view/register"?>">Registracija</a>
        </li>
      <?php } ?>  
    </ul>
  </div>  
</nav>
