<div class="header">
    <h1>Delete Bill Type</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Addresses</a></li>
        <li><a href="/address/<?php echo htmlentities($recAddress->id()); ?>/summary">Address: <?php echo htmlentities($recAddress->street()); ?></a></li>
        <li><a href="/address/<?php echo htmlentities($recAddress->id()); ?>/bill-type">Bill Types</a></li>
        <li><a href="/address/<?php echo htmlentities($recAddress->id()); ?>/bill-type/<?php echo htmlentities($recBillType->id()); ?>/edit">Edit: <?php echo htmlentities($recBillType->name()); ?></a></li>
        <li>Delete</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <input type="hidden" id="bill_type.id" name="bill_type.id" value="<?php echo htmlentities($recBillType->id()); ?>" />
        <p>Are you sure you wish to delete this Bill Type?</p>
        <div class="input-group">
            <label class="form-control">Name</label>
            <div><samp><?php echo htmlentities($recBillType->name()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Unit</label>
            <div><samp><?php echo htmlentities($recBillType->unit()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Precision</label>
            <div><samp><?php echo htmlentities($recBillType->precision()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Bills</label>
            <div><samp><?php echo htmlentities(count($recBillType->bills())); ?></samp></div>
        </div>
        <div class="button-group">
            <button type="submit" class="button remove"><i class="fa-solid fa-trash"></i>Confirm Delete</button>
            <a href="/address/<?php echo htmlentities($recAddress->id()); ?>/bill-type/<?php echo htmlentities($recBillType->id()); ?>/edit" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
        </div>
    </form>
</div>