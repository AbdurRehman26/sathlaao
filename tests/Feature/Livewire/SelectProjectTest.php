<?php

use App\Livewire\SelectProject;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(SelectProject::class)
        ->assertStatus(200);
});
