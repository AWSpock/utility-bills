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
		<p>Record Count: <span id="data-table-count">?</span></p>
		<div class="data-table" id="data-table">
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
		</div>
	</div>
</div>

<template id="template">
	<a href="/address/ADDRESS_ID/summary" class="data-table-row">
		<div class="data-table-cell" data-id="favorite">
			<div class="data-table-cell-label">Favorite</div>
			<div class="data-table-cell-content"></div>
		</div>
		<div class="data-table-cell" data-id="street">
			<div class="data-table-cell-label">Street</div>
			<div class="data-table-cell-content"></div>
		</div>
		<div class="data-table-cell" data-id="created">
			<div class="data-table-cell-label">Create</div>
			<div class="data-table-cell-content" data-dateformatter></div>
		</div>
		<div class="data-table-cell" data-id="updated">
			<div class="data-table-cell-label">Updated</div>
			<div class="data-table-cell-content" data-dateformatter></div>
		</div>
	</a>
</template>