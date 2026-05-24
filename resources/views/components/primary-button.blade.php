<button {{ $attributes->merge(['type' => 'submit', 'class' => 'primary-btn inline-flex items-center justify-center']) }}>
    {{ $slot }}
</button>
