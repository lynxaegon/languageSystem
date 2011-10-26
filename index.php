<?php
require_once("Language.class.php");
$language = new Language("locale","xml");
print_r($language->getSupported());
echo "<br>";

if($language->load($_GET['language']) == NULL)
{
	echo "Language not Supported";
	exit;
}

echo "<button>".$language->welcome."</button>";
echo "<br><br>";
echo "<button>".$language->buttons->type_class->asd."</button>";
echo "<button>".$language->test->q."</button>";
echo "<br><br>";
print_r($language);

?>
