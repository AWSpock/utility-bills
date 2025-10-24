<div class="header">
	<h1>Addresses</h1>
</div>

<nav class="breadcrumbs">
	<ul>
		<li>Addresses</li>
	</ul>
</nav>

<div class="content">
	<div class="row">
		<a href="/address/create" class="button primary"><i class="fa-solid fa-plus"></i>Add Address</a>
	</div>
	<div class="row">
		<p>Record Count: <?php echo number_format(count($addresses)); ?></p>
		<div class="data-table">
			<div class="data-table-row header-row">
				<div class="data-table-cell header-cell" data-id="favorite">
					<div class="data-table-cell-label">Favorite</div>
				</div>
				<div class="data-table-cell header-cell" data-id="Street">
					<div class="data-table-cell-label">Street</div>
				</div>
				<div class="data-table-cell header-cell" data-id="Created">
					<div class="data-table-cell-label">Created</div>
				</div>
				<div class="data-table-cell header-cell" data-id="Updated">
					<div class="data-table-cell-label">Updated</div>
				</div>
			</div>
			<?php
			foreach ($addresses as $recAddress) {
			?>
				<a href="/address/<?php echo htmlentities($recAddress->id()); ?>/summary" class="data-table-row">
					<div class="data-table-cell" data-id="favorite">
						<div class="data-table-cell-label">Favorite</div>
						<div class="data-table-cell-content"><?php echo $recAddress->favorite(); ?></div>
					</div>
					<div class="data-table-cell" data-id="street">
						<div class="data-table-cell-label">Street</div>
						<div class="data-table-cell-content"><?php echo $recAddress->street(); ?></div>
					</div>
					<div class="data-table-cell" data-id="created">
						<div class="data-table-cell-label">Create</div>
						<div class="data-table-cell-content" data-dateformatter><?php echo $recAddress->created(); ?></div>
					</div>
					<div class="data-table-cell" data-id="updated">
						<div class="data-table-cell-label">Updated</div>
						<div class="data-table-cell-content" data-dateformatter><?php echo $recAddress->updated(); ?></div>
					</div>
				</a>
			<?php
			}
			?>
		</div>
	</div>
</div>