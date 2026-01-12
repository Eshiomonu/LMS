<div class="bg-white p-6 rounded shadow">
    <h3 class="font-bold text-lg mb-4">{{ $label }}</h3>

    <div data-list-wrapper>
        <input name="{{ $name }}[]" class="input mb-2" placeholder="Item">
    </div>

    <button type="button"
        onclick="addListItem(this)"
        class="mt-2 text-sm text-blue-600">
        + Add Item
    </button>
</div>
