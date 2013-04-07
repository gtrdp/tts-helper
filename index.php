<?php

if (isset($_GET["pattern"]))
{
	$pattern = $_GET["pattern"];
	$language = $_GET["language"];
	$status = TRUE;
	
	$file = fopen("daftarkata-". $language .".txt", "r");
	$list_word = array();
	
	while (!feof($file))
	{
		$row = trim(fgets($file, 4096));
		
		if (strlen($row) == strlen($pattern))
		{
			if (preg_match("'^" . $pattern . "$'", $row, $matches))
				array_push($list_word, $matches[0]);
		}
	}
	fclose($file);
}
else {
	$list_word = array();
	$pattern = "";
	$language = "id";
}

function show_words($words)
{
	echo "<ol>";	
	foreach ($words as $foo)
		echo "<li>" . $foo . "</li>";
	echo "</ol>";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Pemecah TTS</title>
	<style type="text/css">
		h1 {
			font-size: 14pt;
		}
	</style>
</head>
<body>
	<h1>Pemecah Teka Teki Silang</h1>
	<form action="index.php" method="get">
		<fieldset>
			<legend>Kata Kunci Pencarian:</legend>
			<label for="pattern">Pola Kata:</label>
			<input type="text" name="pattern" value="<?php echo $pattern; ?>"/><br />
			
			Bahasa:<br />
			<input type="radio" name="language" id="id" value="id" <?php echo ($language == "id" ? 'checked="checked"' : "") ?>/>
			<label for="id">Bahasa Indonesia</label><br />
			<input type="radio" name="language" id="en" value="en" <?php echo ($language == "en" ? 'checked="checked"' : "") ?>/>
			<label for="en">Bahasa Inggris</label>
			<br />
			<input type="submit" value="Cari"/>
		</fieldset>
	</form>
	
	<fieldset>
		<legend>Hasil Pencarian:</legend>
		<?php
			show_words($list_word);
		?>
	</fieldset>
</body>
</html>