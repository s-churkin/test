<?php
if (isset($_GET['off'])) {
    setcookie("admin", "");
    header("location: /tst/index.php");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Вход администратора</title>
    <link href="./css/bootstrap.css" rel="stylesheet">
</head>
<body>

<?php
if (isset($_REQUEST['login'])) { // валидация
    if ((trim($_REQUEST['login']) !== 'admin') or (trim($_REQUEST['password']) !== 'admin')) {
        echo '<div class="alert alert-danger"><strong>Внимание! </strong>Неверные учетные данные!</div>';
    } else {
        setcookie("admin", "1");
        header("location: /tst/index.php");
    }
}
?>
<div class="col-lg-3 col-md-3 col-sm-3 center-block">
</div>
<div class="col-lg-6 col-md-6 col-sm-6 center-block">
<h1>Вход администратора</h1>
<form name="myFormlogin" action="formlogin.php" method="post" onSubmit="">
<div class="form-group">
<label class="control-label">Имя администратора:</label>
<input type="text" id="name" class="form-control" name="login" maxlength="25">
<label class="control-label">Пароль:</label>
<input type="password" id="password" class="form-control" name="password" maxlength="25">
</div>
<div class="form-group">
<button type="submit" class="btn btn-primary" >Войти</button>
<button type="button" class="btn btn-default" onclick="document.location.href = '/tst/index.php';">Вернуться</button>
</div>
</form>
</div>
</body>
</html>
