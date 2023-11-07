# Onglets media

Te permet d'ajouter des médias genre img etc pour pouvoir ensuite les utiliser sur le site
Bisous

Autoriser les fichiers svg, ajouter dans le fichier functions.php

```
function wpc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'wpc_mime_types');
```