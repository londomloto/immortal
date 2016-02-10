<?php echo breadcrumb(); ?>
<h1>Dokumentasi</h1>

<div class="nav-tabs-horizontal">
    <ul role="tablist" data-plugin="nav-tabs" class="nav nav-tabs nav-tabs-line">
        <li role="presentation" class=""><a role="tab" href="#tab-doc-config" data-toggle="tab" aria-expanded="true">Konfigurasi</a></li>
        <li role="presentation" class=""><a role="tab" href="#tab-doc-core" data-toggle="tab" aria-expanded="false">Core</a></li>
        <li role="presentation" class=""><a role="tab" href="#tab-doc-url" data-toggle="tab" aria-expanded="false">URL</a></li>
        <li role="presentation" class=""><a role="tab" href="#tab-doc-session" data-toggle="tab" aria-expanded="false">Session</a></li>
        <li role="presentation" class="active"><a role="tab" href="#tab-doc-database" data-toggle="tab" aria-expanded="false">Database</a></li>
        <li role="presentation" class=""><a role="tab" href="#tab-doc-asset" data-toggle="tab" aria-expanded="false">Asset</a></li>
        <li role="presentation" class=""><a role="tab" href="#tab-doc-security" data-toggle="tab" aria-expanded="false">Security</a></li>
    </ul>
    <div class="tab-content padding-top-20">
        <div role="tabpanel" id="tab-doc-config" class="tab-pane">
            Konfigurasi aplikasi disimpan di dalam file <b>config.php</b> 
            <pre>
                <code class="language-php">
                    return array(
                        /**
                         * Nama paket aplikasi
                         */
                        'name' => 'immortal/immortal',

                        /**
                         * Versi paket
                         */
                        'version' => '1.0.0',

                        /**
                         * Judul aplikasi
                         */
                        'title' => 'Immortal',

                        /**
                         * Keterangan
                         */
                        'description' => 'procedural php application',

                        /**
                         * Keyword paket aplikasi
                         */
                        'keywords' => 'procedural, php',

                        /**
                         * Hak cipta aplikasi
                         */
                        'authors' => '...',

                        /**
                         * File yang digunakan sebagai middleware (service)
                         * Jika menggunakan url rewrite, dapat dikosongkan
                         * sebaliknya, diisi dengan `index.php`
                         */
                        'index' => '',

                        /**
                         * Halaman default aplikasi
                         */
                        'default' => 'home',

                        /**
                         * Akhiran untuk setiap URL
                         */
                        'suffix' => '.html',

                        /**
                         * Default character set aplikasi
                         */
                        'charset' => 'UTF-8',

                        /**
                         * Daftar karakter yang diperbolehkan digunakan dalam URL
                         */
                        'urlchars' => 'a-z 0-9~%.:_\-#?=&',

                        /**
                         * Librari yang otomatis diload ketika aplikasi berjalan
                         */
                        'libraries' => array(
                            'database',
                            'pagination'
                        ),

                        /**
                         * Konfigurasi database
                         */
                        'database' => array(
                            'host' => 'localhost',
                            'user' => 'root',
                            'pass' => 'secret',
                            'name' => 'immortal',
                            'load' => true  // jika di set `true` aplikasi akan memanggil fungsi db_start() otomatis
                        )
                    );
                </code>
            </pre>
        </div>
        <div role="tabpanel" id="tab-doc-core" class="tab-pane">
            
            <h4><strong>set_var($key, $value)</strong></h4>
            Fungsi ini digunakan untuk menyimpan nilai yang dapat diakses secara global. 
            <pre>
                <code class="language-php">
                    set_var('foo', 'bar');
                </code>
            </pre>

            <h4><strong>get_var($key, $default = '')</strong></h4>
            Fungsi ini digunakan untuk mengakses nilai yang disimpan secara global menggunakan fungsi <b>set_var();</b>
            <pre>
                <code class="language-php">
                    get_var('foo'); 

                    // output:
                    bar
                </code>
            </pre>

            Parameter <b>$default</b> akan dikembalikan jika nilai yang dicari tidak ada.
            <pre>
                <code class="language-php">
                    get_var('baz', 'xyz'); 

                    // output:
                    xyz
                </code>
            </pre>

        </div>
        <div role="tabpanel" id="tab-doc-url" class="tab-pane">
            <h4><strong>base_url()</strong></h4>
            Fungsi ini digunakan untuk mendapatkan base url aplikasi. 
            <pre>
                <code class="language-php">
                    &lt;a href="&lt;?php echo base_url(); ?&gt;"&gt;Home&lt;/a&gt;
                    
                    // output:
                    &lt;a href="<?php echo base_url(); ?>"&gt;Home&lt;/a&gt;
                </code>
            </pre>

            <h4><strong>site_url($uri, $query = '')</strong></h4>
            Fungsi ini digunakan untuk merubah URI menjadi URL. 
            <pre>
                <code class="language-php">
                    &lt;a href="&lt;?php echo site_url('user/profile'); ?&gt;"&gt;Profile&lt;/a&gt;
                    
                    // output:
                    &lt;a href="<?php echo site_url('user/profile'); ?>"&gt;Profile&lt;/a&gt;
                </code>
            </pre>   
            Menambahkan query string:
            <pre>
                <code class="language-php">
                    &lt;a href="&lt;?php echo site_url('user/profile', 'foo=1&bar=2'); ?&gt;"&gt;Profile&lt;/a&gt;
                    
                    // output:
                    &lt;a href="<?php echo site_url('user/profile', 'foo=1&bar=2'); ?>"&gt;Profile&lt;/a&gt;
                </code>
            </pre>
            <h4><strong>current_url($query = '')</strong></h4>
            Fungsi ini digunakan untuk mendapatkan URL halaman yang aktif. 
            <pre>
                <code class="language-php">
                    &lt;form action="&lt;?php echo current_url(); ?&gt;" method="post"&gt;
                        &lt;input type="text" name="email"&gt;
                    &lt;/form&gt;

                    // output:
                    &lt;form action="<?php echo current_url(); ?>" method="post"&gt;
                        &lt;input type="text" name="email"&gt;
                    &lt;/form&gt;
                </code>
            </pre>
            Menambahkan query string:
            <pre>
                <code class="language-php">
                    &lt;form action="&lt;?php echo current_url('foo=1&bar=2'); ?&gt;" method="post"&gt;
                        &lt;input type="text" name="email"&gt;
                    &lt;/form&gt;

                    // output:
                    &lt;form action="<?php echo current_url('foo=1&bar=2'); ?>" method="post"&gt;
                        &lt;input type="text" name="email"&gt;
                    &lt;/form&gt;
                </code>
            </pre>   
            <h4><strong>asset_url($path)</strong></h4>
            Fungsi ini digunakan untuk mendapatkan URL dari file - file asset seperti image. 
            <pre>
                <code class="language-php">
                    &lt;img src="&lt;?php echo asset_url('img/logo.png'); ?&gt;" alt=""&gt;

                    // output:
                    &lt;img src="<?php echo asset_url('img/logo.png'); ?>" alt=""&gt;
                </code>
            </pre>   
            <h4><strong>redirect($uri)</strong></h4>
            Fungsi ini digunakan untuk berpindah halaman. 
            <pre>
                <code class="language-php">
                    if ( ! has_session('user')) {
                        redirect('user/profile');
                    }
                </code>
            </pre>   

        </div>
        <div role="tabpanel" id="tab-doc-session" class="tab-pane">
            <h4><strong>has_session($key)</strong></h4>
            Fungsi ini digunakan untuk memeriksa apakah sebuah data ada di dalam session. 
            <pre>
                <code class="language-php">
                    if ( ! has_session('user')) {
                        redirect('login');
                    }
                </code>
            </pre>          
            <h4><strong>set_session($key, $value)</strong></h4>
            Fungsi ini digunakan untuk menyimpan data ke dalam session. 
            <pre>
                <code class="language-php">
                    set_session('page', 'home');
                    set_session('user', array('email' => 'john@example.com'));
                </code>
            </pre>   
            <h4><strong>get_session($key, $default = '')</strong></h4>
            Fungsi ini digunakan untuk mendapatkan data dari session.
            <pre>
                <code class="language-php">
                    get_session('page'); 
                    
                    // output:
                    home

                    get_session('user'); 

                    // output:
                    Array(
                        [email] => john@example.com
                    );
                </code>
            </pre>            
            <h4><strong>unset_session($key)</strong></h4>
            Fungsi ini digunakan untuk menghapus data dari session.
            <pre>
                <code class="language-php">
                    unset_session('page');
                </code>
            </pre>           
            <h4><strong>clear_session()</strong></h4>
            Fungsi ini digunakan untuk menghapus semua data dari session.
            <pre>
                <code class="language-php">
                    clear_session();
                </code>
            </pre>            
        </div>
        <div role="tabpanel" id="tab-doc-database" class="tab-pane active">
            <h4><strong>db()</strong></h4>
            Fungsi ini digunakan mendapatkan referensi objek koneksi yang aktif. 
            <h4><strong>db_start()</strong></h4>
            Fungsi ini digunakan melakukan koneksi ke database. 
            <h4><strong>db_stop()</strong></h4>
            Fungsi ini digunakan menutup koneksi database. 
            <h4><strong>db_query($sql, $bind = array())</strong></h4>
            Fungsi ini digunakan untuk melakukan query data. 
            <pre>
                <code class="language-php">
                    $query = db_query('SELECT * FROM users');
                    $users = db_fetch_all($query);

                    foreach($users as $user) {
                        echo $user['email'];
                    }
                </code>
            </pre>
            Mengeksekusi perintah - perintah DML <b>(insert, update, delete)</b>
            <pre>
                <code class="language-php">
                    $insert = db_query('INSERT INTO products (id, name) VALUES (?, ?)', array(1, 'Notebook'));

                    if ($insert) {
                        echo 'Data berhasil disimpan';
                    }
                </code>
            </pre>
            <h4><strong>db_fetch_all($query)</strong></h4>
            Fungsi ini digunakan mendapatkan record dari query. 
            <pre>
                <code class="language-php">
                    $query = db_query('SELECT * FROM users');
                    $users = db_fetch_all($query);

                    foreach($users as $user) {
                        echo $user['email'];
                    }
                </code>
            </pre>
            <h4><strong>db_fetch_all($sql, $bind = array())</strong></h4>
            Fungsi ini digunakan untuk mendapatkan semua atau beberapa record dari sql.
            <pre>
                <code class="language-php">
                    $products = db_fetch_all('SELECT * FROM products');

                    foreach($products as $product) {
                        echo $product['sku'];
                    }
                </code>
            </pre>
            Menggunakan parameter binding:
            <pre>
                <code class="language-php">
                    $products = db_fetch_all('SELECT * FROM products WHERE slug = ?', array('notebook'));

                    foreach($products as $product) {
                        echo $product['sku'];
                    }
                </code>
            </pre>
            <h4><strong>db_fetch_one($sql, $bind = array())</strong></h4>
            Fungsi ini digunakan untuk mendapatkan satu record dari sql.
            <pre>
                <code class="language-php">
                    $product = db_fetch_one('SELECT * FROM products WHERE id = 1');
                    print_r($product);

                    // output:
                    Array (
                        [id] => 1
                        [name] => Notebook
                        [slug] => notebook
                    )
                </code>
            </pre>
            Menggunakan parameter binding:
            <pre>
                <code class="language-php">
                    $products = db_fetch_one('SELECT * FROM products WHERE slug = ?', array('notebook'));
                    print_r($product);

                    // output:
                    Array (
                        [id] => 1
                        [name] => Notebook
                        [slug] => notebook
                    )
                </code>
            </pre>
                <h4><strong>db_errors()</strong></h4>
                Fungsi ini mendapatkan log error database.
                <pre>
                    <code class="language-php">
                        $insert = db_query('INSERT INTO products (id, name) VALUES(?, ?)', array(1, 'Notebook'));

                        if ( ! $insert) {
                            foreach(db_errors() as $err) {
                                echo $err;
                            }
                        }
                    </code>
                </pre>
        </div>
        <div role="tabpanel" id="tab-doc-asset" class="tab-pane">
            <h4><strong>Thumbnail</strong></h4>
            Format URL untuk menampilkan gambar dalam bentuk <b>thumbnail</b>:
            <pre>
                <code class="language-markup">
                    image/thumb/100x100/path
                    |----------|-------|-----|
                                   |      |
                                   |      |_____ alamat file gambar
                                   |
                                   |____________ ukuran thumbnail (ex: 100x100)
                </code>
            </pre>            
            Contoh:
            <pre>
                <code class="language-php">
                    &lt;img src="&lt;?php echo site_url('image/thumb/100x100/path_to_img.jpg'); ?&gt;"&gt;
                </code>
            </pre>            
        </div>
        <div role="tabpanel" id="tab-doc-security" class="tab-pane">
            <h4><strong>Proteksi XSS</strong></h4>
            <div class="alert alert-warning">
                Defaultnya, semua inputan yang berasal dari <b>$_GET/$_POST</b> sudah diproteksi,
                sehingga tidak perlu memanggil fungsi proteksi xss.
            </div>
            
            Contoh proteksi manual;
            <pre>
                <code class="language-php">
                    xss_protect("Jum'at");  => Jum\'at
                    xss_protect("Jum\'at");  => Jum\\\'at
                    xss_protect("&lt;script&gt;alert(1)&lt;/script&gt;"); ?>") => alert(1)
                </code>
            </pre>    

            <h4><strong>Proteksi CSRF</strong></h4>
            Proteksi ini biasanya digunakan dalam penggunaan form POST.
            <pre>
                <code class="language-php">
                    &lt;form action="&lt;?php echo current_url(); ?&gt;" method="post"&gt;
                        &lt;?php csrf_inject(); ?&gt;
                        &lt;button name="submit"&gt;Submit&lt;/button&gt;
                    &lt;/form&gt;
                </code>
            </pre>  
            Kemudian, lakukan verifikasi di server:
            <pre>
                <code class="language-php">
                    $post = get_post();

                    if (isset($post['submit'])) {
                        csrf_protect();
                        // rest code...
                    }
                </code>
            </pre>  
        </div>
    </div>
</div>

<script src="<?php echo asset_url('vendor/prism/prism.js'); ?>" data-manual></script>
<script>
    loadCss('<?php echo asset_url("vendor/prism/prism.css"); ?>');
    Prism.highlightAll();
</script>