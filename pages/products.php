<h1>Products List</h1>

<ul>
	<li><a href="<?php echo site_url('products/sepatu-casual') ?>" data-push="1">Sepatu Casual</a></li>
	<li><a href="<?php echo site_url('products/sepatu-sporty') ?>" data-push="1">Sepatu Sporty</a></li>
</ul>

<?php

$category = uri_segment(1);

// $query = mysql_query("SELECT * FROM products WHERE category = '$category'");

echo "Catalog <b>$category</b>";

?>
