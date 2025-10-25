<div class="header">
    <h1>Address Summary</h1>
</div>

<nav class="breadcrumbs">
    <ul>
        <li><a href="/">Addresses</a></li>
        <li>Address: <?php echo htmlentities($recAddress->street()); ?></li>
    </ul>
</nav>

<div class="content">
    <div class="row">
        <div class="options">
            <form method="post" action="" id="frm" class="inline">
                <?php
                if ($recAddress->favorite() == "No") {
                ?>
                    <button type="submit" name="address.favorite" value="Yes" class="link secondary" title="Add Favorite"><i class="fa-regular fa-star"></i></button>
                <?php
                } else {
                ?>
                    <button type="submit" name="address.favorite" value="No" class="link secondary" title="Remove Favorite"><i class="fa-solid fa-star"></i></button>
                <?php
                }
                ?>
            </form>
            <?php
            if ($recAddress->isOwner()) {
            ?>
                <a href="/address/<?php echo htmlentities($address_id); ?>/edit" class="button secondary"><i class="fa-solid fa-pencil"></i>Edit Address</a>
                <a href="/address/<?php echo htmlentities($address_id); ?>/bill-type" class="button secondary"><i class="fa-solid fa-gear"></i>Bill Types</a>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="row">
        <div class="bill-types">
            <?php
            foreach ($recAddress->bill_types() as $recBillType) {
                $totalUnit = 0;
                $totalPrice = 0;
                $lastUnit = null;
                $lastPrice = null;
                $maxUnit = null;
                $maxPrice = null;
                $minUnit = null;
                $minPrice = null;
                foreach ($recBillType->bills() as $bill) {
                    $totalUnit += $bill->unit();
                    $totalPrice += $bill->price();
                    if ($lastUnit === null)
                        $lastUnit = $bill->unit();
                    if ($lastPrice === null)
                        $lastPrice = $bill->price();
                    if ($maxUnit === null || $maxUnit < $bill->unit())
                        $maxUnit = $bill->unit();
                    if ($maxPrice === null || $maxPrice < $bill->price())
                        $maxPrice = $bill->price();
                    if ($minUnit === null || $minUnit > $bill->unit())
                        $minUnit = $bill->unit();
                    if ($minPrice === null || $minPrice > $bill->price())
                        $minPrice = $bill->price();
                }
                $avgUnit = $totalUnit / count($recBillType->bills());
                $avgPrice = $totalPrice / count($recBillType->bills());
            ?>
                <div class="bill-type">
                    <h2><?php echo $recBillType->name(); ?></h2>
                    <div class="options">
                        <a href="/address/<?php echo $recAddress->id(); ?>/bill-type/<?php echo $recBillType->id(); ?>/bill">View Bills</a>
                        <a href="/address/<?php echo $recAddress->id(); ?>/bill-type/<?php echo $recBillType->id(); ?>/bill/create">Add Bill</a>
                    </div>
                    <div class="info">
                        <div>Record Count: <?php echo count($recBillType->bills()); ?></div>
                        <?php
                        if (count($recBillType->bills()) > 0) {
                            /*
                    ?>
                        <div>Last <?php echo htmlentities($recBillType->unit()); ?>: <?php echo $recBillType->formatPrecision($lastUnit); ?></div>
                        <div>Last Price: <?php echo FormatMoney($lastPrice); ?></div>
                        <div>Average <?php echo htmlentities($recBillType->unit()); ?>: <?php echo $recBillType->formatPrecision($avgUnit); ?></div>
                        <div>Average Price: <?php echo FormatMoney($avgPrice); ?></div>
                    <?php
                    */

                        ?>
                            <h3>Last Bill</h3>
                            <div class="gauges">
                                <div class="info__block selected" data-id="last">
                                    <div class="gauge">
                                        <div class="gauge__body">
                                            <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage($lastUnit, $minUnit, $maxUnit); ?>turn);"></div>
                                            <div class="gauge__cover primary">
                                                <div class="gauge__mid"><?php echo $recBillType->formatPrecision($lastUnit); ?></div>
                                            </div>
                                        </div>
                                        <div class="gauge__title"><?php echo htmlentities($recBillType->unit()); ?></div>
                                    </div>
                                    <div class="gaugeLabelBottom">
                                        <div><?php echo $recBillType->formatPrecision($minUnit); ?></div>
                                        <div><?php echo $recBillType->formatPrecision($maxUnit); ?></div>
                                    </div>
                                </div>
                                <div class="info__block selected" data-id="last">
                                    <div class="gauge">
                                        <div class="gauge__body">
                                            <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage($lastPrice, $minPrice, $maxPrice); ?>turn);"></div>
                                            <div class="gauge__cover primary">
                                                <div class="gauge__mid"><?php echo FormatMoney($lastPrice); ?></div>
                                            </div>
                                        </div>
                                        <div class="gauge__title">Price</div>
                                    </div>
                                    <div class="gaugeLabelBottom">
                                        <div><?php echo FormatMoney($minPrice); ?></div>
                                        <div><?php echo FormatMoney($maxPrice); ?></div>
                                    </div>
                                </div>
                            </div>
                            <h3>Average</h3>
                            <div class="gauges">
                                <div class="info__block selected" data-id="avg">
                                    <div class="gauge">
                                        <div class="gauge__body">
                                            <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage($avgUnit, $minUnit, $maxUnit); ?>turn);"></div>
                                            <div class="gauge__cover primary">
                                                <div class="gauge__mid"><?php echo $recBillType->formatPrecision($avgUnit); ?></div>
                                            </div>
                                        </div>
                                        <div class="gauge__title"><?php echo htmlentities($recBillType->unit()); ?></div>
                                    </div>
                                    <div class="gaugeLabelBottom">
                                        <div><?php echo $recBillType->formatPrecision($minUnit); ?></div>
                                        <div><?php echo $recBillType->formatPrecision($maxUnit); ?></div>
                                    </div>
                                </div>
                                <div class="info__block selected" data-id="avg">
                                    <div class="gauge">
                                        <div class="gauge__body">
                                            <div class="gauge__fill" style="transform: rotate(<?php echo returnPercentage($avgPrice, $minPrice, $maxPrice); ?>turn);"></div>
                                            <div class="gauge__cover primary">
                                                <div class="gauge__mid"><?php echo FormatMoney($avgPrice); ?></div>
                                            </div>
                                        </div>
                                        <div class="gauge__title">Price</div>
                                    </div>
                                    <div class="gaugeLabelBottom">
                                        <div><?php echo FormatMoney($minPrice); ?></div>
                                        <div><?php echo FormatMoney($maxPrice); ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>