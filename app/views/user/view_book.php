<?php
$pdfPath = BASEURL . '/files/pdf/' . $data['buku']['pdf_file'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membaca: <?= htmlspecialchars($data['buku']['title']) ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --toolbar-height: 60px;
            --button-size: 40px;
            --background-color: #333;
            /* Tetap gelap untuk kontras PDF */
            --text-color: #fff;
            --primary-sienna: #a0522d;
            /* Sienna */
            --primary-amber: #FFC857;
            /* Amber */
            --dark-gray-text: #424242;
            /* Dark text from previous theme */
            --shadow-color: rgba(0, 0, 0, 0.4);
            --toolbar-bg-alpha: rgba(66, 66, 66, 0.7);
            /* Darker gray with transparency */
            --toolbar-button-hover-bg: rgba(255, 255, 255, 0.15);
            /* Light hover for toolbar buttons */
        }

        body {
            background-color: var(--background-color);
            margin: 0;
            font-family: "Ubuntu", sans-serif;
            /* Menggunakan font Ubuntu */
        }

        #pdf-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            padding-top: 20px;
            padding-bottom: calc(var(--toolbar-height) + 40px);
            /* Ruang agar tidak tertutup toolbar */
        }

        #pdf-container canvas {
            box-shadow: 0 6px 12px var(--shadow-color);
            border-radius: 8px;
            max-width: 95%;
            height: auto;
            transition: transform 0.2s ease-in-out;
        }

        /* TOOLBAR MODERN */
        #toolbar {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            height: var(--toolbar-height);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 0 20px;
            border-radius: 30px;
            background-color: var(--toolbar-bg-alpha);
            /* Menggunakan warna yang lebih cocok dengan tema */
            backdrop-filter: blur(10px) saturate(180%);
            -webkit-backdrop-filter: blur(10px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            z-index: 1000;
        }

        #toolbar .toolbar-section {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #toolbar .separator {
            width: 1px;
            height: 25px;
            background-color: rgba(255, 255, 255, 0.2);
        }

        #toolbar button {
            background: none;
            border: none;
            color: var(--text-color);
            cursor: pointer;
            width: var(--button-size);
            height: var(--button-size);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s ease;
        }

        #toolbar button:hover {
            background-color: var(--toolbar-button-hover-bg);
            /* Hover lebih terang */
        }

        #toolbar button:disabled {
            color: #888;
            cursor: not-allowed;
        }

        #toolbar button svg {
            width: 22px;
            height: 22px;
        }

        #page-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-color);
            font-size: 14px;
        }

        #page-indicator input {
            width: 40px;
            background-color: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-color);
            text-align: center;
            border-radius: 8px;
            padding: 5px;
            font-size: 14px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        #page-indicator input:focus {
            outline: none;
            border-color: var(--primary-sienna);
            /* Sienna saat fokus */
            box-shadow: 0 0 0 2px rgba(160, 82, 45, 0.3);
            /* Ring bayangan sienna */
        }

        /* Hapus panah di input number */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        #loading-indicator {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 20px;
            background-color: rgba(160, 82, 45, 0.7);
            /* Sienna dengan transparansi */
            padding: 20px 40px;
            border-radius: 12px;
            z-index: 1001;
            /* Pastikan di atas toolbar */
        }

        /* Style untuk link download */
        #download-btn button {
            /* Pastikan styling button di dalam <a> sama */
            background: none;
            border: none;
            color: var(--text-color);
            cursor: pointer;
            width: var(--button-size);
            height: var(--button-size);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s ease;
        }

        #download-btn button:hover {
            background-color: var(--toolbar-button-hover-bg);
        }
    </style>

    <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.4.168/pdf.min.mjs"></script>
</head>

<body>
    <div id="pdf-container"></div>

    <div id="loading-indicator">Memuat PDF...</div>

    <div id="toolbar">
        <div class="toolbar-section">
            <button id="back-btn" title="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
            </button>
            <div class="separator"></div>
            <button id="prev-page" title="Halaman Sebelumnya">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </button>
            <div id="page-indicator">
                <input type="number" id="page-num-input" value="1" min="1">
                <span>/</span>
                <span id="page-count">...</span>
            </div>
            <button id="next-page" title="Halaman Berikutnya">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
        <div class="separator"></div>
        <div class="toolbar-section">
            <button id="zoom-out" title="Perkecil">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </button>
            <button id="zoom-in" title="Perbesar">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </button>
        </div>
        <div class="separator"></div>
        <div class="toolbar-section">
            <a id="download-btn" href="<?= $pdfPath ?>" download title="Download PDF">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </button>
            </a>
            <button id="fullscreen-btn" title="Layar Penuh">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                </svg>
            </button>
        </div>
    </div>

    <script type="module">
        const pdfUrl = '<?= $pdfPath ?>';
        const {
            pdfjsLib
        } = globalThis;
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.4.168/pdf.worker.min.mjs';

        // --- State Management ---
        let pdfDoc = null;
        let currentPageNum = 1;
        let currentScale = 1.5;
        let canvases = [];

        // --- DOM Elements ---
        const container = document.getElementById('pdf-container');
        const loadingIndicator = document.getElementById('loading-indicator');
        const backBtn = document.getElementById('back-btn'); // Added back button
        const prevBtn = document.getElementById('prev-page');
        const nextBtn = document.getElementById('next-page');
        const pageNumInput = document.getElementById('page-num-input');
        const pageCountDisplay = document.getElementById('page-count');
        const zoomInBtn = document.getElementById('zoom-in');
        const zoomOutBtn = document.getElementById('zoom-out');
        const fullscreenBtn = document.getElementById('fullscreen-btn');

        // --- Core Rendering Function ---
        async function renderPdf(scale, goToPageAfterRender = currentPageNum) {
            currentScale = scale;
            try {
                loadingIndicator.style.display = 'block';
                container.textContent = ''; // Clear previous canvases
                canvases = [];

                const loadingTask = pdfDoc ? Promise.resolve(pdfDoc) : pdfjsLib.getDocument(pdfUrl).promise;
                pdfDoc = await loadingTask;

                loadingIndicator.style.display = 'none';
                pageCountDisplay.textContent = pdfDoc.numPages;
                pageNumInput.max = pdfDoc.numPages;

                for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                    const page = await pdfDoc.getPage(pageNum);
                    const viewport = page.getViewport({
                        scale: currentScale
                    });
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;
                    canvas.dataset.pageNum = pageNum;

                    container.appendChild(canvas);
                    canvases.push(canvas);

                    page.render({
                        canvasContext: context,
                        viewport: viewport
                    });
                }
                // Scroll to the current page after re-rendering all pages (e.g., after zoom)
                if (canvases[goToPageAfterRender - 1]) {
                    canvases[goToPageAfterRender - 1].scrollIntoView({
                        behavior: 'instant', // Use 'instant' to prevent weird scroll effects after zoom
                        block: 'start'
                    });
                }
                updateCurrentPageInView();


            } catch (error) {
                console.error('Error loading PDF:', error);
                loadingIndicator.style.display = 'block';
                loadingIndicator.textContent = `Gagal memuat PDF: ${error.message}`;
            }
        }

        // --- UI Control Functions ---
        function updateCurrentPageInView() {
            let mostVisiblePage = 1;
            let maxVisibility = 0;

            const viewportHeight = window.innerHeight;

            canvases.forEach((canvas, index) => {
                const rect = canvas.getBoundingClientRect();
                const visibleHeight = Math.max(0, Math.min(rect.bottom, viewportHeight) - Math.max(rect.top, 0));

                // Consider a page "most visible" if more than 50% of it is in view,
                // or if it's the only one with significant visibility.
                if (visibleHeight > maxVisibility && visibleHeight > (canvas.height * 0.5)) {
                    maxVisibility = visibleHeight;
                    mostVisiblePage = index + 1;
                } else if (maxVisibility === 0 && visibleHeight > 0) { // Fallback for very short pages or odd scrolls
                    mostVisiblePage = index + 1;
                    maxVisibility = visibleHeight;
                }
            });
            currentPageNum = mostVisiblePage;
            pageNumInput.value = currentPageNum;
            updateNavButtons();
        }

        function updateNavButtons() {
            prevBtn.disabled = currentPageNum <= 1;
            nextBtn.disabled = currentPageNum >= pdfDoc.numPages;
        }

        function goToPage(num) {
            const pageNum = parseInt(num);
            if (pageNum >= 1 && pageNum <= pdfDoc.numPages) {
                canvases[pageNum - 1].scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                currentPageNum = pageNum; // Update current page immediately for input field
                pageNumInput.value = pageNum;
                updateNavButtons();
            } else {
                // Revert input value if invalid
                pageNumInput.value = currentPageNum;
            }
        }

        // --- Event Listeners ---
        backBtn.addEventListener('click', () => {
            history.back(); // Kembali ke halaman sebelumnya
        });
        prevBtn.addEventListener('click', () => goToPage(currentPageNum - 1));
        nextBtn.addEventListener('click', () => goToPage(currentPageNum + 1));
        pageNumInput.addEventListener('change', () => goToPage(pageNumInput.value));

        zoomInBtn.addEventListener('click', () => renderPdf(currentScale + 0.25, currentPageNum));
        zoomOutBtn.addEventListener('click', () => {
            if (currentScale > 0.25) renderPdf(currentScale - 0.25, currentPageNum);
        });

        fullscreenBtn.addEventListener('click', () => {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        });

        // Update page number indicator on scroll
        let scrollTimeout;
        window.addEventListener('scroll', () => {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(updateCurrentPageInView, 150);
        });

        // --- Initial Load ---
        renderPdf(currentScale);
    </script>

</body>

</html>