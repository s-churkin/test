<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Гостевая книга</title>
    <link href="./css/bootstrap.css" rel="stylesheet">
</head>
<body>
<h1>Гостевая книга</h1>
<table class="table table-striped table-bordered">
<thead>
<tr><th>#</th>
<th>Имя</th>
<th>Email</th>
<th>Заголовок</th>
<th>Текст</th>
</thead>	
<tbody>

<?php
$c=0;
include ("dbconnect.php");
$r = mysqli_query($connection, 'SELECT * FROM `tst_gbook`');
while ($row = mysqli_fetch_array($r)) {
?>
    <tr>
	<td><?php echo $row['id']; ?></td>
	<td><?php echo $row['name']; ?></td>
	<td><?php echo $row['email']; ?></td>
	<td><?php echo $row['subject']; ?></td>
        <td><?php echo substr($row['body'], 0, 100); if(strlen($row['body']) > 100) echo '...'; ?></td>
        <td><a href="/tst/form.php?id= <?php echo $row['id']; ?> " title="Просмотр сообщения" aria-label="Просмотр" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a></td>
    </tr>
<?php
    $c++;
}
$connection->close();  
if ($c==0) {
    echo "Гостевая книга пуста!<br>"; 
}
?>
</tbody>
</table>
<button type="button" class="btn btn-success" onclick="document.location.href = '/tst/form.php';">Ввести сообщение</button>
<?php
    if (!isset($_COOKIE["admin"])) {
?>
<button type="button" class="btn btn-primary" onclick="document.location.href = '/tst/formlogin.php';">Вход администратора</button>
<?php
    } else {
?>
<button type="button" class="btn btn-default" onclick="document.location.href = '/tst/formlogin.php?off=1';">Выход администратора</button>
<?php
    }
?>
</body>
</html>
