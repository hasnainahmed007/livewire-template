<?php

namespace App\Livewire\Tenant;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Structured trigger → response → escalation forms.
 * No canvas; intentionally form-based per plan for SMB users.
 */
#[Title('Flows')]
#[Layout('layouts::tenant')]
class Flows extends Component
{
    public ?string $notice = null;

    /** @var array<int, array{id: int, name: string, trigger: string, response: string, escalation: string, active: bool}> */
    public array $flows = [
        ['id' => 1, 'name' => 'Appointment booking', 'trigger' => 'Message contains “book” or “appointment”', 'response' => 'Offer open time slots from the calendar', 'escalation' => 'Escalate after 2 unanswered follow-ups', 'active' => true],
        ['id' => 2, 'name' => 'Opening hours FAQ', 'trigger' => 'Message contains “hours” or “open”', 'response' => 'Reply with weekday and weekend hours', 'escalation' => 'Never escalate', 'active' => true],
    ];

    public string $name = '';

    public string $triggerType = 'contains';

    public string $triggerValue = '';

    public string $response = '';

    public string $escalation = 'Escalate when the customer asks for a human';

    public function toggleFlow(int $flowId): void
    {
        foreach ($this->flows as &$flow) {
            if ($flow['id'] === $flowId) {
                $flow['active'] = ! $flow['active'];
            }
        }
        unset($flow);

        $this->notice = 'Flow updated.';
    }

    public function saveFlow(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:80'],
            'triggerValue' => ['required', 'string', 'max:160'],
            'response' => ['required', 'string', 'max:500'],
        ]);

        $this->flows[] = [
            'id' => count($this->flows) + 1,
            'name' => $this->name,
            'trigger' => $this->triggerType.' “'.$this->triggerValue.'”',
            'response' => $this->response,
            'escalation' => $this->escalation,
            'active' => true,
        ];

        $this->reset(['name', 'triggerValue', 'response']);
        $this->notice = 'Flow saved.';
    }

    public function render()
    {
        return view('livewire.tenant.flows');
    }
}
