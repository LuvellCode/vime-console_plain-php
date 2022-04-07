<? if($_SESSION['console'] != 'validated'){
    $config = require '../config.php';
    die($config['hackerman_msg']);
} ?>
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/"><i class="fas fa-cube"></i>Консоль</a>
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="/" onClick="logout()">Выйти</a>
    </li>
  </ul>
</nav>
<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="/">
              <i class="fas fa-terminal"></i>
               &nbsp; Консоль
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Доп.ссылки</span>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="https://vk.com/epicmc_server" target="_blank">
              <i class="fab fa-vk"></i>
              &nbsp; Сообщество Вконтакте
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://185.97.254.59/consolemagic/" target="_blank">
              <i class="fab"></i>
              &nbsp; Консоль Magic
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Консоль игрока <? echo $_SESSION['username'].' ['.$_SESSION['group'].']';?>
        </h1>
      </div>
      <div class="row">
        <div class="col-md-8">
          <div class="log">
            <p>
			  [Server thread/INFO]:  Starting minecraft server version 1.8.8 <br>
			  [Server thread/INFO]:  Loading properties <br>
			  [Server thread/INFO]:  Default game type: SURVIVAL <br>
			  [Server thread/INFO]:  This server is running CraftBukkit version git-Spigot-21fe707-e1ebe52 (MC: 1.8.8) (Implementing API version 1.8.8-R0.1-SNAPSHOT) <br>
			  [Server thread/INFO]:  Unable to find file banned-players.json, creating it. <br>
			  [Server thread/INFO]:  Server Ping Player Sample Count: 12 <br>
			  [Server thread/INFO]:  Using 4 threads for Netty based IO <br>
              </p>
          </div><br>
        </div>
        <div class="col-md-4">
          <h4>Доступные команды:</h4> <br>
          <div class="commands"></div>
        </div>
      </div>
      <hr class="my-4">
      <form onsubmit="return false;">
        <div class="console_form_alert"></div>
        <div class="row">
          <div class="col-md-10">
            <div class="form-group">
              <input type="text" class="form-control" id="command" placeholder="Введите команду" required>
            </div>
          </div>
          <div class="col-md-2">
            <button class="btn btn-primary btn-block" onClick="run()">Выполнить</button>
          </div>
        </div>
      </form>
    </main>
  </div>
</div>
<script>getCommands();</script>
