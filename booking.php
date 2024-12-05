<?php
if (isset($_GET['id'])) {
    removetocart($_GET['id']);
}

if (isset($_POST['clear'])) {
    unset($_SESSION['pay']);
    unset($_SESSION['monbela_cart']);
    message("The cart is empty.", "success");
    redirect(WEB_ROOT . "booking/");
}

?>
<div class="card rounded" style="padding: 10px;">
    <div class="pagetitle">
        <h1>Booking Cart</h1>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-top: 10px;">
            <li class="breadcrumb-item"><a href="<?php echo WEB_ROOT; ?>index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Booking Cart</li>
        </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped responsive">
                    <thead>
                        <tr bgcolor="#999999">
                            <th align="center" width="120">Photo</th>
                            <th align="center" width="120">Room</th>
                            <th align="center" width="120">Check In</th>
                            <th align="center" width="120">Check Out</th>
                            <th width="120">Price</th>
                            <th align="center" width="120">Nights</th>
                            <th align="center" width="90">Amount</th>
                            <th align="center" width="90">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $payable = 0;
                        if (isset($_SESSION['monbela_cart'])) {
                            $count_cart = count($_SESSION['monbela_cart']);
                            for ($i = 0; $i < $count_cart; $i++) {
                                $query = "SELECT * FROM `tblroom` r ,`tblaccomodation` a WHERE r.`ACCOMID`=a.`ACCOMID` AND ROOMID=" . $_SESSION['monbela_cart'][$i]['monbelaroomid'];
                                $mydb->setQuery($query);
                                $cur = $mydb->loadResultList();
                                foreach ($cur as $result) {
                                    $amount = $_SESSION['monbela_cart'][$i]['monbelaroomprice']; ?>
                                    <tr>
                                        <td>
                                            <img width="100px" height="100px" src="../admin/mod_room/<?php echo $result->ROOMIMAGE; ?>">
                                        </td>
                                        <td><?php echo $result->ROOM . $result->ROOMDESC; ?></td>
                                        <td><?php echo date_format(date_create($_SESSION['monbela_cart'][$i]['monbelacheckin']), "m/d/Y"); ?></td>
                                        <td><?php echo date_format(date_create($_SESSION['monbela_cart'][$i]['monbelacheckout']), "m/d/Y"); ?></td>
                                        <td><?php echo "&#8369 $result->PRICE"; ?></td>
                                        <td><?php echo $_SESSION['monbela_cart'][$i]['monbeladay']; ?></td>
                                        <td><?php echo "&#8369 $amount"; ?></td>
                                        <td><a href="index.php?view=processcart&id=<?php echo $result->ROOMID ?>">Remove</a></td>
                                    </tr>
                                <?php }
                                $payable += $_SESSION['monbela_cart'][$i]['monbelaroomprice'];
                            }
                            $_SESSION['pay'] = $payable;
                        } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5"><h4 align="right">Total:</h4></td>
                            <td colspan="5">
                                <h4><b><?php echo isset($_SESSION['pay']) ? ' &#8369 ' . $_SESSION['pay'] : 'Your booking cart is empty.'; ?></b></h4>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <form method="post" action="">
                <div class="col-xs-12 col-sm-12" align="right">
                    <?php
                    if (isset($_SESSION['monbela_cart'])) {
                        ?>
                        <a href="<?php echo WEB_ROOT; ?>index.php?p=rooms" class="btn btn-primary" align="right" name="clear">Add Another Room</a>
                        <button type="submit" class="btn btn-primary" align="right" name="clear">Clear Cart</button>
                        <?php
                        if (isset($_SESSION['GUESTID'])) {
                            ?>
                            <a href="<?php echo WEB_ROOT; ?>booking/index.php?view=payment" class="btn btn-primary" align="right" name="continue">Continue Booking</a>
                            <?php
                            
                        } else {
                            ?>
                            <a href="<?php echo WEB_ROOT; ?>booking/index.php?view=logininfo" class="btn btn-primary" align="right" name="continue">Continue Booking</a>
                            <?php
                        }
                    } else {
                        // No items in the cart
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>
