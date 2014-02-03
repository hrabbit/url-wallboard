<h3>Options</h3>

<div class="row">
	<div class="col-md-12">
		<table class="table table-striped table-bordered table-condensed">
			<tr>
				<th>Key</th>
				<th>Value</th>
				<th>Options</th>
			</tr>
			<tr>
				<form action="/admin/option/add" role="form" method="post">
					<td class="form-group"><input type="text" class="form-control" placeholder="Key" name="key"></td>
					<td class="form-group"><input type="text" class="form-control" placeholder="Value" name="value"></td>
					<td class="form-group"><button type="submit" class="btn btn-success">Add</button></td>
				</form>
			</tr>
			<?php foreach($options as $option): ?>
			<tr>
				<form method="post" role="form" action="/admin/option/update/<?=$option->id?>">
					<td style="width: 200px"><?=preg_replace('/_/', ' ', $option->key)?></td>
					<td class="form-group"><input type="text" class="form-control" name="value" value="<?=$option->value?>"></td>
					<td style="width: 200px">
						<button type="submit" class="btn btn-info">Update</button> 
						<?php if(!$option->required): ?>
						<a onClick="return confirm('Are you sure?')" class="btn btn-danger" href="/admin/option/delete/<?=$option->id?>">Delete</a>
						<?php endif ?>
					</td>
				</form>
			</tr>
			<?php endforeach ?>
		</table>
	</div>
</div>