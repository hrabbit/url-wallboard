<h3>Widgets</h3>

<div class="row">
	<div class="col-md-12">
		<form action="/admin/widget/add" role="form" method="post">
			<table class="table table-striped table-bordered table-condensed">
				<tr>
					<th>Title (Overrides portlet title)</th>
					<th>URL</th>
					<th>Options</th>
				</tr>
				<tr>
					<td class="form-group"><input type="text" class="form-control" placeholder="Widget title" name="title"></td>
					<td class="form-group"><input type="url" class="form-control" placeholder="Full portlet URL" name="url"></td>
					<td class="form-group"><button type="submit" class="btn btn-success">Add</button></td>
				</tr>
				<?php foreach($widgets as $widget): ?>
					<tr>
						<td style="width: 200px"><?=$widget->title?></td>
						<td><?=$widget->url?></td>
						<td style="width: 10px"><a onClick="return confirm('Are you sure?')" class="btn btn-danger" href="/admin/widget/delete/<?=$widget->id?>">Delete</a></td>
					</tr>
				<?php endforeach ?>
			</table>
		</form>
	</div>
</div>