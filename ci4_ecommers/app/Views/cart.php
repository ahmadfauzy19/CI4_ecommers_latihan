<?= $this->extend('/template') ?>

<?= $this->section('content') ?>
<!-- End Header/Navigation -->

<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Cart</h1>
                </div>
            </div>
            <div class="col-lg-7">

            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<div class="untree_co-section before-footer-section">
    <div class="container">
        <div class="row mb-5">
            <form class="col-md-12" method="post">
                <div class="site-blocks-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="product-thumbnail">Image</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-total">Total</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                        </thead>
                        <?php if (session()->getFlashdata('message')) : ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('message') ?>
                            </div>
                        <?php endif; ?>
                        <tbody>
                            <?php foreach ($cart as $item) : ?>
                                <tr data-id="<?= $item['id'] ?>">
                                    <td class="product-thumbnail">
                                        <img src="<?= base_url('images/' . $item['gambar']) ?>" alt="Image" class="img-fluid">
                                    </td>
                                    <td class="product-name">
                                        <h2 class="h5 text-black"><?= $item['nama'] ?></h2>
                                    </td>
                                    <td class="product-price">Rp.<?= number_format($item['harga'], 2) ?></td>
                                    <td>
                                        <div class="input-group mb-3 d-flex align-items-center quantity-container" style="max-width: 120px;">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-black decrease" type="button">&minus;</button>
                                            </div>
                                            <input type="text" class="form-control text-center quantity-amount" value="<?= $item['kuantitas'] ?>" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-black increase" type="button">&plus;</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="product-total">Rp.<?= number_format($item['harga'] * $item['kuantitas'], 2) ?></td>
                                    <td><a href="<?= base_url('/hapusitem' . $item['id']) ?>" class="btn btn-black btn-sm">X</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="row mb-5">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <button class="btn btn-black btn-sm btn-block">Update Cart</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-black btn-sm btn-block">Continue Shopping</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="text-black h4" for="coupon">Coupon</label>
                        <p>Enter your coupon code if you have one.</p>
                    </div>
                    <div class="col-md-8 mb-3 mb-md-0">
                        <input type="text" class="form-control py-3" id="coupon" placeholder="Coupon Code">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-black">Apply Coupon</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pl-5">
                <div class="row justify-content-end">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12 text-right border-bottom mb-5">
                                <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <span class="text-black">Subtotal</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-black" id="cart-subtotal">Rp.<?= number_format($subtotal, 2) ?></strong>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <span class="text-black">Total</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-black" id="cart-total">Rp.<?= number_format($total, 2) ?></strong>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <a href="/checkout"><button class="btn btn-black btn-lg py-3 btn-block" onclick="window.location='checkout.html'">Proceed To Checkout</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function updateCartTotal() {
            var subtotal = 0;
            $('.product-total').each(function() {
                var totalValue = $(this).text().replace('$', '').replace(',', '');
                subtotal += parseFloat(totalValue);
            });

            $('#cart-subtotal').text('$' + subtotal.toFixed(2));
            $('#cart-total').text('$' + subtotal.toFixed(2));
        }

        function updateQuantity($row, newQuantity) {
            var priceText = $row.find('.product-price').text().replace('$', '').replace(',', '');
            var price = parseFloat(priceText);
            var $totalCell = $row.find('.product-total');
            var newTotal = price * newQuantity;
            $totalCell.text('$' + newTotal.toFixed(2));

            updateCartTotal();

            var productId = $row.data('id');
            $.ajax({
                url: '<?= base_url("cart/update") ?>',
                method: 'POST',
                data: {
                    id: productId,
                    quantity: newQuantity
                },
                success: function(response) {
                    console.log('Quantity updated');
                },
                error: function(xhr, status, error) {
                    console.error('Error updating quantity:', error);
                }
            });
        }

        $('.increase').click(function() {
            var $row = $(this).closest('tr');
            var $quantityInput = $row.find('.quantity-amount');
            var currentQuantity = parseInt($quantityInput.val());
            var newQuantity = currentQuantity + 1;

            $quantityInput.val(newQuantity);
            updateQuantity($row, newQuantity);
        });

        $('.decrease').click(function() {
            var $row = $(this).closest('tr');
            var $quantityInput = $row.find('.quantity-amount');
            var currentQuantity = parseInt($quantityInput.val());
            if (currentQuantity >= 1) {
                var newQuantity = currentQuantity - 1;
                $quantityInput.val(newQuantity);
                updateQuantity($row, newQuantity);
            }
        });
    });
</script>






<?= $this->endSection() ?>