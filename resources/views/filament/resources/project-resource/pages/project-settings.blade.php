<x-filament-panels::page>
    @livewire(\App\Filament\Resources\ProjectResource\Widgets\UpdateProject::class, ['project' => $record])

    @livewire(\App\Filament\Resources\ProjectResource\Widgets\AddTeamMember::class, ['project' => $record])

    @livewire(\App\Filament\Resources\ProjectResource\Widgets\ProjectInvitations::class, ['project' => $record])

    @livewire(\App\Filament\Resources\ProjectResource\Widgets\ListTeamMembers::class, ['project' => $record])
</x-filament-panels::page>
