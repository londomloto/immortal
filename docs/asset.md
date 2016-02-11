### Penggunaan Asset

##### Thumbnail
Untuk menampilkan gambar dalam bentuk thumbnail gunakan format URI berikut:
```xml
image/thumb/100x100/img/profile.png
|----------|-------|---------------|
			   |		   |____________ path file
               |________________________ ukuran thumbnail
```
Contoh:
```xml
<img src="<?php echo site_url('image/thumb/100x100/img/profile.png); ?>">
```