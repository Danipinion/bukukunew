<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link
        href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css"
        rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #efe5db;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #a0522d;
            border-radius: 10px;
            border: 2px solid #efe5db;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #8b4513;
        }

        * {
            font-family: "Ubuntu", sans-serif;
        }

        body {
            overflow: hidden;
        }

        #logo-sidebar a:hover {
            transform: translateX(5px);
        }

        .main-content {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .st-title {
            font-size: 2.5rem;
            color: #424242;
            margin-bottom: 1rem;
        }

        .st-subheader {
            font-size: 1.5rem;
            color: #424242;
            margin-bottom: 0.5rem;
        }

        .st-button {
            background-color: #a0522d;
            color: white;
            font-weight: bold;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: background-color 0.2s ease-in-out,
                transform 0.2s ease-in-out;
        }

        .st-button:hover {
            background-color: #8c4525;
            transform: scale(1.05);
        }

        .st-category-button {
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            font-weight: medium;
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out,
                transform 0.2s ease-in-out;
        }

        .st-category-button-active {
            background-color: #ffc857;
            color: #a0522d;
        }

        .st-category-button-inactive {
            background-color: #efe5db;
            color: #424242;
        }

        .st-category-button:hover {
            background-color: #ffc857;
            color: #a0522d;
            transform: scale(1.05);
        }

        .book-card {
            transition: transform 0.2s ease-in-out;
        }

        .book-card:hover {
            transform: translateY(-5px);
        }

        .book-card button:hover svg {
            transform: scale(1.1);
        }

        .lihat-semua:hover {
            animation: pulse 0.5s infinite alternate;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.05);
            }
        }
    </style>
    <title>Bacain-Home</title>
</head>

<body class="bg-[#FCF8F5]">
    <nav class="fixed top-0 z-10 w-full bg-[#FCF8F5] border-b border-gray-200">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button
                        data-drawer-target="logo-sidebar"
                        data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar"
                        type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <span class="sr-only">Open sidebar</span>
                        <svg
                            class="w-6 h-6"
                            aria-hidden="true"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                clip-rule="evenodd"
                                fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <img
                        src="<?= BASEURL; ?>/img/logo.png"
                        class="h-14 me-1"
                        alt="Bacain Logo" />
                    <span
                        class="self-center text-3xl font-medium whitespace-nowrap text-[#a0522d]">BACAIN</span>
                    <span
                        class="self-center text-3xl text-[#424242] ml-20 font-medium whitespace-nowrap">Selamat Datang <?= $_SESSION['username']; ?></span>
                    <form action="<?= BASEURL; ?>/user/search" method="GET" class="flex items-center ms-3">
                        <input
                            type="text"
                            name="query"
                            class="bg-[#a0522d]/10 py-3 px-3 h-10 text-xl font-semibold rounded-s-md border-none outline-none focus:outline-none focus:ring-none focus:border-none"
                            maxlength="25"
                            placeholder="Cari buku..."
                            value="<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>" />
                        <button
                            type="submit"
                            class="bg-[#a0522d] flex justify-center items-center py-3 px-3 h-10 text-2xl font-semibold rounded-e-md">
                            <svg
                                class="w-6 h-6 text-white"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                fill="none"
                                viewBox="0 0 24 24">
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div class="flex gap-5">
                            <a href="<?= BASEURL; ?>/user/riwayatPeminjaman">

                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 256 256" class="text-white">
                                    <path d="M136,80v43.47l36.12,21.67a8,8,0,0,1-8.24,13.72l-40-24A8,8,0,0,1,120,128V80a8,8,0,0,1,16,0Zm-8-48A95.44,95.44,0,0,0,60.08,60.15C52.81,67.51,46.35,74.59,40,82V64a8,8,0,0,0-16,0v40a8,8,0,0,0,8,8H72a8,8,0,0,0,0-16H49c7.15-8.42,14.27-16.35,22.39-24.57a80,80,0,1,1,1.66,114.75,8,8,0,1,0-11,11.64A96,96,0,1,0,128,32Z"></path>
                                </svg>
                            </a>

                            <button
                                type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300"
                                aria-expanded="false"
                                data-dropdown-toggle="dropdown-user">
                                <img
                                    class="w-10 h-10 rounded-full"
                                    src="<?= (stripos($_SESSION['photo'], 'http') === 0 || stripos($_SESSION['photo'], 'https') === 0) ? $_SESSION['photo'] : BASEURL . '/img/profile/' . $_SESSION['photo']; ?>"
                                    alt="user photo" />
                            </button>
                        </div>
                        <div
                            class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900" role="none"><?= $_SESSION['username']; ?></p>
                                <p class="text-sm font-medium truncate" role="none">
                                    <?= $_SESSION['email']; ?>
                                </p>
                            </div>
                            <ul role="none">
                                <li>
                                    <a
                                        href="<?= BASEURL; ?>/user/profile"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem">Profile</a>
                                </li>
                                <li>
                                    <form action="<?= BASEURL; ?>/auth/logout" method="post">
                                        <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left cursor-pointer" role="menuitem">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside
        id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-24 transition-transform -translate-x-full bg-transparent sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-transparent">
            <ul class="space-y-2 font-medium">
                <p class="mb-3 text-sm font-semibold text-[#424242]">Umum</p>
                <li>
                    <a
                        href="<?= BASEURL; ?>/user"
                        class="flex items-center p-3 rounded-md <?php if (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/bukukunew/public/user') {
                                                                    echo 'bg-[#FFC857]';
                                                                } ?> group transition-all">
                        <svg
                            class="w-7 h-7 text-[#424242]"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                fill-rule="evenodd"
                                d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ms-3 text-[#424242] font-bold">Home</span>
                    </a>
                </li>
                <li>
                    <a
                        href="<?= BASEURL; ?>/user/bukuku"
                        class="flex items-center p-3 rounded-md <?php if (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/bukukunew/public/user/bukuku') {
                                                                    echo 'bg-[#FFC857]';
                                                                } ?> transition-all hover:bg-[#FFC857] group">
                        <svg
                            class="w-7 h-7 text-[#424242]"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                fill-rule="evenodd"
                                d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ms-3 text-[#424242] font-bold">Bukuku</span>
                    </a>
                </li>
                <li>
                    <a
                        href="<?= BASEURL; ?>/user/bookmark"
                        class="flex items-center p-3 rounded-md <?php if (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/bukukunew/public/user/bookmark') {
                                                                    echo 'bg-[#FFC857]';
                                                                } ?> transition-all hover:bg-[#FFC857] group">
                        <svg
                            class="w-7 h-7 text-[#424242]"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M7.833 2c-.507 0-.98.216-1.318.576A1.92 1.92 0 0 0 6 3.89V21a1 1 0 0 0 1.625.78L12 18.28l4.375 3.5A1 1 0 0 0 18 21V3.889c0-.481-.178-.954-.515-1.313A1.808 1.808 0 0 0 16.167 2H7.833Z" />
                        </svg>
                        <span class="ms-3 text-[#424242] font-bold">Disimpan</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>