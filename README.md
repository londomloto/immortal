# immortal
Aplikasi yang dibuat dengan php procedural untuk kebutuhan pembelajaran.

Authors:
* londomloto
* harahapariefbenardi

## Dokumentasi
Link dokumentasi:
* [Konfigurasi](docs/configuration.md)
* [Cores Helper](docs/cores.md)
* [URL Helper](docs/url.md)
* [Session Helper](docs/session.md)
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
