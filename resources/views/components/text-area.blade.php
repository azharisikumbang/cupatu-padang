@props(['rows' => 5, 'cols' => 5, 'value' => ''])

<textarea rows="{{ $rows }}" cols="{{ $cols }}" {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>{{ $value }}</textarea>