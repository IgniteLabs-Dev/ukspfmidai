@props([
    'type' => 'button',
    'bg' => '[var(--primary)]',
    'label' => 'Button',
    'px' => '3',
    'py' => '2',
    'disabled' => false
])

<button 
    {{ $attributes->merge([
        'type' => $type,
        'class' => "text-white bg-$bg hover:brightness-90 font-medium rounded-lg text-sm w-full sm:w-auto px-$px py-$py text-center hover:cursor-pointer hover:scale-102 transition-transform duration-200" . ($disabled ? ' opacity-50 cursor-not-allowed hover:brightness-100 hover:scale-100' : ''),
        'disabled' => $disabled
    ]) }}>
    {!! $label !!}
</button>
