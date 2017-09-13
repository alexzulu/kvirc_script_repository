<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv=content-type content="text/html; charset=UTF-8">
	<title>Статистика</title>
    <link rel="stylesheet" type="text/css" href="../css/counter.css">
</head>
<body>
<?php include '../inc/db.php';
// Если в массиве GET есть элемент interval (т.е. был клик по одной из ссылок выше)
if ($_GET['interval']){
	$interval = $_GET['interval'];
    // Если в качестве параметра передано не число
    if (!is_numeric ($interval))
    {
        echo '<p><b>Недопустимый параметр!</b></p>';
    }
    if($interval == "1"){
        echo"
    <center><h2>Статистика за сегодня</h2></center>";
	} else {
	echo"
    <center><h2>Статистика за ".$interval." дней</h2></center>";
	}
	echo"
	<br>
	<table class=\"links\">
		<tr>
			<td class=\"links\"><a href=\"?interval=1\">За сегодня</a></td>
			<td class=\"links\"><a href=\"?interval=7\">За последнюю неделю</a></td>
			<td class=\"links\"><a href=\"?interval=30\">За последние 30 дней</a></td>
		</tr>
	</table>
	<br>
	<table width=\"80%\">
        <tr bgcolor=\"lightgrey\">
			<th>Дата</th>
			<th>Уникальных посетителей</th>
			<th>Просмотров</th>
        </tr>";
    // Указываем кодировку, в которой будет получена информация из базы 
    @mysqli_query ($db, 'set character_set_results = "utf8"');
    // Получаем из базы данные, отсортировав их по дате в обратном порядке в количестве interval штук
	$res = mysqli_query($db, "SELECT * FROM `visits` ORDER BY `date` DESC LIMIT $interval");    
    // Формируем вывод строк таблицы в цикле
	while ($row = mysqli_fetch_assoc($res))
    {
		echo '
		<tr>
			<td class="data">' . $row['date'] . '</td>
			<td class="data">' . $row['hosts'] . '</td>
			<td class="data">' . $row['views'] . '</td>
		</tr>';
	}
} else {
	$interval = 1;
    // Если в качестве параметра передано не число
    if (!is_numeric ($interval))
    {
        echo '<p><b>Недопустимый параметр!</b></p>';        
    }
    echo"
	<center><h2>Статистика за сегодня</h2></center>
	<br>
	<table class=\"links\">
		<tr>
			<td class=\"links\"><a href=\"?interval=1\">За сегодня</a></td>
			<td class=\"links\"><a href=\"?interval=7\">За последнюю неделю</a></td>
			<td class=\"links\"><a href=\"?interval=30\">За последние 30 дней</a></td>
		</tr>
	</table>
	<br>
	<table width=\"80%\">
        <tr bgcolor=\"lightgrey\">
			<th>Дата</th>
			<th>Уникальных посетителей</th>
			<th>Просмотров</th>
        </tr>";  
    // Указываем кодировку, в которой будет получена информация из базы 
    @mysqli_query ($db, 'set character_set_results = "utf8"');
    // Получаем из базы данные, отсортировав их по дате в обратном порядке в количестве interval штук
	$res = mysqli_query($db, "SELECT * FROM `visits` ORDER BY `date` DESC LIMIT $interval");    
    // Формируем вывод строк таблицы в цикле
	while ($row = mysqli_fetch_assoc($res))
    {
		echo '
		<tr>
			<td class="data">' . $row['date'] . '</td>
			<td class="data">' . $row['hosts'] . '</td>
			<td class="data">' . $row['views'] . '</td>
		</tr>';
	}
}
    echo"
    </table>\r\n";
?>
    <div id="footer">
    <br><center>Developed by alexzulu 2016 - <?php echo date('Y') ?></center><br>
    <center>
        <table>
            <tr>
                <td>
                    <a href="http://www.hostinger.ru" target="_blank"><img src="http://kvirc.alexzulu.ru/img/hostinger-logo.png" alt="Web Hosting" width="88" height="31" border="0"></a>
                </td>
                <td>    
                    <a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-html401-blue" alt="Valid HTML 4.01 Transitional" height="31" width="88"></a>
                </td>
            </tr>
        </table>
    </center>
    </div>
</body>
</html>
