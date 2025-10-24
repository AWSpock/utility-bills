<div class="header">
    <h1>Add Address</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Addresses</a></li>
        <li>Add Address</li>
    </ul>
</nav>

<div class="content">
    <form method="post" action="" id="frm" class="form-group main-form">
        <div class="input-group">
            <label for="address.street" class="form-control">Street Address</label>
            <input type="text" id="address.street" name="address.street" class="form-control" required="required" value="<?php echo htmlentities($recAddress->street()); ?>" />
        </div>
        <div class="button-group">
            <button type="submit" class="button primary"><i class="fa-solid fa-save"></i>Save</button>
            <a href="/" class="button secondary"><i class="fa-solid fa-ban"></i>Cancel</a>
        </div>
    </form>
</div>