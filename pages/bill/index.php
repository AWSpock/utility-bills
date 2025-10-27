<div class="header">
    <h1><?php echo htmlentities($recBillType->name()); ?> Bills</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Addresses</a></li>
        <li><a href="/address/<?php echo htmlentities($recAddress->id()); ?>/summary">Address: <?php echo htmlentities($recAddress->street()); ?></a></li>
        <li><?php echo htmlentities($recBillType->name()); ?> Bills</li>
    </ul>
</nav>

<div class="content">
    <div class="row">
        <h2>Last 12 <?php echo htmlentities($recBillType->name()); ?> Bills</h2>
        <div class="canvas">
            <canvas id="chart"></canvas>
        </div>
    </div>
    <div class="row">
        <?php
        if ($recAddress->isOwner() || $recAddress->isManager()) {
        ?>
            <a href="/address/<?php echo $recAddress->id(); ?>/bill-type/<?php echo $recBillType->id(); ?>/bill/create" class="button primary"><i class="fa-solid fa-plus"></i>Add <?php echo htmlentities($recBillType->name()); ?> Bill</a>
        <?php
        }
        ?>
    </div>
    <div class="row">
        <h2>All <?php echo htmlentities($recBillType->name()); ?> Bills</h2>
        <p>Record Count: <span id="data-table-count">?</span></p>
        <div class="data-table" id="data-table">
            <div class="data-table-row header-row">
                <div class="data-table-cell header-cell" data-id="bill-date">
                    <div class="data-table-cell-label">Bill Date</div>
                </div>
                <div class="data-table-cell header-cell" data-id="from-date">
                    <div class="data-table-cell-label">From Date</div>
                </div>
                <div class="data-table-cell header-cell" data-id="to-date">
                    <div class="data-table-cell-label">To Date</div>
                </div>
                <div class="data-table-cell header-cell" data-id="unit">
                    <div class="data-table-cell-label"><?php echo htmlentities($recBillType->unit()); ?></div>
                </div>
                <div class="data-table-cell header-cell" data-id="price">
                    <div class="data-table-cell-label">Price</div>
                </div>
                <div class="data-table-cell header-cell" data-id="created">
                    <div class="data-table-cell-label">Created</div>
                </div>
                <div class="data-table-cell header-cell" data-id="updated">
                    <div class="data-table-cell-label">Updated</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var unitLabel = "<?php echo htmlentities($recBillType->unit()); ?>";
</script>

<template id="template">
    <?php
    if ($recAddress->isOwner() || $recAddress->isManager()) {
    ?>
        <a href="/address/ADDRESS_ID/bill-type/BILL_TYPE_ID/bill/BILL_ID/edit" class="data-table-row">
        <?php
    } else {
        ?>
            <div class="data-table-row">
            <?php
        }
            ?>
            <div class="data-table-cell" data-id="bill-date">
                <div class="data-table-cell-label">Bill Date</div>
                <div class="data-table-cell-content"></div>
            </div>
            <div class="data-table-cell" data-id="from-date">
                <div class="data-table-cell-label">From Date</div>
                <div class="data-table-cell-content"></div>
            </div>
            <div class="data-table-cell" data-id="to-date">
                <div class="data-table-cell-label">To Date</div>
                <div class="data-table-cell-content"></div>
            </div>
            <div class="data-table-cell" data-id="unit">
                <div class="data-table-cell-label"><?php echo htmlentities($recBillType->unit()); ?></div>
                <div class="data-table-cell-content"></div>
            </div>
            <div class="data-table-cell" data-id="price">
                <div class="data-table-cell-label">Price</div>
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
            <?php
            if ($recAddress->isOwner() || $recAddress->isManager()) {
            ?>
        </a>
    <?php
            } else {
    ?>
        </div>
    <?php
            }
    ?>
</template>