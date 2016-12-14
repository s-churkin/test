<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Гостевая книга</title>
    <link href="./css/bootstrap.css" rel="stylesheet">
</head>
<body>

<?php
include ("dbconnect.php");
?>
<?php 
if (isset($_GET['id'])) { // режим просмотра
    $id=$_GET['id'];
    $ronly = 'readonly="readonly"';
    echo '<h1>Сообщение</h1>';
    $r = mysqli_query($connection, 'SELECT * FROM `tst_gbook` WHERE id=' . $id);
    $row = mysqli_fetch_array($r);
		$name = $row['name'];
		$email = $row['email'];
		$subject = $row['subject'];
		$body = $row['body'];
    $connection->close();  
} else { // режим ввода
    /* Капчи */
    if (!isset($_COOKIE["ncaptcha"])) {
       $ncaptcha = 0; 
       $ncaptchaold = 0; 
    } else {
       $ncaptchaold = $_COOKIE["ncaptcha"]; 
       $ncaptcha = $_COOKIE["ncaptcha"] + 1;
       if ($ncaptcha > 2) {
           $ncaptcha = 0;
       }
    }
    setcookie("ncaptcha", $ncaptcha); 
    $arrcaptcha[0] = 'redihe';
    $arrcaptcha[1] = 'iijlwcx';
    $arrcaptcha[2] = 'hehovoe';
    // echo $ncaptcha;
    $id = '';
    $ronly = '';
    $message = '';
    if (isset($_REQUEST['name'])) {
	$name = trim($_REQUEST['name']);
    } else {
	$name = '';
    }
    if (isset($_REQUEST['email'])) {
	$email = trim($_REQUEST['email']);
    } else {
	$email = '';
    }
    if (isset($_REQUEST['subject'])) {
	$subject = trim($_REQUEST['subject']);
    } else {
	$subject = '';
    }
    if (isset($_REQUEST['body'])) {
	$body = trim($_REQUEST['body']);
    } else {
	$body = '';
    }
    if (isset($_REQUEST['captcha'])) {
	$captcha = trim($_REQUEST['captcha']);
    } else {
	$captcha = '';
    }
    $messageempty = ' не может быть пустым. ';
    // валидация
    if (isset($_REQUEST['name'])) {
        if (empty($name)) {
           $message = $message . "Имя" . $messageempty;
        }
        if (empty($email)) {
           $message = $message . "Email" . $messageempty;
        }
        if (empty($subject)) {
           $message = $message . "Заголовок" . $messageempty;
        }
        if (empty($body)) {
           $message = $message . "Текст сообщения" . $messageempty;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
           $message = $message . "E-mail ($email) указан не верно.";
        }
        if ($captcha !== $arrcaptcha[$ncaptchaold]) {
           $message = $message . "Капча указана не верно."; // . $captcha . ' ' .  $arrcaptcha[$ncaptchaold] . ' ' .  $arrcaptcha[$ncaptcha];
        }
    }
    if ($message !== '') {
        echo '<div class="alert alert-danger"><strong>Внимание! </strong>' . $message . '</div>';
    } else {
        if (isset($_REQUEST['name'])) {
            mysqli_query($connection, "INSERT INTO `tst_gbook`(`name`, `email`, `subject`, `body`) VALUES ('" . $name . "','" . $email . "','" . $subject . "', '" . $body . "')");
            printf ("ID новой записи: %d.\n", $connection->insert_id);
            $connection->close();  
            header("location: /tst/index.php");
        }
    }
}  
?>

<div class="col-lg-1 col-md-1 col-sm-1 center-block">
</div>    
<div class="col-lg-10 col-md-10 col-sm-10 center-block">
<h1>Добавление сообщения</h1>
<form name="myForm" action="form.php" method="post" onSubmit="">
<input type="hidden" name="action" value="add">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<div class="form-group">
<label class="control-label">Имя пользователя:</label>
<input type="text" id="name" class="form-control" name="name" maxlength="255" <?php echo $ronly; ?>  value="<?php echo $name; ?>" >
<label class="control-label">Адрес электронной почты:</label>
<input type="text" id="email" class="form-control" name="email" maxlength="255" <?php echo $ronly; ?>  value="<?php echo $email; ?>" >
<label class="control-label">Заголовок:</label>
<input type="text" id="email" class="form-control" name="subject" maxlength="255" <?php echo $ronly; ?>  value="<?php echo $subject; ?>" >
<label class="control-label">Текст сообщения:</label>
<textarea name="body" class="form-control" <?php echo $ronly; ?> > <?php echo $body; ?> </textarea>
</div>

<?php
if ($id == '') {
echo '<div class="form-group">' .
     '<label class="control-label">Пожалуйста, введите капчу:</label>' .
     '<img src="img/' . $ncaptcha . '.png">' .
     '<input type="text" id="captcha" class="form-control" name="captcha" maxlength="20">' .
     '</div>';
}
?>
<div class="form-group">
<?php
if ($id == '') {
echo '<button type="submit" class="btn btn-primary" >Сохранить</button>';
}
?>
<button type="button" class="btn btn-default" onclick="document.location.href = '/tst/index.php';">Вернуться</button>
<?php
    if (isset($_COOKIE["admin"])) {
?>
<button type="button" class="btn btn-danger" onclick="document.location.href = '/tst/delete.php?id= <?php echo $id; ?> ';">Удалить</button>
<?php
    }
?>
</div>
</form>
</div>
</body>
</html>
