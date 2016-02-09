<?php echo breadcrumb(); ?>

<h1>Dokumentasi</h1>

<div class="nav-tabs-horizontal">
    <ul role="tablist" data-plugin="nav-tabs" class="nav nav-tabs nav-tabs-line">
        <li role="presentation" class=""><a role="tab" href="#tab-doc-config" data-toggle="tab" aria-expanded="true">Konfigurasi</a></li>
        <li role="presentation" class=""><a role="tab" href="#tab-doc-core" data-toggle="tab" aria-expanded="false">Core</a></li>
        <li role="presentation" class=""><a role="tab" href="#tab-doc-url" data-toggle="tab" aria-expanded="false">URL</a></li>
        <li role="presentation" class=""><a role="tab" href="#tab-doc-session" data-toggle="tab" aria-expanded="false">Session</a></li>
        <li role="presentation" class="active"><a role="tab" href="#tab-doc-database" data-toggle="tab" aria-expanded="false">Database</a></li>
    </ul>
    <div class="tab-content padding-top-20">
        <div role="tabpanel" id="tab-doc-config" class="tab-pane">
            <p>Konfigurasi aplikasi disimpan di dalam file <code>config.php</code> </p>
<pre>
return array(
    'name' => 'immortal/immortal',
    'version' => '1.0.0',
    'title' => 'Immortal',
    'description' => 'procedural php application',
    'keywords' => 'procedural, php',
    'authors' => '...',
    'index' => '',
    'default' => '',
    'libraries' => array(
        'database',
        'pagination'
    ),
    'database' => array(
        'host' => 'localhost',
        'user' => 'root',
        'pass' => 'secret',
        'name' => 'immortal',
        'load' => TRUE
    )
);
</pre>
        </div>
        <div role="tabpanel" id="tab-doc-core" class="tab-pane">
            
            <h3>set_var($key, $value)</h3>
            <p>Fungsi ini digunakan untuk menyimpan nilai yang dapat diakses secara global. </p>
<pre>
set_var('foo', 'bar');
</pre>

            <h3>get_var($key, $default = '')</h3>
            <p>Fungsi ini digunakan untuk mengakses nilai yang disimpan secara global menggunakan fungsi <code>set_var();</code></p>
<pre>
get_var('foo'); 
-> bar
</pre>
            <p>Parameter <code>$default</code> akan dikembalikan jika nilai yang dicari tidak ada.</p>
<pre>
get_var('baz', 'xyz'); 
-> xyz
</pre>

        </div>
        <div role="tabpanel" id="tab-doc-url" class="tab-pane">
            <h3>base_url()</h3>
            <p>Fungsi ini digunakan untuk mendapatkan base url aplikasi. </p>
<pre>
base_url();    
-> http://dev.local/immortal/
</pre>   
            <h3>site_url($uri, $query = '')</h3>
            <p>Fungsi ini digunakan untuk mendapatkan url dari URI yang dimaksud. </p>
<pre>
site_url('user/profile');    
-> http://dev.local/immortal/user/profile.xyz
</pre>   
            <p>Menambahkan query string</p>
<pre>
site_url('user/profile', 'id=1&status=1'); 
-> http://dev.local/immortal/user/profile.xyz?id=1&status=1
</pre>
            <h3>current_url($query = '')</h3>
            <p>Fungsi ini digunakan untuk mendapatkan url dari URI yang dimaksud. </p>
<pre>
current_url(); 
-> http://dev.local/immortal/products.xyz
</pre>
            <p>Menambahkan query string</p>
<pre>
current_url('page=2'); 
-> http://dev.local/immortal/products.xyz?page=2
</pre>   
            <h3>redirect($uri)</h3>
            <p>Fungsi ini digunakan untuk berpindah halaman. </p>
<pre>
redirect('user/profile');    
-> header("Location: http://dev.local/immortal/user/profile.xyz")
</pre>   
        </div>
        <div role="tabpanel" id="tab-doc-session" class="tab-pane">
            <h3>has_session($key)</h3>
            <p>Fungsi ini digunakan untuk memeriksa apakah sebuah data ada di dalam session. </p>
<pre>
if ( ! has_session('user')) {
    redirect('login');
}
</pre>          
            <h3>set_session($key, $value)</h3>
            <p>Fungsi ini digunakan untuk menyimpan data ke dalam session. </p>
<pre>
set_session('page', 'home');
set_session('user', array('email' => 'john@example.com'));
</pre>   
            <h3>get_session($key, $default = '')</h3>
            <p>Fungsi ini digunakan untuk mendapatkan data dari session. </p>
<pre>
get_session('page'); 
-> home
get_session('user'); 
-> Array(
    [email] => 'john@example.com'
);
</pre>            
            <h3>unset_session($key)</h3>
            <p>Fungsi ini digunakan untuk menghapus data dari session. </p>
<pre>
unset_session('page');
</pre>           
            <h3>clear_session()</h3>
            <p>Fungsi ini digunakan untuk menghapus semua data dari session. </p>
<pre>
clear_session();
</pre>            
        </div>
        <div role="tabpanel" id="tab-doc-database" class="tab-pane active">
            <h3>db()</h3>
            <p>Fungsi ini digunakan mendapatkan referensi objek koneksi yang aktif. </p>
            <h3>db_start()</h3>
            <p>Fungsi ini digunakan melakukan koneksi ke database. </p>
            <h3>db_stop()</h3>
            <p>Fungsi ini digunakan menutup koneksi database. </p>
            <h3>db_query($sql, $bind = array())</h3>
            <p>Fungsi ini digunakan untuk melakukan query data. </p>
<pre>
$query = db_query("SELECT * FROM users");

if ($query) {
    while($row = mysqli_fetch_array($query)) {
        // your code here...
    }
}
</pre>
<p>Mengeksekusi perintah - perintah DML <code>(insert, update, delete)</code></p>
<pre>
$insert = db_query('INSERT INTO products (id, name) VALUES (?, ?)', array(1, 'Notebook'));

if ($insert) {
    echo 'Data berhasil disimpan';
}
</pre>
            <h3>db_fetch_all($sql, $bind = array())</h3>
                <p>Fungsi ini merupakan shortcut dari <code>db_query()</code> untuk mendapatkan semua atau beberapa data.</p>
<pre>
$products = db_fetch_all('SELECT * FROM products');

foreach($products as $product) {
    // your code here...
}
</pre>
            <h3>db_fetch_one($sql, $bind = array())</h3>
                <p>Fungsi ini merupakan shortcut dari <code>db_query()</code> untuk mendapatkan satu data.</p>
<pre>
$product = db_fetch_one('SELECT * FROM products WHERE id = 1');
print_r($product);

-> Array (
    [id] => 1
    [name] => Notebook
    [slug] => notebook
)
</pre>
                <p>Binding parameter</p>
<pre>
$product = db_fetch_one('SELECT * FROM products WHERE id = ?', array(1));
</pre>
                <h3>db_errors()</h3>
                <p>Fungsi ini mendapatkan log error database.</p>
<pre>
$insert = db_query('INSERT INTO products (id, name) VALUES(?, ?)', array(1, 'Notebook'));

if ( ! $insert) {
    
    $errors = db_errors();

    foreach($errors as $err) {
        echo $err;
    }
}
</pre>
        </div>
    </div>
</div>


