<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 2px solid #eee; margin-bottom: 20px; }
        .logo { max-width: 200px; height: auto; }
        .order-info { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .order-details, .shipping-info { flex: 1; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #f8f9fa; }
        .total-section { margin-top: 20px; text-align: right; }
        .status-badge { display: inline-block; padding: 6px 12px; border-radius: 4px; font-size: 14px; font-weight: 600; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-completed { background: #d4edda; color: #155724; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; text-align: center; color: #6c757d; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/freshcart-logo.svg') }}" alt="Fresh Cart" class="logo">
            @if($isAdmin)
                <h1>New Order Notification #{{ $order->id }}</h1>
            @else
                <h1>Order Confirmation #{{ $order->id }}</h1>
            @endif
        </div>

        <div class="order-info">
            <div class="order-details">
                <h3>Order Information</h3>
                <p><strong>Order Number:</strong> #{{ $order->id }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                <p><strong>Payment Status:</strong> 
                    <span class="status-badge status-{{ strtolower($order->payment->status) }}">{{ ucfirst($order->payment->status) }}</span>
                </p>
                <p><strong>Order Status:</strong> 
                    <span class="status-badge status-{{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
                </p>
            </div>

           
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->ordersitem as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <h3>Total: ${{ number_format($order->total, 2) }}</h3>
        </div>

        @if($isAdmin)
            <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 4px;">
                <h3>Admin Notes</h3>
                <p>Customer ID: {{ $order->user->id }}</p>
                <p>Customer Email: {{ $order->user->email }}</p>
                <p>Customer Phone: {{ $order->user->phone }}</p>
            </div>
        @endif

        <div class="footer">
            <p>Thank you for shopping with Fresh Cart!</p>
            <p>If you have any questions about your order, please contact our customer service team.</p>
            <p>© {{ date('Y') }} Fresh Cart. All rights reserved.</p>
        </div>
    </div>
</body>
</html>