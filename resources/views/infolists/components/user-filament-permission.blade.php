<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
   @livewire('list-user-filament-permission', ['entry' => $getRecord()->id])
</x-dynamic-component>
