@props([
    'label' => '',
    'for' => '',
    'name' => '',
    'wire' => '',
    'placeholder' => '',
    'required' => false,
    'rows' => 4,
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

    <textarea
        {{ $attributes->merge([
            'class' =>
                'bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 resize-none',
        ]) }}
        @if ($wire) wire:model.defer="{{ $wire }}" @endif id="{{ $for }}"
        name="{{ $name }}" placeholder="{{ $placeholder }}" rows="{{ $rows }}"
        @if ($required) required @endif></textarea>

    @error($wire)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
