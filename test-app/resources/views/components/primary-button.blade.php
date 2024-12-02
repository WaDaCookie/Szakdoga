<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 hover:border-orange-500 hover:bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-orange-500 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
