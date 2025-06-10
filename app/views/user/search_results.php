<style>
    /* Add specific styles for the filter and pagination elements to match the theme */
    .filter-section {
        background-color: #EFE5DB;
        /* Light brown background */
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .filter-label {
        color: #a0522d;
        /* Theme primary color */
        font-weight: 600;
    }

    .filter-select {
        border-color: #d4b29c;
        /* Slightly darker border for input consistency */
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .filter-select:focus {
        border-color: #a0522d;
        box-shadow: 0 0 0 3px rgba(160, 82, 45, 0.2);
        /* Soft shadow with theme color */
    }

    .pagination-link {
        transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
    }

    .pagination-link.active {
        background-color: #a0522d;
        color: white;
        border-color: #a0522d;
    }

    .pagination-link:not(.active):hover {
        background-color: #f5f5f5;
        /* Lighter hover for non-active links */
        color: #a0522d;
        /* Theme color on hover */
    }

    /* General book card styling from previous context, ensuring consistency */
    .book-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        background-color: #FFFFFF;
        /* White background for cards, contrasting with filter section */
        border: 1px solid #e0e0e0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .book-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .book-card-title {
        color: #a0522d;
        /* Theme color for titles */
    }

    .book-card-author,
    .book-card-sisa {
        color: #616161;
        /* Darker gray for readability */
    }
</style>

<div class="p-4 sm:ml-64 mt-20">
    <p class="text-2xl text-[#424242] font-semibold mb-2">
        <?= $data['judul']; ?>
    </p>
    <div class="p-4 rounded-lg border-2 border-gray-200 border-dashed h-[calc(100vh-110px)] overflow-y-auto main-content">
        <?php Flasher::flash(); ?>

        <div class="filter-section flex flex-wrap items-center justify-between mb-6 gap-4">
            <div class="flex items-center gap-2">
                <label for="category-filter" class="filter-label text-gray-700 font-medium">Kategori:</label>
                <select id="category-filter" class="filter-select block w-full py-2 px-3 border bg-white rounded-md shadow-sm focus:outline-none sm:text-sm">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($data['kategori'] as $kategori) : ?>
                        <option value="<?= $kategori['id']; ?>" <?= (isset($_GET['kategori']) && $_GET['kategori'] == $kategori['id']) ? 'selected' : ''; ?>>
                            <?= $kategori['nama']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <label for="sort-by" class="filter-label text-gray-700 font-medium">Urutkan Berdasarkan:</label>
                <select id="sort-by" class="filter-select block w-full py-2 px-3 border bg-white rounded-md shadow-sm focus:outline-none sm:text-sm">
                    <option value="latest" <?= (isset($_GET['sort']) && $_GET['sort'] == 'latest') ? 'selected' : ''; ?>>Terbaru</option>
                    <option value="title_asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'title_asc') ? 'selected' : ''; ?>>Judul (A-Z)</option>
                    <option value="title_desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'title_desc') ? 'selected' : ''; ?>>Judul (Z-A)</option>
                </select>
            </div>
        </div>

        <?php if (empty($data['buku_results'])) : ?>
            <p class="text-center text-gray-500 mt-10">Tidak ada buku yang ditemukan untuk pencarian "<?= htmlspecialchars($data['search_query']); ?>"<?= (isset($_GET['kategori']) && !empty($_GET['kategori']) ? ' dalam kategori ini' : '') ?>.</p>
        <?php else : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($data['buku_results'] as $buku) : ?>
                    <a href="<?= BASEURL; ?>/user/detail/<?= $buku['id_buku']; ?>" class="block">
                        <div class="book-card rounded-lg shadow-md overflow-hidden">
                            <?php if ($buku['gambar']) : ?>
                                <img src="<?= BASEURL; ?>/img/<?= $buku['gambar']; ?>" alt="Sampul Buku <?= $buku['judul']; ?>" class="w-full h-48 object-cover" onerror="this.onerror=null;this.src='https://placehold.co/200x300/EFE5DB/424242?text=No+Image';" />
                            <?php else : ?>
                                <img src="https://placehold.co/200x300/EFE5DB/424242?text=No+Image" alt="No Image" class="w-full h-48 object-cover" />
                            <?php endif; ?>
                            <div class="p-4">
                                <h3 class="book-card-title text-lg font-semibold mb-1"><?= $buku['judul']; ?></h3>
                                <p class="book-card-author text-sm mb-2">Oleh: <?= $buku['penulis']; ?></p>
                                <p class="book-card-sisa text-xs">Sisa: <?= $buku['sisa']; ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <?php if ($data['total_pages'] > 1) : ?>
                <div class="flex justify-center mt-8">
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php if ($data['current_page'] > 1) : ?>
                            <a href="<?= BASEURL; ?>/user/search?query=<?= htmlspecialchars($data['search_query']); ?>&kategori=<?= htmlspecialchars($data['selected_category']); ?>&sort=<?= htmlspecialchars($data['selected_sort']); ?>&page=<?= $data['current_page'] - 1; ?>" class="pagination-link relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                Sebelumnya
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $data['total_pages']; $i++) : ?>
                            <a href="<?= BASEURL; ?>/user/search?query=<?= htmlspecialchars($data['search_query']); ?>&kategori=<?= htmlspecialchars($data['selected_category']); ?>&sort=<?= htmlspecialchars($data['selected_sort']); ?>&page=<?= $i; ?>" class="pagination-link relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium <?= ($i == $data['current_page']) ? 'active' : ''; ?>">
                                <?= $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($data['current_page'] < $data['total_pages']) : ?>
                            <a href="<?= BASEURL; ?>/user/search?query=<?= htmlspecialchars($data['search_query']); ?>&kategori=<?= htmlspecialchars($data['selected_category']); ?>&sort=<?= htmlspecialchars($data['selected_sort']); ?>&page=<?= $data['current_page'] + 1; ?>" class="pagination-link relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                Selanjutnya
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</div>

<script>
    document.getElementById('category-filter').addEventListener('change', function() {
        applyFilters();
    });

    document.getElementById('sort-by').addEventListener('change', function() {
        applyFilters();
    });

    function applyFilters() {
        const query = "<?= htmlspecialchars($data['search_query']); ?>";
        const category = document.getElementById('category-filter').value;
        const sort = document.getElementById('sort-by').value;
        let url = `<?= BASEURL; ?>/user/search?query=${encodeURIComponent(query)}`;

        if (category) {
            url += `&kategori=${encodeURIComponent(category)}`;
        }
        if (sort) {
            url += `&sort=${encodeURIComponent(sort)}`;
        }
        url += `&page=1`;
        window.location.href = url;
    }
</script>