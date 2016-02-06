<?php
    $page  = (int) get_param('page', 1);    // default page: 1
    $limit = 4;                             // sql query limit
    $start = $page * $limit - $limit;       // sql query offset

    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM products ";

    $params = get_param(); // like get_post()

    $where = array();
    $binds = array();

    foreach($params as $key => $val) {
        if ($key != 'page' && $val != '') {
            $where[] = "$key LIKE ?";
            $binds[] = "%{$val}%";
        }
    }

    $where = implode(' AND ', $where);

    if ( ! empty($where)) {
        $sql .= " WHERE $where ";
    }

    $sql .= "LIMIT $start, $limit";

    $products = db_fetch_all($sql, $binds);
    $total = db_total_rows();

?> 

<div class="row">
	<div class="col-sm-12">
        <div class="row">    
            <div class="col-md-3">
                <div class="list-group">
                    <form action="<?php echo current_url(); ?>" class="form-horizontal" data-push="1">
                        <div class="form-group"> 
                            <div class="col-sm-12">
                                <label class="control-label">Kategori</label>
                                <select name="category" id="category" class="form-control">
                                <option value="">--Pilih Category--</option> 
                                <?php 
                                    $sql = db_fetch_all("SELECT DISTINCT category FROM products");
                                    foreach($sql as $row):
                                        $sel = get_param('category') == $row['category'] ? 'selected' : '';
                                        echo "<option value='".$row['category']."' $sel>".$row['category']."</option>"; 
                                    endforeach;
                                ?>
                                </select>
                            </div>
                        </div>                
                        <div class="form-group"> 
                            <div class="col-sm-12">
                                <label class="control-label">Name</label>
                                <select name="name" id="name" class="form-control"> 
                                <option value="">--Pilih Name--</option> 
                                <?php 
                                    $sql = db_fetch_all("SELECT category, name FROM products");
                                    foreach($sql as $row):
                                        $sel = get_param('name') == $row['name'] ? 'selected' : '';
                                        echo "<option value='".$row['name']."' $sel>".$row['name']."</option>"; 
                                    endforeach;
                                ?>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group"> 
                            <div class="col-sm-12">
                                <label class="control-label">Slug</label>
                                <select name="slug" id="slug" class="form-control"> 
                                <option value="">--Pilih Slug--</option> 
                                <?php 
                                    $sql = db_fetch_all("SELECT * FROM products");
                                    foreach($sql as $row):
                                        $sel = get_param('slug') == $row['slug'] ? 'selected' : '';
                                        echo "<option value='".$row['slug']."' $sel>".$row['slug']."</option>"; 
                                    endforeach;
                                ?>
                                </select>	
                            </div>
                        </div>  
                        <div class="modal-footer">
                            <button type="submit" name="submit" class="btn btn-info" id="cari">Cari</button>                    
                        </div>              
                    </form>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <?php foreach($products as $row): ?>
                    <div class="col-md-3">
                        <center> 
                            <img class="img-rounded img-responsive" src="<?php echo asset_url($row['foto']); ?>" id="foto-product">
                            <h6><?php echo $row['category']; ?></h6>
                            <?php echo $row['name']; ?><br />
                            <a href="#" data-slug="<?php echo $row['slug']; ?>" class="link-product-detail">Detail</a>
                        </center>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div> 
            <nav>
            	<center><?php echo pagination($total, $limit); ?></center>
            </nav>                                    
        </div>		
	</div>
</div>

<script>
    $(document).ready(function(){

        var hasSession = '<?php echo has_session("pelanggan"); ?>';

        $('.link-product-detail').on('click', function(e){
            e.preventDefault();

            var slug = $(this).data('slug');

            if ( ! hasSession) {
                alert('Untuk melihat detail, Anda harus login dulu');
                loadPage(siteUrl('logpel') + '?ref=search-pag');
            } else {
                loadPage(siteUrl('products/' + slug));
            }

        });
    });
</script>