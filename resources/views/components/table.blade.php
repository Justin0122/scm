<!-- ProductTable.blade.php -->

<div class="mx-4">
    <div class="mb-4">

    </div>

    <!-- Product table -->
    <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800 dark:text-gray-200">
        <thead>
        <tr>
            <!-- get fillables from model -->
            @foreach ($results->first()->getFillable() as $field)
                <th class="px-4 py-2 text-left">{{ ucfirst($field) }}</th>
            @endforeach
            <th class="px-4 py-2 text-left">Created At</th>
            <th class="px-4 py-2 text-left">Updated At</th>
            <th class="px-4 py-2 text-left">Deleted At</th>
            <th class="px-4 py-2 text-left">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($results as $result)
            <tr class="{{ $loop->odd ? 'bg-gray-50 dark:bg-gray-900' : '' }}">
                @foreach ($result->getFillable() as $field)
                    <td class="py-2 px-4">
                        {{ $result->$field }}
                    </td>
                @endforeach
                <td class="py-2 px-4">
                    {{ $result->created_at }}
                </td>
                <td class="py-2 px-4">
                    {{ $result->updated_at }}
                </td>
                <td class="py-2 px-4">
                    {{ $result->deleted_at }}
                </td>
                <td class="py-2 px-4">
                    <div class="flex">
                        <a href="{{'?type=' . $type . '&id=' . $result->id}}"
                           class="px-2 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-300 ease-in-out">
                            View
                        </a>
                        <button wire:click="delete({{ $result->id }})" class="px-2 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-300 ease-in-out">
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach

        @if ($results->count() == 0)
            <tr>
                <td colspan="4" class="py-2 text-center">No products found.</td>
            </tr>
        @endif
        </tbody>
    </table>

    <!-- Pagination links -->
    <div class="mt-4">
        {{ $results->links() }}
    </div>
</div>
