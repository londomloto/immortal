<?php
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	if (isset($_GET['tampil'])){
		$SQL = db_query("SELECT * FROM products WHERE id='".$_POST['id']."'");
		$return = mysqli_fetch_array($SQL,MYSQLI_ASSOC);
		echo json_encode($return);	
	}else
	if (isset($_GET['save'])){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$slug = $_POST['slug'];
		$category = $_POST['category'];
		$cek = db_query("SELECT * FROM products WHERE slug ='$slug'");
			
		if(!$name || !$slug || !$category){
			echo "<script language=\"Javascript\">\n";
				echo "window.alert('Data tidak lengkap !');";
			echo "</script>";
		}else
		if(mysqli_num_rows($cek) <> 0){
			echo "<script language=\"Javascript\">\n";
				echo "window.alert('Sudah ada data slug yang sama !');";
			echo "</script>";
		}else{																				
			$simpan = mysqli_query($con, "INSERT INTO products SET 
										name='".$name."',
										slug='".$slug."',
										category='".$category."'");
	
			if($simpan){
				echo "<script language=\"Javascript\">\n";
					echo "window.alert('Data berhasil disimpan');";
				echo "</script>";
			}else{
				echo "<script language=\"Javascript\">\n";
					echo "window.alert('Data gagal disimpan');";
				echo "</script>";
			}	
		}
	}else
	if (isset($_GET['update'])){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$slug = $_POST['slug'];
		$category = $_POST['category'];
		$cek = db_query("SELECT * FROM products WHERE slug = '$slug' AND id <> '$id'");
			
		if(!$name || !$slug){
			echo "<script language=\"Javascript\">\n";
				echo "window.alert('Data tidak lengkap !');";
			echo "</script>";
		}else
		if(mysqli_num_rows($cek) <> 0){
			echo "<script language=\"Javascript\">\n";
				echo "window.alert('Sudah ada data slug yang sama !');";
			echo "</script>";
		}else{																			
			$ubah = db_query("UPDATE products SET name='".$_POST['name']."', slug='".$_POST['slug']."' WHERE id='".$_POST['id']."'");
	
			if($ubah){
				echo "<script language=\"Javascript\">\n";
					echo "window.alert('Data berhasil diubah');";
				echo "</script>";
			}else{
				echo "<script language=\"Javascript\">\n";
					echo "window.alert('Data gagal diubah');";
				echo "</script>";
			}	
		}
	}else
	if (isset($_GET['delete'])){		
		$id = $_POST['id'];
		$delete = db_query("DELETE FROM products WHERE id='".$_POST['id']."'");
	
		if($delete){
			echo "<script language=\"Javascript\">\n";
				echo "window.alert('Data berhasil dihapus');";
			echo "</script>";
		}else{
			echo "<script language=\"Javascript\">\n";
				echo "window.alert('Data gagal dihapus');";
			echo "</script>";
		}	
	}
	
?>