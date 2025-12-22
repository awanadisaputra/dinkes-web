<nav
    class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50"
>
    <div class="flex flex-wrap justify-between items-center">
        <div class="flex justify-start items-center">
            <!-- Toggle Sidebar Button -->
            <button
                data-drawer-target="drawer-navigation"
                data-drawer-toggle="drawer-navigation"
                aria-controls="drawer-navigation"
                class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
            >
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
                <span class="sr-only">Toggle sidebar</span>
            </button>

            <!-- Logo -->
            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center justify-between mr-4"
            >
                <img
                    src="https://flowbite.s3.amazonaws.com/logo.svg"
                    class="mr-3 h-8"
                    alt="Logo"
                />
                <span
                    class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"
                >
                    {{ config('app.name') }}
                </span>
            </a>
        </div>

        <div class="flex items-center lg:order-2">
            <!-- User Menu -->
            <button
                type="button"
                class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 overflow-hidden"
                id="user-menu-button"
                data-dropdown-toggle="dropdown"
            >
                <span class="sr-only">Open user menu</span>
                <img
                    class="w-8 h-8 object-cover"
                    src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                    alt="user photo"
                />
            </button>

            <!-- User Dropdown - Minimalist Modern Design -->
            <div
                class="hidden z-50 my-4 w-64 text-base list-none bg-white dark:bg-gray-950 shadow-2xl shadow-black/5 border border-gray-100 dark:border-gray-800 rounded-bl-2xl overflow-hidden backdrop-blur-xl"
                id="dropdown"
            >
                <!-- User info section -->
                <div class="p-5 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex items-center gap-3 mb-3">
                        <img
                            class="w-8 h-8 object-cover w-12 h-12 rounded-full bg-gradient-to-br from-gray-900 to-gray-700 dark:from-gray-100 dark:to-gray-300 flex items-center justify-center text-white dark:text-gray-900 font-semibold text-lg tracking-tight shadow-lg"
                            src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                            alt="user photo"
                        />
                        <div class="flex-1 min-w-0">
                            <p
                                class="text-sm font-semibold text-gray-900 dark:text-white tracking-tight truncate"
                            >
                                {{ auth()->user()->name }}
                            </p>
                            <p
                                class="text-xs text-gray-500 dark:text-gray-400 truncate"
                            >
                                {{ auth()->user()->username }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Menu items -->
                <div class="py-2">
                    <a
                        href="{{ route('admin.profile.edit') }}"
                        class="group flex items-center gap-3 px-5 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900 transition-all duration-200"
                    >
                        <svg
                            class="w-4 h-4 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-colors"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                            />
                        </svg>
                        <span
                            class="font-medium group-hover:text-gray-900 dark:group-hover:text-white transition-colors"
                        >
                            My Profile
                        </span>
                    </a>

                    <a
                        href="{{ route('admin.account.edit') }}"
                        class="group flex items-center gap-3 px-5 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900 transition-all duration-200"
                    >
                        <svg
                            class="w-4 h-4 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-colors"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>
                        <span
                            class="font-medium group-hover:text-gray-900 dark:group-hover:text-white transition-colors"
                        >
                            Account Settings
                        </span>
                    </a>
                </div>

                <!-- Logout -->
                <div class="border-t border-gray-100 dark:border-gray-800 py-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="group flex items-center gap-3 w-full px-5 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-950/20 transition-all duration-200"
                        >
                            <svg
                                class="w-4 h-4 text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                />
                            </svg>
                            <span
                                class="font-medium group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors"
                            >
                                Sign Out
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
