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

##### Clean URL
Settingan clean url apache via .htaccess:
```php
RewriteEngine On
RewriteCond $1 !^(index\.php|assets|docs)
RewriteRule ^(.*)$ index.php?/$1 [L]
```

Settingan clean url nginx:
```php
server {
	listen 80;
    ...
    ...
    location /immortal/ {
    	if ($request_uri ~* index/?$) {
        	rewrite ^/immortal/(.*)/index/?$ /immortal/$1 permanent;
        }
        
        if (!-d $request_filename) {
            rewrite ^/immortal/(.+)/$ /immortal/$1 permanent;
        }
        
        if (!-e $request_filename) {
            rewrite ^/immortal/(.*)$ /immortal/index.php?/$1 last;
            break;
        }
        
        # access folder
        
        location ~ ^/assets {
            autoindex off;
        }
        
        location ~ ^/(\.ht|libs|modules|layouts) {
            deny all;
        }
    }
}
```