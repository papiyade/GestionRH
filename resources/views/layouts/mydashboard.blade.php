<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @vite('resources/css/app.css') <!-- Pour Tailwind ou votre CSS -->
    <style>
        h1 h2 h3 h4 h5 h6 p {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-cyan-900 text-white h-full fixed flex flex-col">
            <a href="#" class="p-4 flex items-center space-x-4">
                <img class="w-12"
                    src="https://th.bing.com/th/id/R.1a551aa4cba59342dff2decfbaa9c8dd?rik=KQTDhx1ZUAAfjA&riu=http%3a%2f%2fpluspng.com%2fimg-png%2flogo-template-png-logo-templates-1655.png&ehk=9MRokJPqMM6lr6AsMn50qqBGQgGuPYXFuTzMFbKjOa8%3d&risl=&pid=ImgRaw&r=0"
                    alt="">
                <h1 class="text-3xl font-mono italic font-bold">Farlu</h1>
            </a>
            <ul class="space-y-4 p-4">
                <li><a href="/user/profile"
                        class="hover:text-blue-400 flex align-items m-2 p-2 {{ request()->is('user/profile') ? 'bg-blue-500 text-white rounded-md' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span class="ml-2">Mon Profil</span></a></li>
                <hr class="bg-gray-400 my-4">
                <li>
                    <div class="relative">
                        <button onclick="toggleTeamsDropdown()"
                            class="hover:text-blue-400 flex align-items m-2 p-2 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            <span class="ml-2">Mes équipes</span>
                            <svg class="ml-auto size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 9l-7.5 7.5L4.5 9" />
                            </svg>
                        </button>
                        <ul id="teams-dropdown" class="hidden bg-cyan-800 text-white rounded-md mt-2">
                            @foreach (Auth::user()->teams as $team)
                                <li><a href="{{ route('teams.show', $team->id) }}"
                                        class="block px-4 py-2 hover:bg-cyan-700">{{ $team->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <hr class="bg-gray-400 my-4">
                <li>
                    <div class="relative">
                        <button onclick="toggleProjectsDropdown()"
                            class="hover:text-blue-400 flex align-items m-2 p-2 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
                            </svg>
                            <span class="ml-2">Projets</span>
                            <svg class="ml-auto size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 9l-7.5 7.5L4.5 9" />
                            </svg>
                        </button>
                        <ul id="projects-dropdown" class="hidden bg-cyan-800 text-white rounded-md mt-2">
                            @if (Auth::user()->projects)
                                @foreach (Auth::user()->projects as $project)
                                    @if ($project->teams->members->contains(Auth::user()))
                                        <li><a href="{{ route('projects.show', $project->id) }}"
                                                class="block px-4 py-2 hover:bg-cyan-700">{{ $project->name }}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </li>
                <hr class="bg-gray-400 my-4">
                <li><a href="{{ route('calendar.index') }}"
                        class="hover:text-blue-400 flex align-items m-2 p-2 {{ request()->routeIs('calendar.index') ? 'bg-blue-500 text-white rounded-md' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        <span class="ml-2">Calendrier</span></a></li>
                <hr class="bg-gray-400 my-4">
                <li>
                    <a href="{{ route('calendar.index') }}"
                        class="hover:text-blue-400 flex align-items m-2 p-2 {{ request()->routeIs('tasks.index') ? 'bg-blue-500 text-white rounded-md' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
                        </svg>

                        <span class="ml-2">Tâches</span>
                        @php
                            $taskCount = Auth::user()->tasks()->where('deadline', '>', now())->count();
                        @endphp
                        @if ($taskCount > 0)
                            <span
                                class="ml-auto bg-red-600 text-white rounded-full font-bold px-2 py-1 text-xs">{{ $taskCount }}</span>
                        @endif
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="flex items-center m-2 p-2">
                        @csrf
                        <button type="submit" class="hover:text-blue-400 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9" />
                            </svg>
                            <span class="ml-2">Déconnexion</span>
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <script>
            function toggleTeamsDropdown() {
                const teamsDropdown = document.getElementById('teams-dropdown');
                teamsDropdown.classList.toggle('hidden');
            }

            function toggleProjectsDropdown() {
                const projectsDropdown = document.getElementById('projects-dropdown');
                projectsDropdown.classList.toggle('hidden');
            }
        </script>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Header -->
            <nav class="bg-gradient-to-r from-sky-500 to-indigo-500">
                <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                    <div class="relative flex h-16 items-center justify-between">
                        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                            <!-- Mobile menu button-->
                            <button type="button"
                                class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                aria-controls="mobile-menu" aria-expanded="false">
                                <span class="absolute -inset-0.5"></span>
                                <span class="sr-only">Open main menu</span>
                                <!--
                          Icon when menu is closed.

                          Menu open: "hidden", Menu closed: "block"
                        -->
                                <svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                                <!--
                          Icon when menu is open.

                          Menu open: "block", Menu closed: "hidden"
                        -->
                                <svg class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                            <div class="flex shrink-0 items-center">
                                <img class="h-8 w-auto"
                                    src="https://th.bing.com/th/id/R.1a551aa4cba59342dff2decfbaa9c8dd?rik=KQTDhx1ZUAAfjA&riu=http%3a%2f%2fpluspng.com%2fimg-png%2flogo-template-png-logo-templates-1655.png&ehk=9MRokJPqMM6lr6AsMn50qqBGQgGuPYXFuTzMFbKjOa8%3d&risl=&pid=ImgRaw&r=0"
                                    alt="">
                            </div>
                            <div class="hidden sm:ml-6 sm:block">
                                <div class="flex space-x-4">
                                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                    <a href="{{ route('tableau-de-bord') }}"
                                        class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('tableau-de-bord') ? 'bg-cyan-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}"
                                        aria-current="page">Mon Tableau de Bord</a>
                                    <a href="{{ route('teams.index') }}"
                                        class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('teams.index') ? 'bg-cyan-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Mes
                                        Equipes</a>
                                    <a href="{{ route('projects.index') }}"
                                        class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('projects.index') ? 'bg-cyan-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Mes
                                        Projets</a>
                                    <a href="{{ route('calendar.index') }}"
                                        class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('calendar.index') ? 'bg-cyan-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Calendrier</a>
                                </div>
                            </div>
                        </div>
                        <button id="darkModeToggle" onclick="toggleDarkMode()"
                            class="px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-700 dark:bg-cyan-700 dark:hover:bg-yellow-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                            </svg>
                        </button>
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                const theme = localStorage.getItem('theme');
                                if (theme === 'dark') {
                                    document.documentElement.classList.add('dark');
                                    document.querySelector('#darkModeToggle').innerHTML =
                                        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" /></svg>';
                                } else {
                                    document.documentElement.classList.remove('dark');
                                    document.querySelector('#darkModeToggle').innerHTML =
                                        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" /></svg>';
                                }
                            });
                        </script>

                        <div
                            class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                            <!-- Notifications Dropdown -->
                            @if (Auth::user()->tasks()->count() > 0)
                            <div class="relative ml-3">
                                <button type="button"
                                    class="relative flex rounded-full bg-cyan-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                    id="notifications-menu-button" aria-expanded="false" aria-haspopup="true"
                                    onclick="toggleDropdown('notifications-dropdown')">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open notifications menu</span>
                                    <svg class="size-6 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                        data-slot="icon">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                    </svg>
                                    <span
                                    class="ml-auto bg-red-600 text-white rounded-full font-bold px-2 py-1 text-xs">{{ Auth::user()->tasks()->count() }}</span>
                                </button>
                                <div id="notifications-dropdown"
                                    class="hidden absolute right-0 mt-2 w-64 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="notifications-menu-button">
                                    <div class="px-4 py-2 border-b">
                                        <h3 class="text-lg font-semibold text-gray-700">Notifications</h3>
                                    </div>
                                    <ul>
                                        @foreach (Auth::user()->tasks as $task)
                                            <li class="flex items-center px-4 py-2 hover:bg-gray-100">
                                                <svg class="size-6 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12l2 2 4-4m0 0a9 9 0 1 1-6.364-2.636A9 9 0 0 1 21 12h-2.25" />
                                                </svg>
                                                <a href="{{ route('tasks.show', ['task' => $task->id]) }}" class="text-sm text-gray-700">{{ $task->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif

                            <!-- Profile dropdown -->
                            <div class="relative ml-3">
                                <div>
                                    <button type="button"
                                        class="relative flex rounded-full bg-cyan-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                        id="user-menu-button" aria-expanded="false" aria-haspopup="true"
                                        onclick="toggleDropdown('dropdown-menu')">
                                        <span class="absolute -inset-1.5"></span>
                                        <span class="sr-only">Open user menu</span>
                                        <img class="size-8 rounded-full"
                                            src="https://th.bing.com/th/id/R.4e9a9213eb6cacc05b42ead4c364aef8?rik=e%2frEilzC8bkv3g&pid=ImgRaw&r=0"
                                            alt="">
                                    </button>
                                </div>
                                <div id="dropdown-menu"
                                    class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700"
                                        role="menuitem">Your Profile</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700"
                                        role="menuitem">Settings</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700"
                                        role="menuitem">Sign out</a>
                                </div>
                            </div>
                        </div>

                        <script>
                            function toggleDropdown(id) {
                                const dropdown = document.getElementById(id);
                                dropdown.classList.toggle('hidden');
                            }

                            document.addEventListener('click', function(event) {
                                const dropdowns = ['notifications-dropdown', 'tasks-dropdown', 'dropdown-menu'];
                                dropdowns.forEach(id => {
                                    const dropdown = document.getElementById(id);
                                    const button = document.querySelector(`[aria-controls="${id}"]`);
                                    if (!button.contains(event.target)) {
                                        dropdown.classList.add('hidden');
                                    }
                                });
                            });

                            async function fetchNotifications() {
                                try {
                                    const response = await axios.get('{{ route('notifications.index') }}');
                                    const notifications = response.data;
                                    const notificationsDropdown = document.getElementById('notifications-dropdown');
                                    notificationsDropdown.innerHTML = notifications.map(notification =>
                                        `<a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem">${notification.message}</a>`
                                    ).join('');
                                } catch (error) {
                                    console.error('Error fetching notifications:', error);
                                }
                            }

                            document.addEventListener('DOMContentLoaded', fetchNotifications);
                        </script>
                    </div>
                </div>


            </nav>

            <!-- Page Content -->
            <main class="pt-16 h-screen p-4">
                @yield('content')
                {{-- <footer class="bg-cyan-800 text-white py-4 mt-auto" style="background:linear-gradient(90deg, #00c4cc 0%, #7d2ae8 100%);">
                    <div class="container mx-auto text-center">
                        <p class="font-medium">&copy; {{ date('Y') }} Farlu. Tous droits reservés.</p>
                    </div>
                </footer> --}}
            </main>

        </div>
    </div>



</body>


</html>
