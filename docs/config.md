### File Konfigurasi

File configurasi disimpan di dalam file `/config.php`. File ini digunakan untuk menyimpan konfigurasi global.

```php
return array(
	/**
    * Nama paket aplikasi
    */
    'name' => 'App',
    
    /**
    * Tag release
    */
    'version' => '1.0.0',
    
    /**
    * <title>
    */
    'title' => 'immortal',
    
    /**
    * <meta name="author">
    */
    'author' => 'supernova, arief',
    
    /**
    * <meta name="description">
    */
    'description' => 'simple php application',
    
    /**
    * <meta name="keywords">
    */
    'keywords' => 'simple, php, application',
    
    /**
    * File yang digunakan sebagai index.
    * Jika menggunakan rewrite URL, dapat dikosongkan,
    * atau isi dengan `index.php` jika tidak menggunakan.
	* 
	* Contoh:
	* 	http://localhost/immortal/index.php/user/profile.html, atau
	* 	http://localhost/immortal/user/profile.html
    */
    'index' => '',
    
    /**
    * Halaman default jika module tidak disebutkan dalam URL
    */
    'default' => 'home/docs',
    
    /**
    * Akhiran path pada URL.
    * 
    * Contoh:
    * 	http://localhost/immortal/user/profile.xyz
    */
    'suffix' => '.xyz',
    
    /**
    * Default charset, digunakan pada saat menggunakan
    * fungsi `htmlspecialchars()`
    */
    'charset' => 'UTF-8',
    
    /**
    * Daftar karakter yang diperbolehkan dalam URL
    */
    'urlchars' => 'a-z 0-9~%.:_\-#?=&',
    
    /**
    * Librari yang otomatis di load (include) pada
    * saat aplikasi booting
    */
    'autoload' => array(
        'database',
        'pagination'
    ),
    
    /**
    * Konfigurasi database
    */
    'database'=> array(
    	'host' => 'localhost',
        'user' => 'root',
        'pass' => 'secret',
        'name' => 'immortal',
        'load' => true  // otomatis melakukan koneksi ke database
    )
);
```