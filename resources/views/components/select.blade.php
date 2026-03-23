@props([
    'label' => '',
    'for' => '',
    'name' => '',
    'mb' => '0',
    'wire' => '',
    'wireType' => 'defer',
    'options' => [],
    'placeholder' => 'Pilih salah satu...',
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

    @php
        $baseClass =
            'bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5';
        $mbClass = $mb ? ' mb-' . $mb : '';
        $finalClass = trim($baseClass . $mbClass);
    @endphp

    <select {{ $attributes->merge(['class' => $finalClass]) }} id="{{ $for }}" name="{{ $name }}"
        @if ($wire) wire:model.{{ $wireType }}="{{ $wire }}" @endif
        @if ($required) required @endif>
        <option value="">{{ $placeholder }}</option>

        @foreach ($options as $value => $text)
            <option value="{{ $value }}">{{ $text }}</option>
        @endforeach
    </select>

    @php $errorKey = $wire ?: $name; @endphp
    @error($errorKey)
        <p class="text-red-500 text-xs mt-0">{{ $message }}</p>
    @enderror
</div>
