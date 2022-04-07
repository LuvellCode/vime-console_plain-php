<?
if($_SERVER['REQUEST_URI'] == '/index.php' or $_SERVER['REQUEST_URI'] == '/index'){
    header('Location: /');
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Консоль</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="template/style.css">
      <link rel="stylesheet" href="/template/auth_style.css">
  </head>
  <body>
    <div class="content">
      <div class="container cr text-center">
        <i class="fas fa-sync fa-4x"></i> <br><br>
        <h2>Загрузка...</h2>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <script src="template/script.js"></script>
  </body>
</html>
