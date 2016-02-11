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

### Database Helper
### `db()`
Fungsi ini digunakan untuk mendapatkan objek koneksi aktif
### `db_start()`
Fungsi ini digunakan untuk melakukan koneksi database
### `db_stop()`
Fungsi ini digunakan untuk memutus koneksi database
### `db_query($sql, $bind = array())
Fungsi ini digunakan untuk melakukan query data
```php
$query = db_query('SELECT * FROM products');
$prods = db_fetch_all($query);
```
### `db_fetch_all($query)`
Fungsi ini digunakan untuk mendapatkan result dari query
### `db_fetch_all($sql, $bind = array())
Fungsi ini digunakan untuk mendapatkan result dari sql
```php
$products = db_fetch_all('SELECT * FROM products WHERE status = ?', array('active'));

foreach($products as $prod) {
  echo $prod['name'];
}
```
