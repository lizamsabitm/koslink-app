<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 transition ease-in-out duration-150']) }} 
style="background-color: #203FE5; color: white;">
    {{ $slot }}
</button>
