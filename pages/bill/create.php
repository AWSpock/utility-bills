<div class="header">
    <h1>Add <?php echo $recBillType->name(); ?> Bill</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Addresses</a></li>
        <li><a href="/address/<?php echo htmlentities($recAddress->id()); ?>/summary">Address: <?php echo htmlentities($recAddress->street()); ?></a></li>
        <li><a href="/address/<?php echo htmlentities($recAddress->id()); ?>/bill-type/<?php echo htmlentities($recBillType->id()); ?>/bill"><?php echo $recBillType->name(); ?> Bills</a></li>
        <li>Add</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <div class="input-group">
            <label for="bill.bill_date" class="form-control">Bill Date</label>
            <input type="date" id="bill.bill_date" name="bill.bill_date" class="form-control" required="required" value="<?php echo htmlentities($recBill->bill_date()); ?>" />
        </div>
        <div class="input-group">
            <label for="bill.from_date" class="form-control">From Date</label>
            <input type="date" id="bill.from_date" name="bill.from_date" class="form-control" required="required" value="<?php echo htmlentities($recBill->from_date()); ?>" />
        </div>
        <div class="input-group">
            <label for="bill.to_date" class="form-control">To Date</label>
            <input type="date" id="bill.to_date" name="bill.to_date" class="form-control" required="required" value="<?php echo htmlentities($recBill->to_date()); ?>" />
        </div>
        <div class="input-group">
            <label for="bill.unit" class="form-control"><?php echo $recBillType->unit(); ?></label>
            <input type="number" id="bill.unit" name="bill.unit" class="form-control" required="required" value="<?php echo htmlentities(str_replace(",", "", $recBillType->formatPrecision($recBill->unit()))); ?>" step="<?php echo htmlentities($recBillType->precisionDecimals()); ?>" min="0" />
        </div>
        <div class="input-group">
            <label for="bill.price" class="form-control">Price</label>
            <input type="number" id="bill.price" name="bill.price" class="form-control" required="required" value="<?php echo htmlentities($recBill->price()); ?>" step=".01" min="0" />
        </div>
        <div class="button-group">
            <button type="submit" class="button primary"><i class="fa-solid fa-save"></i>Save</button>
            <a href="/address/<?php echo htmlentities($recAddress->id()); ?>/bill-type/<?php echo htmlentities($recBillType->id()); ?>/bill" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
        </div>
    </form>
</div>