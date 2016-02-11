
### URL Helper

##### `base_url()`
Fungsi ini digunakan untuk mendapatkan base URL aplikasi
```php
base_url();

// output:
http://localhost/immortal/
```
##### `site_url($uri, $query = '')`
Fungsi ini digunakan untuk membentuk URL dari suatu URI/path
```php
site_url('user/profile');

// output:
http://localhost/immortal/user/profile.xyz
```
Jika ditambakan query string:
```php
site_url('products', 'page=2&color=red');

// output:
http://localhost/immortal/products.xyz?page=2&color=red
```
##### `current_url($query = '')`
Fungsi ini digunakan untuk mendapatkan URL saat ini
```php
current_url();

// output:
http://localhost/immortal/products.xyz
```
Jika ditambakan query string:
```php
current_url('page=2&color=red');

// output:
http://localhost/immortal/products.xyz?page=2&color=red
```
##### `asset_url($path)`
Fungsi ini digunakan untuk mendapatkan URL dari file asset seperti img, js, css
```php
asset_url('img/logo.png');

// output:
http://localhost/immortal/assets/img/logo.png
```