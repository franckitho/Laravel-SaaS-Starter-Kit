<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
   @livewire('list-user-permission', ['entry' => $getRecord()->id])
</x-dynamic-component>
