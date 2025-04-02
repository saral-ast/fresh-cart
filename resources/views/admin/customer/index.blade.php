<x-admin-layout>
    <div class="p-6 md:p-10 space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <span class="material-icons mr-2 text-gray-600">people</span>
                Customers Management
            </h2>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.customers.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-medium flex items-center justify-center transition-all shadow-sm">
                    <span class="material-icons mr-2 text-sm">add</span>
                    Add Customer
                </a>
            </div>
        </div>
        
        <!-- Filters Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

                <div class="relative">
                    <select id="customerStatus" class="pl-10 pr-4 py-2.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-300 transition-all appearance-none">
                        <option value="all">All Customers</option>
                        <option value="active">Active Only</option>
                        <option value="inactive">Inactive Only</option>
                    </select>
                    <span class="material-icons absolute left-3 top-2.5 text-gray-500">filter_list</span>
                </div>
            </div>

         

        </div>

        <!-- Customers Table -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm">
                            <th class="px-6 py-4 text-left font-semibold">Name</th>
                            <th class="px-6 py-4 text-left font-semibold">Email</th>
                            <th class="px-6 py-4 text-left font-semibold">Phone</th>
                            <th class="px-6 py-4 text-left font-semibold">Status</th>
                            <th class="px-6 py-4 text-left font-semibold">Created At</th>
                            <th class="px-6 py-4 text-center font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($customers as $customer)
                            <tr class="hover:bg-gray-50/50 transition-colors customer-row" data-status="{{ $customer->status }}">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $customer->name }}</div>
                                </td>
                                <td class="px-6 py-4">{{ $customer->email }}</td>
                                <td class="px-6 py-4">{{ $customer->phone ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($customer->status === 'active')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <span class="material-icons text-xs mr-1">check_circle</span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <span class="material-icons text-xs mr-1">warning</span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-500">{{ $customer->created_at->format('d M Y h:i A') }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.customers.edit', $customer->id) }}" 
                                           class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors flex items-center">
                                            <span class="material-icons text-sm mr-1">edit</span>
                                            Edit
                                        </a>
                                        <button data-modal-target="popup-modal" 
                                                data-modal-toggle="popup-modal" 
                                                type="button" 
                                                class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors flex items-center"
                                                data-customer-id="{{ $customer->id }}">
                                            <span class="material-icons text-sm mr-1">delete</span>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $customers->links() }}
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="popup-modal">
                    <span class="material-icons text-sm">close</span>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <span class="material-icons text-red-500 text-2xl">delete_forever</span>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 mt-2">Are you sure you want to delete this customer?</h3>
                    <div class="flex justify-center gap-3">
                        <form action="{{ route('admin.customers.destroy', '') }}" method="POST" id="deleteCustomerForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                <span class="material-icons text-sm mr-1">check</span>
                                Yes, delete it
                            </button>
                        </form>
                        <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
     <script>
    $(document).ready(function () {
    $('button[data-modal-toggle="popup-modal"]').click(function() {
        const customerId = $(this).data('customer-id');
        const form = $('#deleteCustomerForm');
        const action = form.attr('action');
        form.attr('action', `${action}/${customerId}`);
    });
    $('#customerStatus').on('change', function() {
        const filterValue = $(this).val();
        const rows = $('.customer-row');
        rows.each(function() {
            const status = $(this).data('status');
            if (filterValue === 'all' || status === filterValue) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
        
    @endpush  
</x-admin-layout>
