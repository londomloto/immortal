<div class="row">
	<div class="col-sm-3">
		<div class="panel panel-default">
			<div class="list-group list-group-dividered list-group-full">
				<?php $tables = db_list_tables(); ?>
				<?php foreach($tables as $tab): ?>
				<a class="list-group-item" data-push="1" href="<?php echo site_url("table/$tab"); ?>">
					Table <strong>`<?php echo $tab; ?>`</strong>
				</a>
				<?php endforeach; ?>
			</div>	
		</div>
		
	</div>
	<div class="col-sm-9">
		<div class="panel">

			<?php
			$table = uri_segment(1);
			
			$cols  = array();
			$rows  = array();

			if ( ! empty($table)) {
				$cols = db_field_data($table);
				$rows = db_fetch_all("SELECT * FROM $table");
			}
			?>
			<table class="table">
				<thead>
					<tr>
						<?php foreach($cols as $col): ?>
						<th><?php echo $col['name']; ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach($rows as $row): ?>
					<tr>
						<?php foreach($cols as $col): ?>
						<td><?php echo $row[$col['name']]; ?></td>
						<?php endforeach; ?>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

		</div>
		
	</div>
</div>

