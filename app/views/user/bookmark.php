<div class="p-4 sm:ml-64 mt-20 main-content">
    <div>
        <p class="st-subheader">Bookmark</p>
    </div>
    <div class="mt-5">
        <?php if (empty($data['buku_bookmark'])) : ?>
            <p>Anda belum memiliki buku yang di-bookmark.</p>
        <?php else : ?>
            <div
                class="flex flex-wrap gap-5 mt-7 animate__animated animate__fadeIn animate__delay-300ms">
                <?php foreach ($data['buku_bookmark'] as $buku) : ?>
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
                        <a href="<?= BASEURL; ?>/user/hapusDariBookmark/<?= $buku['id_buku']; ?>"
                            class="absolute top-2 right-2 z-10 p-2 bg-[#FFC857]/70 rounded-full hover:bg-[#FFC857]/90 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#a0522d" viewBox="0 0 256 256">
                                <path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"></path>
                            </svg>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>