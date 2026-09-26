<?php

namespace App\Livewire\Tenant;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Tenant subscription and usage. Kept structurally separate
 * from Meta message charges. Mock data only.
 */
#[Title('Billing')]
#[Layout('layouts::tenant')]
class Billing extends Component
{
    /** @var array<int, array{id: string, date: string, amount: string, status: string}> */
    public array $invoices = [
        ['id' => 'INV-2041', 'date' => 'Sep 1, 2026', 'amount' => '$49.00', 'status' => 'Paid'],
        ['id' => 'INV-1987', 'date' => 'Aug 1, 2026', 'amount' => '$49.00', 'status' => 'Paid'],
        ['id' => 'INV-1933', 'date' => 'Jul 1, 2026', 'amount' => '$49.00', 'status' => 'Paid'],
    ];

    public function render()
    {
        return view('pages.tenant.billing');
    }
}
