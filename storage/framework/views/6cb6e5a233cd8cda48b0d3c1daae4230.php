<p>Hi <?php echo e($order->user->name ?? 'Customer'); ?>,</p>

<p>Your payment for order <strong>#<?php echo e($order->id); ?></strong> was received successfully.</p>

<p><strong>Total:</strong> $<?php echo e(number_format($order->total, 2)); ?></p>
<?php if(!empty($order->paid_at)): ?>
<p><strong>Paid at:</strong> <?php echo e($order->paid_at->format('M d, Y H:i')); ?></p>
<?php endif; ?>

<p>We will process your order shortly.</p>

<p>Regards,<br><?php echo e(config('app.name')); ?></p>
<?php /**PATH D:\self practise\footsy\Footwear E-Commerce Website PRD\resources\views/emails/payment_succeeded.blade.php ENDPATH**/ ?>