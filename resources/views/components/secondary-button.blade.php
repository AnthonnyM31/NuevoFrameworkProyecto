<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-secondary shadow-sm']) }}>
    {{ $slot }}
</button>