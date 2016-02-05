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
				echo "Data tidak lengkap !";
			} else if ( ! empty($cek)){
				echo "Sudah ada data slug yang sama !";
			} else {																				
				
				$simpan = db_query(
					"INSERT INTO products (name, slug, category) VALUES (?, ?, ?)",
					array($name, $slug, $category)
				);

				if ($simpan) {
					echo "Data berhasil disimpan";
				} else {
					echo "Data gagal disimpan";
				}

			}

		break;

		case 'update':

			$id       = $post['id'];
			$name     = $post['name'];
			$slug     = $post['slug'];
			$category = $post['category'];

			$cek = db_fetch_one("SELECT * FROM products WHERE slug = ? AND id <> ?", array($slug, $id));

			if ( ! $name || ! $slug || ! $category) {
				echo "Data tidak lengkap !";
			} else if ( ! empty($cek)){
				echo "Sudah ada data slug yang sama !";
			} else {																			

				$ubah = db_query(
					"UPDATE products SET name = ?, slug = ?, category = ? WHERE id = ?",
					array($name, $slug, $category, $id)
				);
			
				if ($ubah) {
					echo "Data berhasil diubah";
				} else {
					echo "Data gagal diubah";
				}
			}
		break;

		case 'delete':

			$id = $post['id'];

			$delete = db_query("DELETE FROM products WHERE id = ?", array($id));
			
			if ($delete) {
				echo "Data berhasil dihapus";
			} else {
				echo "Data gagal dihapus";
			}

		break;

	}

	exit();
?>