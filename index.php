<?php
header( 'content-type: text/html; charset=utf-8' );
include "libs/lang/lang_en.php";

// Variable
$from = 'en';
$to = 'ru';
// Tutorial for your private key: http://blogs.msdn.com/b/translation/p/gettingstarted1.aspx
$key = 'YOUR_KEY';
 

foreach ($lang as $keys => $value) {
 
	$ch = curl_init('https://api.datamarket.azure.com/Bing/MicrosoftTranslator/v1/Translate?Text=%27'.urlencode($value).'%27&From=%27'.$from.'%27&To=%27'.$to.'%27');
	curl_setopt($ch, CURLOPT_USERPWD, $key.':'.$key);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// Parse the XML response
	$result = curl_exec($ch);
	$result = explode('<d:Text m:type="Edm.String">', $result);
	$result = explode('</d:Text>', $result[1]);
	$result = $result[0];
 
	# Chemin vers fichier texte
	$file ="lang_".$to.".php";
	# Ouverture en mode écriture
	$fileopen=(fopen($file,'a+'));
	# Ecriture de "Début du fichier" dansle fichier texte
	fwrite($fileopen,'$lang["'.$keys.'"]="'.$result.'"; '."\n");
	# On ferme le fichier proprement
	fclose($fileopen);    
}
 
