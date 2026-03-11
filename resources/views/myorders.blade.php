<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden border border-gray-200">
                
                <div class="p-6 border-b border-gray-100">
                    <a class="btn text-white btn-sm" href="{{route('index')}}" style="background-color:#112A53 ; margin-bottom:10px">Back to shop</a>
                    <h2 class="text-lg font-bold text-gray-800">My Order History</h2>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase">Order ID</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase">Product Details</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase text-center">Qty</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase">Total</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($myorder as $order)
                            @foreach($order->items as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium  text-center text-gray-900">
                                    @if($loop->first) #{{ $order->id }} @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="h-12 w-12 flex-shrink-0 bg-gray-100 rounded border border-gray-200 overflow-hidden">
                                            @if ($item->product->image)
                                                <img src="{{ asset('uploads/' . ($item->product->image)) }}" width="50px" height="50px" class="object-cover">   
                                            @else
                                                <img src="{{asset('noimage/noimage.png')}}" alt="" width="60px" height="60px">
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $item->product->product_name}}</div>
                                            <div class="text-xs text-gray-500">Price: ${{ number_format($item->price, 2) }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600 text-center">
                                    {{ $item->quantity }}
                                </td>

                                <td class="px-6 py-4 text-sm font-bold text-gray-900 text-center">
                                    @if($loop->first) ${{ number_format($order->total_amount, 2) }} @endif
                                </td>

                                <td class="px-6 py-4 text-sm text-center">
                                    @if($loop->first)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                    @if($loop->first) {{ $order->created_at->format('M d, Y') }} @endif
                                </td>
                            </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>