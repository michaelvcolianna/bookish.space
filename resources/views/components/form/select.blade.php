<select {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 w-full'])}}>
    <option value="null" disabled>—</option>
    {{ $slot }}
</select>
