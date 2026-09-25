<?php

namespace App\Livewire\Tenant;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Agent list with pause/resume as the front-and-center control.
 *
 * Mock data only; toggle maps directly to a future paused flag.
 */
#[Title('Agents')]
#[Layout('layouts::tenant')]
class Agents extends Component
{
    public ?string $notice = null;

    /** @var array<int, array{id: int, name: string, paused: bool, channels: array<int, string>, flow: string, tone: string, handled_today: int}> */
    public array $agents = [
        ['id' => 1, 'name' => 'Booking assistant', 'paused' => false, 'channels' => ['SMS', 'WhatsApp'], 'flow' => 'Appointment booking', 'tone' => 'Friendly and short', 'handled_today' => 86],
        ['id' => 2, 'name' => 'After-hours helper', 'paused' => false, 'channels' => ['Messenger'], 'flow' => 'FAQ and hours', 'tone' => 'Calm and direct', 'handled_today' => 28],
        ['id' => 3, 'name' => 'Payments follow-up', 'paused' => true, 'channels' => ['WhatsApp'], 'flow' => 'Payment reminders', 'tone' => 'Polite and formal', 'handled_today' => 0],
    ];

    public function togglePause(int $agentId): void
    {
        foreach ($this->agents as &$agent) {
            if ($agent['id'] === $agentId) {
                $agent['paused'] = ! $agent['paused'];
                $this->notice = $agent['paused']
                    ? 'Agent paused.'
                    : 'Agent resumed.';
            }
        }
        unset($agent);
    }

    public function render()
    {
        return view('livewire.tenant.agents');
    }
}
