<div {{ $attributes->merge(['class' => 'px-2 py-2 text-center font-bold text-sm text-gray-600 dark:text-gray-400 rounded bg-gray-800']) }}>
    {{ $slot->isEmpty() ? "Saved" : $slot }}
</div>
