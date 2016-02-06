<?php echo breadcrumb(); ?>

<?php

$gambar = array(
	'image-models/model1.jpg',
	'image-models/model2.jpg',
	'image-models/model3.jpg'
);

?>

<div class="row">
<?php foreach($gambar as $g): ?>
	<div class="col-sm-4">
		<img src="<?php echo site_url("image/thumb/200x200/$g"); ?>">
	</div>
<?php endforeach; ?>
</div>

