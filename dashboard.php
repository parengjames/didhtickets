<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>IT Ticketing Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwind.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwind.min.js"></script>

    <!-- Tailwind Theme Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#F97316', // Orange
                        secondary: '#334155' // Slate
                    }
                }
            }
        }
    </script>
    <style>
        /* Best-practice DataTables row spacing */
        #ticketsTable th,
        #ticketsTable td {
            padding: 0.875rem 0.75rem;
            /* 14px vertical, 12px horizontal */
            vertical-align: middle;
        }

        #ticketsTable tbody tr {
            transition: background-color 0.2s ease;
        }

        @media (max-width: 640px) {

            #ticketsTable th,
            #ticketsTable td {
                padding: 0.625rem 0.5rem;
                /* compact on mobile */
                font-size: 0.875rem;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.2s ease-out;
        }
    </style>
</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        <!-- OVERLAY -->
        <div id="overlay"
            class="fixed inset-0 bg-black/50 z-30 hidden md:hidden">
        </div>
        <!-- SIDEBAR -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-secondary text-white
           transform -translate-x-full transition-transform duration-300
           md:relative md:translate-x-0 md:flex md:flex-col">

            <div class="p-6 text-xl font-bold text-primary">
                IT Ticketing
            </div>

            <nav class="flex-1 px-4 space-y-2">
                <a href="#" class="block px-4 py-2 rounded-lg bg-primary transition">
                    Dashboard
                </a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-600 transition">
                    Tickets
                </a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-600 transition">
                    Knowledge Base
                </a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-600 transition">
                    Reports
                </a>
            </nav>
        </aside>


        <!-- MAIN CONTENT -->
        <main class="flex-1 p-6">

            <div class="flex justify-between items-center mb-6">

                <!-- Burger (mobile only) -->
                <button id="menuBtn"
                    class="md:hidden p-2 rounded-lg bg-white shadow text-secondary">
                    ☰
                </button>

                <h1 class="text-2xl font-semibold text-secondary hidden md:block">
                    Ticket Dashboard
                </h1>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button id="profileBtn"
                        class="flex items-center gap-3 bg-white px-3 py-2 rounded-xl shadow hover:shadow-md transition">

                        <!-- Avatar -->
                        <img src="https://ui-avatars.com/api/?name=IT+Admin&background=F97316&color=fff"
                            alt="Avatar"
                            class="w-8 h-8 rounded-full object-cover">

                        <!-- Name -->
                        <div class="hidden sm:block text-left">
                            <p class="text-sm font-medium text-slate-700">IT Admin</p>
                            <p class="text-xs text-slate-500">Administrator</p>
                        </div>

                        <!-- Arrow -->
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div id="profileMenu"
                        class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-lg hidden z-50 overflow-hidden">

                        <!-- Profile Info -->
                        <div class="px-4 py-3 border-b">
                            <p class="text-sm font-semibold text-slate-700">IT Admin</p>
                            <p class="text-xs text-slate-500">it.admin@company.com</p>
                        </div>

                        <!-- Menu Items -->
                        <button onclick="openProfileModal()"
                            class="flex w-full items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-slate-100 transition">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Profile Details
                        </button>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-slate-100 transition">
                            <!-- Settings Icon -->
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.573-1.065z" />
                            </svg>
                            Account Settings
                        </a>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
                            <!-- Logout Icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                            </svg>
                            Logout
                        </a>

                    </div>
                </div>
            </div>

            <!-- SUMMARY CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition">
                    <p class="text-slate-500 text-sm">Open Tickets</p>
                    <p class="text-3xl font-bold text-primary">12</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition">
                    <p class="text-slate-500 text-sm">In Progress</p>
                    <p class="text-3xl font-bold text-yellow-500">7</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition">
                    <p class="text-slate-500 text-sm">Resolved</p>
                    <p class="text-3xl font-bold text-green-500">25</p>
                </div>

            </div>

            <!-- TICKET TABLE CARD -->
            <div class="bg-white rounded-2xl shadow p-6 transition">

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-secondary">
                        Ticket List
                    </h2>
                    <a href="#" class="bg-primary text-white px-4 py-2 rounded-lg hover:opacity-90 transition">
                        + New Ticket
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table id="ticketsTable" class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500 border-b">
                                <th>Ticket #</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr class="border-b hover:bg-slate-50 transition h-px">
                                <td>#1001</td>
                                <td>Printer not working</td>
                                <td>
                                    <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                        Open
                                    </span>
                                </td>
                                <td>High</td>
                                <td>
                                    <a href="#" class="text-primary hover:underline">View</a>
                                </td>
                            </tr>

                            <tr class="border-b hover:bg-slate-50 transition">
                                <td>#1002</td>
                                <td>Email not syncing</td>
                                <td>
                                    <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                        In Progress
                                    </span>
                                </td>
                                <td>Medium</td>
                                <td>
                                    <a href="#" class="text-primary hover:underline">View</a>
                                </td>
                            </tr>

                            <tr class="border-b hover:bg-slate-50 transition">
                                <td>#1003</td>
                                <td>PC won’t boot</td>
                                <td>
                                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                        Resolved
                                    </span>
                                </td>
                                <td>High</td>
                                <td>
                                    <a href="#" class="text-primary hover:underline">View</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </main>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal"
        class="fixed inset-0 bg-black/40 hidden flex items-center justify-center z-50">
        
        <div class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-xl animate-fadeIn">

            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-slate-700">Profile</h2>
                <button onclick="closeProfileModal()"
                    class="text-slate-400 hover:text-slate-600">
                    ✕
                </button>
            </div>

            <!-- Content -->
            <div class="p-6 space-y-6">

                <!-- Avatar -->
                <div class="flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name=IT+Admin&background=F97316&color=fff"
                        class="w-20 h-20 rounded-full object-cover">

                    <div>
                        <p class="text-lg font-semibold text-slate-700">IT Admin</p>
                        <p class="text-sm text-slate-500">Administrator</p>
                        <p class="text-xs text-slate-400">it.admin@company.com</p>
                    </div>
                </div>

                <!-- Info -->
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-slate-400">Department</p>
                        <p class="font-medium text-slate-700">IT Support</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Status</p>
                        <p class="font-medium text-green-600">Active</p>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-3 px-6 py-4 border-t">
                <button onclick="closeProfileModal()"
                    class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
                    Close
                </button>
                <button
                    class="px-4 py-2 rounded-xl bg-orange-500 text-white hover:bg-orange-600 transition">
                    Edit Profile
                </button>
            </div>
        </div>
    </div>


    <script>
        //DATATABLES INIT
        $(document).ready(function() {
            $('#ticketsTable').DataTable({
                pageLength: 10,
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search tickets..."
                },
                columnDefs: [{
                    orderable: false,
                    targets: 4
                }]
            });
        });

        //Side bar colapse when mobile....
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const menuBtn = document.getElementById('menuBtn');

        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        //Profile Dropdown
        const profileBtn = document.getElementById('profileBtn');
        const profileMenu = document.getElementById('profileMenu');

        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            profileMenu.classList.add('hidden');
        });

        //Modal script....
        function openProfileModal() {
            document.getElementById('profileModal').classList.remove('hidden');
            document.getElementById('profileMenu').classList.add('hidden');
        }

        function closeProfileModal() {
            document.getElementById('profileModal').classList.add('hidden');
        }
    </script>
</body>

</html>