<?php

if ($userAuth->checkToken()) {
    $favorite = null;
    foreach ($data->addresses($userAuth->user()->id())->getRecords() as $address) {
        if (is_null($favorite)) {
            $favorite = true;
?>
            <div class="menu-title">Favorites</div>
        <?php
        }
        if ($address->favorite() === "No" && $favorite) {
            $favorite = false;
        ?>
            <div class="menu-title">Others</div>
        <?php
        }
        ?>
        <li>
            <a href="/address/<?php echo $address->id(); ?>/summary"><i class="fa-solid fa-location-dot"></i><?php echo htmlentities($address->street()); ?></a>
            <?php
            if (isset($address_id) && $address->id() == $address_id) {
                $bill_types = $data->bill_types($address->id())->getRecords();
                if (count($bill_types) > 0) {
            ?>
                    <ul>
                        <?php
                        foreach ($bill_types as $bill_type) {
                        ?>
                            <li><a href="/address/<?php echo $address->id(); ?>/bill-type/<?php echo $bill_type->id(); ?>/bill"><i></i><?php echo htmlentities($bill_type->name()); ?></a></li>
                        <?php
                        }
                        ?>
                    </ul>
            <?php
                }
            }
            ?>
        </li>
<?php
    }
}
