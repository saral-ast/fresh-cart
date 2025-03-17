<x-admin-layout> 
    <section class="p-6 md:p-12 antialiased">
        <div class="mx-auto max-w-screen-xl px-4">
            <h2 class="text-2xl font-bold text-gray-900">Customers</h2>
            
            {{-- Title & Add Button --}}
            <div class="flex justify-between items-center mb-6">
               
                <p class="text-gray-500">Total Customers: {{ $customers->count() }}</p>
                <a href="{{ route('admin.customers.create') }}" 
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-md transition-all">
                    + Add New Customer
                </a>
            </div>

         

            {{-- Customers Table --}}
            <div class="overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-md">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 border-b">Name</th>
                            <th class="px-6 py-3 border-b">Email</th>
                            <th class="px-6 py-3 border-b">Phone</th>
                            <th class="px-6 py-3 border-b">Status</th>
                            <th class="px-6 py-3 border-b">Date</th>
                            <th class="px-6 py-3 border-b text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition py-10">
                                <td class="px-6 py-6 font-medium">{{ $customer->name }}</td>
                                <td class="px-6 py-6">{{ $customer->email }}</td>
                                <td class="px-6 py-6">{{ $customer->phone ?? '-' }}</td>
                                <td class="px-6 py-6">
                                    <span class="px-3 py-2 text-xs font-semibold rounded-lg
                                        {{ $customer->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ ucfirst($customer->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $customer->created_at->format('d M, Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.customers.edit', $customer->id) }}" 
                                        class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                    <span class="mx-2 text-gray-400">|</span>
                                   <button type="button" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="text-red-600 hover:text-red-800 font-medium" data-customer-id="{{ $customer->id }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            {{-- <div class="mt-6">
                {{ $customers->links() }}
            </div> --}}
        </div>
    </section>
    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500">Are you sure you want to delete this Customer?</h3>
                      <form action="{{ route('admin.customers.destroy', '') }}" method="POST" class="inline-block ml-3" id="deleteCustomerForm">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                              Yes, I'm sure
                          </button>
                      </form>
                    {{-- </form> --}}
                    <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                        No, cancel
                    </button>
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
});
</script>
        
    @endpush  
</x-admin-layout>
