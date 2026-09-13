<button {{ $attributes->merge(['type' => 'button', 'class' => 'button button--outline']) }}>
    {{ $slot }}
</button>
