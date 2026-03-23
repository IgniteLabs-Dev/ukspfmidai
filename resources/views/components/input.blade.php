@props([
    'label' => '',
    'for' => '',
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'wire' => '',
    'wireType' => 'defer',
    'required' => false,
])

<div>
    @if ($label)
        <label for="{{ $for }}" class="block mb-2 text-sm font-medium text-gray-900">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input type="{{ $type }}" id="{{ $for }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
        @if ($wire) wire:model.{{ $wireType }}="{{ $wire }}" @endif
        @if ($required) required @endif
        {{ $attributes->merge([
            'class' =>
                'bg-gray-50 border border-gray-200 mb-0 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
        ]) }} />

    @error($wire)
        <p class="text-red-500 text-xs mt-0">{{ $message }}</p>
    @enderror
</div>
