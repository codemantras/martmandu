<a wire:navigate class="font-medium {{request()->url() === $link ? 'text-blue-600 dark:text-blue-500 hover:text-blue-500 dark:hover:text-blue-600 ' : 'text-gray-500 dark:text-gray-400 hover:text-gray-400 dark:hover:text-gray-500 ' }} py-3  md:py-6 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
   href="{{$link}}" aria-current="page">
    {{$name}}
</a>
