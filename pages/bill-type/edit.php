<div class="header">
    <h1>Edit Bill Type</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Addresses</a></li>
        <li><a href="/address/<?php echo htmlentities($recAddress->id()); ?>/summary">Address: <?php echo htmlentities($recAddress->street()); ?></a></li>
        <li><a href="/address/<?php echo htmlentities($recAddress->id()); ?>/bill-type">Bill Types</a></li>
        <li>Edit: <?php echo htmlentities($recBillType->name()); ?></li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <input type="hidden" id="bill_type.id" name="bill_type.id" value="<?php echo htmlentities($recBillType->id()); ?>" />
        <input type="hidden" id="bill_type.address_id" name="bill_type.address_id" value="<?php echo htmlentities($recAddress->id()); ?>" />
        <div class="input-group">
            <label for="bill_type.name" class="form-control">Name</label>
            <input type="text" id="bill_type.name" name="bill_type.name" class="form-control" required="required" value="<?php echo htmlentities($recBillType->name()); ?>" />
        </div>
        <div class="input-group">
            <label for="bill_type.unit" class="form-control">Unit</label>
            <input type="text" id="bill_type.unit" name="bill_type.unit" class="form-control" required="required" value="<?php echo htmlentities($recBillType->unit()); ?>" />
        </div>
        <div class="input-group">
            <label for="bill_type.precision" class="form-control">Precision</label>
            <input type="number" id="bill_type.precision" name="bill_type.precision" class="form-control" required="required" value="<?php echo htmlentities($recBillType->precision()); ?>" step="1" min="0" />
        </div>
        <div class="button-group">
            <button type="submit" class="button primary"><i class="fa-solid fa-save"></i>Save</button>
            <a href="/address/<?php echo htmlentities($recAddress->id()); ?>/bill-type" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
            <a href="/address/<?php echo htmlentities($recAddress->id()); ?>/bill-type/<?php echo htmlentities($recBillType->id()); ?>/delete" class="button remove"><i class="fa-solid fa-trash"></i>Delete?</a>
        </div>
    </form>
</div>