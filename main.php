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
