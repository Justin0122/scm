<div>
    <ul class="">
    <form wire:submit.prevent="createAndAssignSize">
        <li>
            <x-input
                type="text"
                class="py-2 px-3 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                placeholder="Size"
                wire:model="form.size.key"
            />
        </li>
    </form>
    </ul>
</div>
