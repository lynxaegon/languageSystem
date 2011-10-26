# Description:
This is a semi-automatic languageSystem for php. You can have how many languages you want at the same time. It's easy to translate from one language to another, and it's really easy to use.

# Usage:

### Loading the languageSystem Class:

	<?php
		require_once("Language.class.php");
		$language = new Language("locale","xml");
	?>

The __construct of Language has 2 parameters:

* $path (required): the location of the language files
* $render (optional, default "ini"): the type of the language files (ini or xml)

### Get the list of supported languages:

	<?php
		print_r($language->getSupported());
	?>

### Load the language:

	<?php
		if($language->load($_GET['language']) == NULL)
		{
			echo "Language not Supported";
			exit;
		}
	?>

$language->load() has two parameters:

* $lang (required): The language you want to load (ex: "en", this will look in locale/en/$file for the language) 

* $file (optional, default ""): This is the language file you want to load, by default it loads the $_SERVER['SCRIPT_FILENAME'].lang file

Let's say you loaded English in xml format.
If you have this language file:

	<?xml version="1.0" encoding="UTF-8"?> 
	<language>
		<button_add>Add to cart</button_add>
		<header>
			<top_left>Text left</top_left>
			<top_right>Text right</top_right>
		</header>
	</language>

You can access the texts from that file like this:

	echo $language->button; // This prints "Add to cart"

or

	echo $language->header->top_left; // This prints "Text left";

If you try to get a text that is not in the language file, ex:

	echo $language->header->top_center; // This prints "Undefined Language"

### Examples:
The examples can be found in index.php

### Bugs:

Found a bug? Please [let me know](https://github.com/lynxaegon/extendedTextarea/issues).

### Author:
Andrei Vaduva
