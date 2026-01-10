@props(['active' => false])

<a {{ $attributes->merge([
    'class' => ($active
        ? 'text-indigo-600 font-semibold'
        : 'text-gray-600 hover:text-indigo-600')
]) }}>
    {{ $slot }}
</a>
