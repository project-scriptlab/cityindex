<table class="table table-centered table-bordered table-striped dt-responsive nowrap w-100">
	<thead>
		<tr>
			<th>#</th>
			<th>Previous Amount</th>
			<th>Withdrawl Amount</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
		<?php if (!empty($details)): $i = 1;?>
			<?php foreach ($details as $det): ?>
				<tr>
					<td><?= $i++; ?></td>
					<td><?= $det->previous_amount; ?></td>
					<td><?= $det->withdrawl_amount; ?></td>
					<td><?= date('M j, Y', $det->created_at); ?></td>
				</tr>
			<?php endforeach ?>
		<?php endif ?>
	</tbody>
</table>