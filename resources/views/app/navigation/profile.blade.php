<!-- Profile dropdown -->
<div class="relative ml-3" x-data="{ open: false }" @click.away="open = false">
    <div>
        <button @click="open = !open" class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:shadow-outline" aria-label="User menu" aria-haspopup="true">
            <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
        </button>
    </div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 w-48 mt-2 origin-top-right rounded-md shadow-lg"
        style="display:none"
    >
        <div class="py-1 bg-white rounded-md shadow-xs" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100" role="menuitem">Your Profile</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100" role="menuitem">Settings</a>

            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100">{{ __('Logout') }}</button>
            </form>
        </div>
    </div>
</div>
