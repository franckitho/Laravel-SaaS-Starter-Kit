<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
   @livewire('list-user-role', ['entry' => $getRecord()->id])
</x-dynamic-component>
