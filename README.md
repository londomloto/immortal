# immortal
Aplikasi yang dibuat dengan php procedural untuk kebutuhan pembelajaran.

Authors:
* londomloto
* harahapariefbenardi

## Dokumentasi
Link dokumentasi:
  * [Database Helper](docs/database.md)
  
### Konfigurasi
Konfigurasi aplikasi disimpan di dalam file `config.php`:

```php
return array(
  /**
  * Nama aplikasi / paket
  */
  'name' => 'londomloto/immortal',
  
  /**
  * Versi
  */
  'version' => '1.0.0'
)
```
### Format URL
Varian format URL
```php
http://example.com/user/profile
http://example.com/user/profile.html
http://example.com/products/notebook/asus
http://example.com/products?category=notebook&name=asus
```
### Cores Helper
##### `set_var($key, $value)`
Fungsi ini digunakan untuk menyimpan data yang dapat diakses secara global.
```php
set_var('foo', 'bar');
```
##### `get_var($key, $default = '')`
Fungsi ini digunakan untuk mengakses data yang disimpan secara global.
```php
get_var('foo');   // bar
```
