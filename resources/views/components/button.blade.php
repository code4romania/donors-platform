<button {{ $attributes->merge(['type' => 'submit', 'class' => 'relative px-6 py-2 font-semibold leading-snug tracking-wide text-center rounded shadow-md sm:w-auto focus:outline-none text-white bg-blue-500 focus:bg-blue-600 inline-block hover:shadow-lg focus:shadow-md']) }}>
    {{ $slot }}
</button>
