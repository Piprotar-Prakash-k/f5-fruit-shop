<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            background-color: #198754;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .order-details {
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
        }
        .total {
            font-size: 20px;
            font-weight: bold;
            color: #198754;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍎 Fruit Shop</h1>
            <h2>Order Confirmed!</h2>
        </div>

        <p>Dear <strong>{{ $order->customer_name }}</strong>,</p>
        <p>Thank you for your order! Here are your order details:</p>

        <div class="order-details">
            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p><strong>Product:</strong> {{ $order->product->name }}</p>
            <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
            <p class="total"><strong>Total: ₹{{ $order->total_price }}</strong></p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Payment:</strong> {{ ucfirst($order->payment_method) }}</p>
            <p><strong>Address:</strong> {{ $order->address }}</p>
        </div>

        <p>We will deliver your order soon! 🚚</p>

        <div class="footer">
            <p>Thank you for shopping with Fruit Shop! 🍎</p>
            <p>Rajkot, Gujarat</p>
        </div>
    </div>
</body>
</html>