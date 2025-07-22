<a wire:navigate class="font-medium {{request()->fullUrl() === $link ? 'text-blue-600 dark:text-blue-500 ' : 'text-gray-500 dark:text-gray-400' }} py-3 md:py-6 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
   href="{{$link}}" aria-current="page">
    {!! $name !!}
</a>



