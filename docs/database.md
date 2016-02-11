
# Database Helper

##### `db()`
Fungsi ini digunakan untuk mendapatkan objek koneksi aktif
##### `db_start()`
Fungsi ini digunakan untuk melakukan koneksi database
##### `db_stop()`
Fungsi ini digunakan untuk memutus koneksi database
##### `db_query($sql, $bind = null)`
Fungsi ini digunakan untuk melakukan query data
```php
$query = db_query('SELECT * FROM products');
$prods = db_fetch_all($query);
```
Fungsi ini juga dapat digunakan untuk menjalankan query DML (insert, update, delete)
```php
$insert = db_query('INSERT INTO users(email, name) VALUES (?, ?)', array('foo@bar.com', 'foo'));

if ($insert) {
  // do stuff...
}
```
##### `db_fetch_all($query)`
Fungsi ini digunakan untuk mendapatkan result dari query
##### `db_fetch_all($sql, $bind = null)`
Fungsi ini digunakan untuk mendapatkan result dari sql
```php
$products = db_fetch_all('SELECT * FROM products WHERE status = ?', array('active'));

foreach($products as $prod) {
  echo $prod['name'];
}
```
##### `db_fetch_one($sql, $bind = null)`
Fungsi ini digunakan untuk mendapatkan single result
```php
$user = db_fetch_one('SELECT * FROM users WHERE email = ?', array('john@example.com'));
print_r($user);

// output:
Array(
  [id] => 1
  [email] => john@example.com
  [active] => 1
)
```
