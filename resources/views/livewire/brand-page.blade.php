<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 sm:gap-6">
            @foreach($brands as $brand)
                <div class="bg-white rounded-lg shadow-md dark:bg-gray-800" wire:key="{{$brand->id}}">
                    <a wire:navigate href="{{route('brands.show', $brand)}}" class="">
                        <img src="{{url('storage',$brand->image)}}" alt="{{$brand->name}}"
                             class="object-fill w-full h-64 rounded-t-lg">
                    </a>
                    <div class="p-5 text-center">
                        <a wire:navigate href="{{route('brands.show', $brand)}}"
                           class="text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-300">
                            {{$brand->name}}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
