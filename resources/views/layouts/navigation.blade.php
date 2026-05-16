<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="font-bold text-xl text-indigo-600">
                        🛒 E-Commerce
                    </a>
                </div>
            </div>

            <!-- Lado derecho -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">

                @guest
                    <!-- Usuario no autenticado -->
                    <a href="{{ route('quienes-somos') }}"
                       class="text-sm text-gray-600 hover:text-gray-900 mr-4">Quiénes somos</a>
                    <a href="{{ route('mision-vision') }}"
                       class="text-sm text-gray-600 hover:text-gray-900 mr-4">Misión y Visión</a>
                    <a href="{{ route('contacto') }}"
                       class="text-sm text-gray-600 hover:text-gray-900 mr-4">Contacto</a>
                    <a href="{{ route('login') }}"
                       class="text-sm text-gray-600 hover:text-gray-900 mr-4">Iniciar sesión</a>
                @endguest

                @auth
                    <!-- Usuario autenticado -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent
                                text-sm leading-4 font-medium rounded-md text-gray-500 bg-white
                                hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->nombre }} ({{ ucfirst(Auth::user()->rol) }})</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10
                                            10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0
                                            01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Cerrar sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Menú hamburguesa (móvil) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2
                    rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100
                    focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú móvil -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="url('/')" :active="request()->is('/')">
                Inicio
            </x-responsive-nav-link>
        </div>

        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->nombre }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->correo }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Cerrar sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>s
