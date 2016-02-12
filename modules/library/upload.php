
<script src="<?php echo asset_url('js/components/input-group-file.js'); ?>"></script>

<?php echo breadcrumb(); ?>

<h2>Upload</h2>
<?php
$products = db_fetch_all('SELECT * FROM products WHERE slug = ? AND name = ?', array('1'));
print_r($products);
?>