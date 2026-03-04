import React from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { CheckCircle, Package, Home } from 'lucide-react';
import { Button } from '../components/ui/button';
import { Card, CardContent } from '../components/ui/card';

export const OrderConfirmationPage: React.FC = () => {
  const { orderId } = useParams<{ orderId: string }>();
  const navigate = useNavigate();

  return (
    <div className="container mx-auto px-4 py-16">
      <Card className="mx-auto max-w-2xl">
        <CardContent className="p-8 text-center">
          <CheckCircle className="mx-auto mb-4 h-20 w-20 text-green-500" />
          <h1 className="mb-2 text-3xl font-bold">Order Confirmed!</h1>
          <p className="mb-6 text-gray-600">
            Thank you for your purchase. Your order has been received and is being processed.
          </p>

          <div className="mb-8 rounded-lg bg-gray-50 p-6">
            <p className="mb-2 text-sm text-gray-600">Order Number</p>
            <p className="text-2xl font-bold">#{orderId}</p>
          </div>

          <div className="mb-8 space-y-4 text-left">
            <div className="flex items-start gap-3">
              <Package className="mt-1 h-5 w-5 text-green-500" />
              <div>
                <h3 className="font-semibold">What's Next?</h3>
                <p className="text-sm text-gray-600">
                  We'll send you a confirmation email with your order details and tracking information once your order
                  ships.
                </p>
              </div>
            </div>
          </div>

          <div className="flex gap-4">
            <Button onClick={() => navigate('/orders')} className="flex-1 bg-green-500 hover:bg-green-600">
              View My Orders
            </Button>
            <Button onClick={() => navigate('/')} variant="outline" className="flex-1">
              <Home className="mr-2 h-4 w-4" />
              Back to Home
            </Button>
          </div>
        </CardContent>
      </Card>
    </div>
  );
};
