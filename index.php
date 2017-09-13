<?php
include_once ("inc/function.php");

$groups = array("Tools","Multimedia","Internet","Games","Others");
$addons = array();
$xml = simplexml_load_file("dists/4/rep_info.xml"); 

foreach($xml->addon as $addon) {
    $addons[] = array(
        'name'=> (string)$addon->name,
        'version'=> (string)$addon->version,
        'title'=> (string)$addon->title,
        'description'=> (string)$addon->description,
        'description_ru'=> (string)$addon->description_ru,
        'minimal_version_kvirc'=> (string)$addon->minimal_version_kvirc,
        'date'=> (string)$addon->date,
        'author'=> (string)$addon->author,
        'zip'=> (string)$addon->zip,
        'group'=> (string)$addon->group,
        'image'=> (string)$addon->image,
    );
}
array_sort_by_column($addons, 'name');

$all_authors = phpist_get_array_by_key($addons, 'author');
$authors = array_unique($all_authors);
$a_count = count($authors);

unset($all_authors);
unset($authors);
//echo"<pre>";
//print_r(count($authors));

$LangArray = array("ru", "en");
// Язык по умолчанию
$DefaultLang = "en";
// Если язык уже выбран и сохранен в сессии отправляем его скрипту
if(@$_SESSION['NowLang']) {
    // Проверяем если выбранный язык доступен для выбора
    if(!in_array($_SESSION['NowLang'], $LangArray)) {
        // Неправильный выбор, возвращаем язык по умолчанию
        $_SESSION['NowLang'] = $DefaultLang;
    }
}
else {
    $_SESSION['NowLang'] = $DefaultLang;
}
// Выбранный язык отправлен скрипту через GET
$language = addslashes($_GET['lang']);
if($language) {
    // Проверяем если выбранный язык доступен для выбора
    if(!in_array($language, $LangArray)) {
        // Неправильный выбор, возвращаем язык по умолчанию
        $_SESSION['NowLang'] = $DefaultLang;
    }
    else {
        // Сохраняем язык в сессии
        $_SESSION['NowLang'] = $language;
    }
}
// Открываем текущий язык
$CurentLang = addslashes($_SESSION['NowLang']);
include_once ("lang/lang.".$CurentLang.".php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv=content-type content="text/html; charset=UTF-8">
<meta name="description" content="KVIrc scripts repository">
<meta name="keywords" content="KVIrc, kvirc, script, scripts, addon, addons, repository">
<?php
	echo"<title>".$Lang['title']."</title>\n";
?>
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include_once("inc/analyticstracking.php") ?>
<div id="lang">
    <table width="100%" cellspacing="0px" cellpadding="5px" border="0">
        <tr>
            <td><a href="index.php?lang=ru">ru</a></td>
            <td><a href="index.php?lang=en">en</a></td>
        </tr>
    </table>
</div>
<center>
<div id="header">
    <center>
			<?php
			echo"<h1>".$Lang['header_title']."</h1><br>
			".$Lang['files_counter']." ".count($addons)."<br>".$Lang['authors']." ".$a_count."\n";
			?>
    </center>
</div>
<div id="main">
<?php
for ($y=0; $y<count($groups);$y++) {
    echo"
    <center><h2>".$groups[$y]."</h2></center>
    <table width=\"100%\" cellspacing=\"0px\" cellpadding=\"5px\" border=\"1\">
        <tr class=\"tTitle\" bgcolor=\"lightgrey\">
            <td width=\"250px\">".$Lang['column_title']."</td>
            <td width=\"50px\">".$Lang['column_version']."</td>
            <td>".$Lang['column_description']."</td>
            <td width=\"100px\">".$Lang['column_download']."</td>
            <td width=\"70px\">".$Lang['column_kvirc_min_version']."</td>
            <td width=\"100px\">".$Lang['column_last_update']."</td>
            <td width=\"120px\">".$Lang['column_author']."</td>
            <td width=\"50px\">".$Lang['column_screen']."</td>
        </tr>\n";
        $cnt = 0;
    for ($i=0; $i<count($addons);$i++) {
        if($groups[$y] == $addons[$i]['group']){
        if($cnt%2 != 0){
            echo"       <tr bgcolor=\"whitesmoke\">";
        }else{
            echo"       <tr>";
        }
        echo"
            <td class=\"tContent\"><b>".$addons[$i]['title']."</b></td>
            <td class=\"tVersion\">".$addons[$i]['version']."</td>";
            if($CurentLang == "ru"){
                if($addons[$i]['description_ru']){
                    echo"<td class=\"tContent\">".$addons[$i]['description_ru']."</td>";
                } else {
                    echo"<td class=\"tContent\">".$addons[$i]['description']."</td>";
                };
            };
            if($CurentLang == "en"){
                echo"<td class=\"tContent\">".$addons[$i]['description']."</td>";
            };
            echo"
            <td class=\"tVersion\"><a href=\"pool/4/".$addons[$i]['name']."-".$addons[$i]['version'].".tar.gz\" class=\"stdLink\">tar.gz</a>";
            if($addons[$i]['zip'] == "1"){
                echo", <a href=\"pool/4/zip/".$addons[$i]['name']."-".$addons[$i]['version'].".zip\" class=\"stdLink\">zip</a>";
            };
            echo"
            </td>
            <td class=\"tVersion\">".$addons[$i]['minimal_version_kvirc']."</td>
            <td class=\"tVersion\">".$addons[$i]['date']."</td>
            <td class=\"tContent\">".$addons[$i]['author']."</td>";
            if($addons[$i]['image'] == "1") {
                echo "
                <td class=\"tVersion\"><a href=\"screens/".$addons[$i]['name'].".png\" target=\"_blank\">".$Lang['yes']."</a></td>";
            } else {
                echo "
                <td class=\"tVersion\">".$Lang['no']."</td>";
            };
        echo"		
        </tr>\n";
        $cnt++;
        };
    };
    echo"
    </table>";
};
?>
</div>
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
		<td>
		<script type="text/javascript">!function(e,t,r){e.PrcyCounterObject=r,e[r]=e[r]||function(){(e[r].q=e[r].q||[]).push(arguments)};var c=document.createElement("script");c.type="text/javascript",c.async=1,c.src=t;var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(c,n)}(window,"//a.pr-cy.ru/assets/js/counter.min.js","prcyCounter"),prcyCounter("kvirc.alexzulu.ru","prcyru-counter",0);</script><div id="prcyru-counter"></div><noscript><a href="//a.pr-cy.ru/kvirc.alexzulu.ru" target="_blank"><img src="//a.pr-cy.ru/assets/img/analysis-counter.png" width="88" height="31" alt="Analysis"></a></noscript>
		</td>
		</tr>
  </table>
</center>
</div>
</center>
<?php include 'inc/count.php';?>
</body>
</html>
