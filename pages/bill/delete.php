<div class="header">
    <h1>Delete <?php echo htmlentities($recBillType->name()); ?> Bill</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Addresses</a></li>
        <li><a href="/address/<?php echo htmlentities($recAddress->id()); ?>/summary">Address: <?php echo htmlentities($recAddress->street()); ?></a></li>
        <li><a href="/address/<?php echo htmlentities($recAddress->id()); ?>/bill-type/<?php echo htmlentities($recBillType->id()); ?>/bill"><?php echo $recBillType->name(); ?> Bills</a></li>
        <li><a href="/address/<?php echo htmlentities($recAddress->id()); ?>/bill-type/<?php echo htmlentities($recBillType->id()); ?>/bill/<?php echo htmlentities($recBill->id()); ?>/edit">Edit: <?php echo htmlentities($recBill->bill_date()); ?></a></li>
        <li>Delete</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <input type="hidden" id="bill_type.id" name="bill_type.id" value="<?php echo htmlentities($recBill->id()); ?>" />
        <p>Are you sure you wish to delete this Bill?</p>
        <div class="input-group">
            <label class="form-control">Date</label>
            <div><samp><?php echo htmlentities($recBill->bill_date()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">From Date</label>
            <div><samp><?php echo htmlentities($recBill->from_date()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">To Date</label>
            <div><samp><?php echo htmlentities($recBill->to_date()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Unit</label>
            <div><samp><?php echo htmlentities($recBillType->formatPrecision($recBill->unit())); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Price</label>
            <div><samp><?php echo htmlentities($recBill->price()); ?></samp></div>
        </div>
        <div class="button-group">
            <button type="submit" class="button remove"><i class="fa-solid fa-trash"></i>Confirm Delete</button>
            <a href="/address/<?php echo htmlentities($recAddress->id()); ?>/bill-type/<?php echo htmlentities($recBillType->id()); ?>/bill/<?php echo htmlentities($recBill->id()); ?>/edit" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
        </div>
    </form>
</div>