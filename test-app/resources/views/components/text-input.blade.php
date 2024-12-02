@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-orange-500 bg-gray-800 text-white focus:border-orange-400 focus:ring-orange-400 rounded-md shadow-sm']) }}>
