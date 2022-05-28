<?php
$FILENAME = "names.txt";
$INDEX_FILENAME = "index.php";

function read_names()
{
	global $FILENAME;
	return explode("#", file_get_contents($FILENAME));
}

function show()
{
	global $INDEX_FILENAME;
	$names = read_names();
	echo ("<p>現在のリストは以下の通りです。名前をクリックすると、その人は一番下に移動します。</p>");
	$idx = 0;
	foreach ($names as $name) {
		echo ("<p><a href=\"index.php?action=click&idx=" . $idx . "\">" . $name . "</a></p>");
		$idx++;
	}
	echo ("<hr>");
	echo ("<a href=\"?action=edit\">直接編集画面へ</a>");
}

function click()
{
	global $FILENAME;
	if (!isset($_REQUEST["idx"])) {
		show();
		return;
	}
	$names = read_names();
	$removed = array_splice($names, $_REQUEST["idx"], 1);
	$names = array_merge($names, $removed);
	$f = fopen($FILENAME, "w");
	flock($f, LOCK_EX);
	fwrite($f, implode("#", $names));
	flock($f, LOCK_UN);
	fclose($f);
	show();
}

function edit()
{
	global $FILENAME, $INDEX_FILENAME;
	$value = file_get_contents($FILENAME);
	echo ("<p>名前リストを直接編集できます。名前は、 # で区切って書いてください。</p>");
	echo ("<form action=\"" . $INDEX_FILENAME . "\" method=\"post\">");
	echo ("<label>直接編集 <input name=\"content\" type=\"text\" value=\"" . $value . "\"></label>");
	echo ("<input type=\"hidden\" name=\"action\" value=\"submit\">");
	echo ("<input type=\"submit\" value=\"保存\">");
	echo ("</form>");
}

function submit()
{
	global $FILENAME;
	if (!isset($_POST["content"])) {
		echo ("<p>更新内容が指定されてませんよー</p>");
		show();
		return;
	}
	$f = fopen($FILENAME, "w");
	flock($f, LOCK_EX);
	fwrite($f, htmlspecialchars($_POST["content"]));
	flock($f, LOCK_UN);
	fclose($f);
	echo ("<p>編集内容を保存しました！</p>");
	show();
}
