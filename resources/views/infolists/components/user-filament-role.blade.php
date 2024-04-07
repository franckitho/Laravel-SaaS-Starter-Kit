<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
   @livewire('list-user-filament-role', ['entry' => $getRecord()->id])
</x-dynamic-component>
