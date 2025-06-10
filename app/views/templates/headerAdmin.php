<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link
        href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css"
        rel="stylesheet" />
    <link
        href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.2.2/datatables.min.css"
        rel="stylesheet"
        integrity="sha384-EMec0P+bM7BzPRifh0Da2z4pEzNGzbb1pmzxZ/E0fZjPky+56QS2Y+x6U/00/L2z"
        crossorigin="anonymous" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet" />
    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #a0522d;
            border-radius: 10px;
            border: 2px solid #f1f1f1;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #8b4513;
        }

        * {
            font-family: "Ubuntu", sans-serif;
        }
    </style>
    <title>Bacain-Admin-<?= $data['judul']; ?></title>
</head>

<body class="bg-[#FCF8F5] overflow-hidden">
    <nav class="fixed top-0 z-10 w-full bg-transparent">
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
                        alt="FlowBite Logo" />
                    <span
                        class="self-center text-3xl font-medium whitespace-nowrap text-[#a0522d]">BACAIN</span>
                    <span
                        class="self-center text-3xl text-[#424242] ml-20 font-medium whitespace-nowrap">Selamat Datang Admin</span>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div class="flex gap-5">
                            <button
                                type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300"
                                aria-expanded="false"
                                data-dropdown-toggle="dropdown-user">
                                <img
                                    class="w-10 h-10 rounded-full"
                                    src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                    alt="user photo" />
                            </button>
                        </div>
                        <div
                            class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900" role="none">Danion</p>
                                <p class="text-sm font-medium truncate" role="none">
                                    testing@test.com
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <form action="<?= BASEURL; ?>/auth/logout" method="post">
                                        <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
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
                        href="<?= BASEURL; ?>/admin"
                        class="flex items-center p-3 rounded-md <?php echo ($data['judul'] == 'Dashboard') ? 'bg-[#FFC857]' : 'hover:bg-[#FFC857]'; ?> group">
                        <svg
                            class="w-7 h-7 <?php echo ($data['judul'] == 'Dashboard') ? 'text-[#a0522d]' : 'text-[#424242]'; ?>  transition duration-75"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3 <?php echo ($data['judul'] == 'Dashboard') ? 'text-[#a0522d]' : 'text-[#424242]'; ?> font-bold">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a
                        href="<?= BASEURL; ?>/admin/buku"
                        class="flex items-center p-3 rounded-md transition-all hover:bg-[#FFC857] group">
                        <svg
                            class="w-7 h-7 text-[#424242] transition duration-75"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M20 14h-2.722L11 20.278a5.511 5.511 0 0 1-.9.722H20a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1ZM9 3H4a1 1 0 0 0-1 1v13.5a3.5 3.5 0 1 0 7 0V4a1 1 0 0 0-1-1ZM6.5 18.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM19.132 7.9 15.6 4.368a1 1 0 0 0-1.414 0L12 6.55v9.9l7.132-7.132a1 1 0 0 0 0-1.418Z" />
                        </svg>

                        <span class="ms-3 text-[#424242] font-bold">Manajemen</span>
                    </a>
                </li>
                <li>
                    <a
                        href="<?= BASEURL; ?>/admin/peminjaman"
                        class="flex items-center p-3 rounded-md transition-all hover:bg-[#FFC857] group">
                        <svg
                            class="w-7 h-7 text-[#424242] transition duration-75"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z"
                                clip-rule="evenodd" />
                        </svg>

                        <span class="ms-3 text-[#424242] font-bold">Aktifitas</span>
                    </a>
                </li>
                <li>
                    <a
                        href="<?= BASEURL; ?>/admin/log"
                        class="flex items-center p-3 rounded-md transition-all <?php echo ($data['judul'] == 'Log') ? 'bg-[#FFC857]' : 'hover:bg-[#FFC857]'; ?> group">
                        <svg
                            class="w-7 h-7 <?php echo ($data['judul'] == 'Log') ? 'text-[#a0522d]' : 'text-[#424242]'; ?> transition duration-75"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="none"
                            viewBox="0 0 24 24">
                            <path
                                stroke="currentColor"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 12v1h4v-1m4 7H6a1 1 0 0 1-1-1V9h14v9a1 1 0 0 1-1 1ZM4 5h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                        </svg>

                        <span class="ms-3 <?php echo ($data['judul'] == 'Log') ? 'text-[#a0522d]' : 'text-[#424242]'; ?> font-bold">Log</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>