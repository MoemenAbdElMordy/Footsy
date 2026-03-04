<p>Hi {{ $order->user->name ?? 'Customer' }},</p>

<p>Your payment for order <strong>#{{ $order->id }}</strong> was received successfully.</p>

<p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
@if(!empty($order->paid_at))
<p><strong>Paid at:</strong> {{ $order->paid_at->format('M d, Y H:i') }}</p>
@endif

<p>We will process your order shortly.</p>

<p>Regards,<br>{{ config('app.name') }}</p>
