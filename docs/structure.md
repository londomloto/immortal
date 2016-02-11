### Struktur Aplikasi

```php
ROOT/
	index.php
	layouts/
		login.php
		main.php
        ...
	libs/
    	cores.php
        ...
	modules/
    	home/
        	home.php
            docs.php
        ...
	assets/
    	css/
        js/
        img/
        ...
    	
    	
```

##### Layout
Layout adalah template global yang digunakan oleh aplikasi atau per module.
Contoh layout:

```php
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo get_config('title'); ?></title>
</head>
<body>
	<?php echo get_content(); ?>
</body>
</html>
```