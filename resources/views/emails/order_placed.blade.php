<p>Hi {{ $order->user->name ?? 'Customer' }},</p>

<p>Thanks for your order! Your order <strong>#{{ $order->id }}</strong> has been placed successfully.</p>

<p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
<p><strong>Payment method:</strong> {{ strtoupper($order->payment_method) }}</p>

<p>We will update you when your order status changes.</p>

<p>Regards,<br>{{ config('app.name') }}</p>
