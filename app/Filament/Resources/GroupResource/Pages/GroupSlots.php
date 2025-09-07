<?php

namespace App\Filament\Resources\GroupResource\Pages;

use App\Filament\Resources\GroupResource;
use App\Models\Costumer;
use App\Models\Group;
use App\Models\Order;
use App\Models\Slot;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;

class GroupSlots extends Page
{
    protected static string $resource = GroupResource::class;
    protected static string $view = 'filament.resources.group-resource.pages.group-slots';

    public Group $record;

    public $customers;
    public $orders;

    // create
    public $selectedCustomerId;
    public $selectedOrderId;
    public $slotNotes;

    // edit
    public $editSlotId;
    public $editCustomerId;
    public $editSlotNotes;

    public function mount($record): void
    {
        $this->record = $record->load('slots.costumer');
        $this->customers = Costumer::all();
        $this->orders = Order::all();
    }

    public function getTitle(): string
    {
        return "Slots untuk Group {$this->record->name}";
    }

    // CREATE
    public function createSlot(): void
    {
        $this->validate([
            'selectedCustomerId' => 'required|exists:costumers,id',
        ]);


        $this->record->slots()->create([
            'costumer_id' => $this->selectedCustomerId,
            'order_id' => $this->selectedOrderId
        ]);

        $this->reset(['selectedCustomerId', 'slotNotes']);
        $this->record->refresh();

        $this->dispatch('close-modal', id: 'create-slot-modal');
        $this->dispatch('notify', type: 'success', message: 'Slot berhasil ditambahkan!');
    }

    // LOAD EDIT
    public function loadEditSlot($slotId): void
    {
        $slot = $this->record->slots()->findOrFail($slotId);
        $this->editSlotId     = $slot->id;
        $this->editCustomerId = $slot->costumer_id;
        $this->editSlotNotes  = $slot->notes;
        $this->selectedOrderId = $slot->order_id;
    }

    // UPDATE
    public function updateSlot(): void
    {
        $this->validate([
            'editCustomerId' => 'required|exists:costumers,id',
        ]);

        $slot = $this->record->slots()->findOrFail($this->editSlotId);

        $slot->update([
            'costumer_id' => $this->editCustomerId,
            'order_id' => $this->selectedOrderId
        ]);

        $this->reset(['editSlotId', 'editCustomerId', 'editSlotNotes']);
        $this->record->refresh();

        $this->dispatch('close-modal', id: 'edit-slot-modal');
        Notification::make()
            ->title('Slot berhasil diUpdate')
            ->success()
            ->send();
    }


    // DELETE
    public function deleteSlot($slotId): void
    {
        $slot = $this->record->slots()->findOrFail($slotId);
        $slot->delete();

        $this->record->refresh();

        Notification::make()
            ->title('Slot berhasil Di Hapus')
            ->success()
            ->send();
    }


    
}
