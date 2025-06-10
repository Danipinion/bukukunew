<div class="p-4 sm:ml-64 mt-20 main-content">
    <div>
        <p class="st-subheader">Kategori / <?= $data['kategori_detail']['nama']; ?></p>
        <div class="flex gap-3 mb-5">
            <a href="<?= BASEURL; ?>">
                <div class="st-category-button st-category-button-inactive w-32 text-center">
                    All
                </div>
            </a>
            <?php foreach ($data['kategori'] as $kat) : ?>
                <a href="<?= BASEURL; ?>/user/kategori/<?= $kat['id']; ?>">
                    <div class="st-category-button <?= ($kat['id'] == $data['kategori_detail']['id']) ? 'st-category-button-active' : 'st-category-button-inactive'; ?> w-32 text-center">
                        <?= $kat['nama']; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="mt-5">
        <h3 class="text-2xl text-[#424242] font-medium mb-5">Kategori: <?= $data['kategori_detail']['nama']; ?></h3>
        <div
            class="flex flex-wrap gap-5 mt-7 animate__animated animate__fadeIn animate__delay-300ms">
            <?php if (empty($data['buku_by_kategori'])) : ?>
                <p>Tidak ada buku dalam kategori ini.</p>
            <?php else : ?>
                <?php foreach ($data['buku_by_kategori'] as $buku) : ?>
                    <div class="relative book-card">
                        <a href="<?= BASEURL; ?>/user/detail/<?= $buku['id_buku']; ?>">
                            <?php if ($buku['gambar']) : ?>
                                <img
                                    src="<?= BASEURL; ?>/img/<?= $buku['gambar']; ?>"
                                    alt="<?= $buku['judul']; ?>"
                                    class="w-[200px] rounded-md" />
                            <?php else : ?>
                                <img
                                    src="https://via.placeholder.com/200"
                                    alt="No Image"
                                    class="w-[200px] rounded-md" />
                            <?php endif; ?>
                            <p class="font-semibold mt-2 truncate"><?= $buku['judul']; ?></p>
                            <p class="font-medium text-[#a0522d] text-sm truncate">
                                <?= $buku['penulis']; ?>
                            </p>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>