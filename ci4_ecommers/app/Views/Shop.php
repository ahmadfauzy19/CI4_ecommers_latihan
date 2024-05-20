<?= $this->extend('/template') ?>

<?= $this->section('content') ?>

<!-- End Header/Navigation -->
<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('message') ?>
    </div>
<?php endif; ?>

<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Shop</h1>
                </div>
            </div>
            <div class="col-lg-7"></div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<!-- Start Product Section -->
<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">
            <?php foreach ($barang as $item) : ?>
                <div class="col-12 col-md-4 col-lg-3 mb-5">
                    <a class="product-item" href="<?= base_url('/cart' . $item['id_barang']) ?>">
                        <img src="<?= base_url('images/' . $item['gambar']) ?>" class="img-fluid product-thumbnail">
                        <h3 class="product-title"><?= $item['namaBarang']; ?></h3>
                        <strong class="product-price">Rp. <?= number_format($item['harga'], 0, ',', '.'); ?></strong>
                        <?php if ($item['stok'] == 0) : ?>
                            <p>stok habis</p>
                        <?php else :  ?>
                            <h5>stok</h5>
                            <p><?= $item['stok']; ?></p>
                        <?php endif; ?>
                        <span class="icon-cross">
                            <img src="<?= base_url('images/cross.svg') ?>" class="img-fluid">
                        </span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>