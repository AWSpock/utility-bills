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
        <p>Record Count: <?php echo number_format(count($recBillType->bills())); ?></p>
        <div class="data-table">
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
            <?php
            $data1 = [];
            $data2 = [];
            $labels = [];
            foreach ($recBillType->bills() as $recBill) {
                if (count($data1) < 12) {
                    array_push($data1, str_replace(',', '', $recBillType->formatPrecision($recBill->unit())));
                    array_push($data2, str_replace(',', '', $recBill->price()));
                    array_push($labels, $recBill->bill_date());
                }
                if ($recAddress->isOwner() || $recAddress->isManager()) {
            ?>
                    <a href="/address/<?php echo htmlentities($recAddress->id()); ?>/bill-type/<?php echo htmlentities($recBillType->id()); ?>/bill/<?php echo htmlentities($recBill->id()); ?>/edit" class="data-table-row">
                    <?php
                } else {
                    ?>
                        <div class="data-table-row">
                        <?php
                    }
                        ?>
                        <div class="data-table-cell" data-id="bill-date">
                            <div class="data-table-cell-label">Bill Date</div>
                            <div class="data-table-cell-content"><?php echo $recBill->bill_date(); ?></div>
                        </div>
                        <div class="data-table-cell" data-id="from-date">
                            <div class="data-table-cell-label">From Date</div>
                            <div class="data-table-cell-content"><?php echo $recBill->from_date(); ?></div>
                        </div>
                        <div class="data-table-cell" data-id="to-date">
                            <div class="data-table-cell-label">To Date</div>
                            <div class="data-table-cell-content"><?php echo $recBill->to_date(); ?></div>
                        </div>
                        <div class="data-table-cell" data-id="unit">
                            <div class="data-table-cell-label"><?php echo htmlentities($recBillType->unit()); ?></div>
                            <div class="data-table-cell-content"><?php echo $recBillType->formatPrecision($recBill->unit()); ?></div>
                        </div>
                        <div class="data-table-cell" data-id="price">
                            <div class="data-table-cell-label">Price</div>
                            <div class="data-table-cell-content"><?php echo FormatMoney($recBill->price()); ?></div>
                        </div>
                        <div class="data-table-cell" data-id="created">
                            <div class="data-table-cell-label">Create</div>
                            <div class="data-table-cell-content"><?php echo $recBill->created(); ?></div>
                        </div>
                        <div class="data-table-cell" data-id="updated">
                            <div class="data-table-cell-label">Updated</div>
                            <div class="data-table-cell-content"><?php echo $recBill->updated(); ?></div>
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
                    }
?>
    </div>
</div>
</div>

<script>
    var data1 = [<?php echo implode(',', array_reverse($data1)); ?>];
    var data2 = [<?php echo implode(',', array_reverse($data2)); ?>];
    var labels = ['<?php echo implode('\',\'', array_reverse($labels)); ?>'];
    var unitLabel = "<?php echo htmlentities($recBillType->unit()); ?>";
</script>