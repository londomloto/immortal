# immortal
Aplikasi yang dibuat dengan php procedural untuk kebutuhan pembelajaran.

Authors:
* londomloto
* harahapariefbenardi

## Dokumentasi
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
### Cores Helper
#### `set_var($key, $value)`
Fungsi ini digunakan untuk menyimpan data yang dapat diakses secara global.
```php
set_var('foo', 'bar');
```
#### `get_var($key, $default = '')`
Fungsi ini digunakan untuk mengakses data yang disimpan secara global.
```php
get_var('foo');   // bar
```
