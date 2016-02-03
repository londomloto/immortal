<?php
	$action = uri_segment(3); 
	$post   = get_post(); // auto sanitize

	switch($action) {
	
		case 'tampil':
			$return = db_fetch_one("SELECT * FROM products WHERE id= ?", array($post['id']));
			echo json_encode($return);	
		break;


		case 'save':

			$id       = $post['id'];
			$name     = $post['name'];
			$slug     = $post['slug'];
			$category = $post['category'];

			$cek = db_fetch_one("SELECT * FROM products WHERE slug = ?", array($slug));

			if ( ! $name || ! $slug || ! $category) {
				echo "<script language=\"Javascript\">\n";
				echo "window.alert('Data tidak lengkap !');";
				echo "</script>";
			} else if ( ! empty($cek)){
				echo "<script language=\"Javascript\">\n";
				echo "window.alert('Sudah ada data slug yang sama !');";
				echo "</script>";
			} else {																				
				
				$simpan = db_query(
					"INSERT INTO products (name, slug, category) VALUES (?, ?, ?)",
					array($name, $slug, $category)
				);

				if ($simpan) {
					echo "<script language=\"Javascript\">\n";
					echo "window.alert('Data berhasil disimpan');";
					echo "</script>";
				} else {
					echo "<script language=\"Javascript\">\n";
					echo "window.alert('Data gagal disimpan');";
					echo "</script>";
				}

			}

		break;

		case 'update':

			$id       = $post['id'];
			$name     = $post['name'];
			$slug     = $post['slug'];
			$category = $post['category'];

			$cek = db_fetch_one("SELECT * FROM products WHERE slug = ? AND id <> ?", array($slug, $id));

			if ( ! $name || ! $slug) {
				echo "<script language=\"Javascript\">\n";
				echo "window.alert('Data tidak lengkap !');";
				echo "</script>";
			} else if ( ! empty($cek)){
				echo "<script language=\"Javascript\">\n";
				echo "window.alert('Sudah ada data slug yang sama !');";
				echo "</script>";
			} else {																			

				$ubah = db_query(
					"UPDATE products SET name = ?, slug = ? WHERE id = ?",
					array($name, $slug, $id)
				);
			
				if ($ubah) {
					echo "<script language=\"Javascript\">\n";
					echo "window.alert('Data berhasil diubah');";
					echo "</script>";
				} else {
					echo "<script language=\"Javascript\">\n";
					echo "window.alert('Data gagal diubah');";
					echo "</script>";
				}
			}
		break;

		case 'delete':

			$id = $post['id'];

			$delete = db_query("DELETE FROM products WHERE id = ?", array($id));
			
			if ($delete) {
				echo "<script>\n";
				echo "alert('Data berhasil dihapus');";
				echo "</script>";
			} else {
				echo "<script>\n";
				echo "alert('Data gagal dihapus');";
				echo "</script>";
			}

		break;

	}

	exit();
?>