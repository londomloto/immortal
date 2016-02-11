### Cores Helper

##### `set_var($key, $value)`
Fungsi ini digunakan untuk menyimpan data yang dapat diakses secara global.
```php
set_var('foo', 'bar');
```
##### `get_var($key, $default = '')`
Fungsi ini digunakan untuk mengakses data yang disimpan secara global.
```php
get_var('foo');   	// bar
get_var('baz', 1)	// 1 (default)
```
##### `get_config($key, $default = '')`
Fungsi ini digunakan untuk mengakses data konfigurasi.
```php
$dbconfig = get_config('database');
print_r($dbconfig);

// output:
Array(
	[host] => localhost
    [user] => root
    [pass] => secret
    [name] => immortal
    [load] => true
)
```
##### `load_library($name)`
Fungsi ini digunakan untuk me-load library (include) ke dalam aplikasi.
Librari ini disimpan di dalam folder /libs.

```xml
<?php load_library('form'); ?>

<?php form_open('login', 'login/validate', 'post'); ?>
<div class="form-group">
	<?php input_text('email', 'john@example.com'); ?>
</div>
<?php form_close(); ?>
```
##### `get_post($field, $default = '')`
Fungsi ini digunakan untuk mendapatkan nilai dari variabel global `$_POST` yang sudah disanitasi.

```php
$email = get_post('email');
```
Jika `$field` tidak disebutkan, makan akan dikembalikan semua isi dari `$_POST`
```php
$post = get_post();

// output:
Array(
	[email] => john@example.com
)
```
##### `get_param($field, $default = '')`
Fungsi ini sama seperti fungsi `get_post()` hanya saja, nilainya diambil dari variabel `$_GET`
```php
http://localhost/immortal/products.xyz?page=2

$page = get_param('page');
```