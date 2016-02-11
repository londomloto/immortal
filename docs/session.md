### Session Helper

##### `has_session()`
Fungsi ini digunakan untuk memeriksa apakah sebuah session tertentu ada (eksis)
```php
if ( ! has_session('user')) {
  exit('Access denied!');
}
```
##### `set_session($key, $value)`
Fungsi ini digunakan untuk menge-set nilai ke dalam session
```php
$user = db_fetch_one('SELECT * FROM users WHERE id = 1');

if ($user) {
	unset($user['passwd']);
    set_session('user', $user);
}
```
##### `get_session($key, $default = '')`
Fungsi ini digunakan untuk mengambil nilai dari session
```php
if (has_session('user')) {
	$user = get_session('user');
    print_r($user);
}

// output:
Array (
	[email] => john@example.com
    [fullname] => John Doe
)
```
##### `unset_session($key)`
Fungsi ini digunakan untuk menghapus data dari session
```php
unset_session('user');
```

##### `clear_session($key)`
Fungsi ini digunakan untuk menghapus semua data dari session
```php
clear_session();
```