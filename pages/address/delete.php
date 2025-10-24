<div class="header">
    <h1>Delete Address</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Addresses</a></li>
        <li><a href="/address/<?php echo htmlentities($recAddress->id()); ?>/summary">Address: <?php echo htmlentities($recAddress->street()); ?></a></li>
        <li><a href="/address/<?php echo htmlentities($recAddress->id()); ?>/edit">Edit</a></li>
        <li>Delete</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <input type="hidden" id="address.id" name="address.id" value="<?php echo htmlentities($recAddress->id()); ?>" />
        <p>Are you sure you wish to delete this Address?</p>
        <div class="input-group">
            <label class="form-control">Street</label>
            <div><samp><?php echo htmlentities($recAddress->street()); ?></samp></div>
        </div>
        <div class="input-group">
            <label class="form-control">Bill Types</label>
            <div><samp><?php echo htmlentities(count($recAddress->bill_types())); ?></samp></div>
        </div>
        <div class="button-group">
            <button type="submit" class="button remove"><i class="fa-solid fa-trash"></i>Confirm Delete</button>
            <a href="/address/<?php echo htmlentities($recAddress->id()); ?>/edit" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
        </div>
    </form>
</div>