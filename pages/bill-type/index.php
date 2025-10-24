<div class="header">
	<h1>Address Bill Types</h1>
</div>

<nav class="breadcrumbs">
	<ul>
		<li><a href="/">Addresses</a></li>
		<li><a href="/address/<?php echo htmlentities($recAddress->id()); ?>/summary">Address: <?php echo htmlentities($recAddress->street()); ?></a></li>
		<li>Bill Types</li>
	</ul>
</nav>

<div class="content">
	<div class="row">
		<a href="/address/<?php echo htmlentities($recAddress->id()); ?>/bill-type/create" class="button primary"><i class="fa-solid fa-plus"></i>Add Bill Type</a>
	</div>
	<div class="row">
		<p>Record Count: <?php echo number_format(count($recAddress->bill_types())); ?></p>
		<?php
		if (count($recAddress->bill_types()) < 1) {
		?>
			<div class="alert alert-info">
				<p>No Bill Types Exists</p>
			</div>
		<?php
		} else {
		?>
			<div class="data-table">
				<div class="data-table-row header-row">
					<div class="data-table-cell header-cell" data-id="name">
						<div class="data-table-cell-label">Name</div>
					</div>
					<div class="data-table-cell header-cell" data-id="unit">
						<div class="data-table-cell-label">Unit</div>
					</div>
					<div class="data-table-cell header-cell" data-id="precision">
						<div class="data-table-cell-label">Precision</div>
					</div>
					<div class="data-table-cell header-cell" data-id="created">
						<div class="data-table-cell-label">Created</div>
					</div>
					<div class="data-table-cell header-cell" data-id="updated">
						<div class="data-table-cell-label">Updated</div>
					</div>
				</div>
				<?php
				foreach ($recAddress->bill_types() as $recBillType) {
				?>
					<tr>
						<a href="/address/<?php echo htmlentities($recAddress->id()); ?>/bill-type/<?php echo htmlentities($recBillType->id()); ?>/edit" class="data-table-row">
							<div class="data-table-cell" data-id="name">
								<div class="data-table-cell-label">Name</div>
								<div class="data-table-cell-content"><?php echo $recBillType->name(); ?></div>
							</div>
							<div class="data-table-cell" data-id="unit">
								<div class="data-table-cell-label">Unit</div>
								<div class="data-table-cell-content"><?php echo $recBillType->unit(); ?></div>
							</div>
							<div class="data-table-cell" data-id="precision">
								<div class="data-table-cell-label">Precision</div>
								<div class="data-table-cell-content"><?php echo $recBillType->precision(); ?></div>
							</div>
							<div class="data-table-cell" data-id="created">
								<div class="data-table-cell-label">Create</div>
								<div class="data-table-cell-content"><?php echo $recBillType->created(); ?></div>
							</div>
							<div class="data-table-cell" data-id="updated">
								<div class="data-table-cell-label">Updated</div>
								<div class="data-table-cell-content"><?php echo $recBillType->updated(); ?></div>
							</div>
						</a>
					</tr>
				<?php
				}
				?>
			</div>
		<?php
		}
		?>
	</div>
</div>