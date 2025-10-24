<div class="header">
    <h1>Edit Address</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Addresses</a></li>
        <li><a href="/address/<?php echo htmlentities($recAddress->id()); ?>/summary">Address: <?php echo htmlentities($recAddress->street()); ?></a></li>
        <li>Edit</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <input type="hidden" id="address.id" name="address.id" value="<?php echo htmlentities($recAddress->id()); ?>" />
        <div class="input-group">
            <label for="address.street" class="form-control">Street Address</label>
            <input type="text" id="address.street" name="address.street" class="form-control" required="required" value="<?php echo htmlentities($recAddress->street()); ?>" />
        </div>
        <div class="button-group">
            <button type="submit" class="button primary"><i class="fa-solid fa-save"></i>Save</button>
            <a href="/address/<?php echo htmlentities($recAddress->id()); ?>/summary" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
            <a href="/address/<?php echo htmlentities($recAddress->id()); ?>/delete" class="button remove"><i class="fa-solid fa-trash"></i>Delete?</a>
        </div>
    </form>
</div>