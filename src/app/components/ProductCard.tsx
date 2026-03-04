import React from 'react';
import { Product } from '../types';
import { Card, CardContent } from './ui/card';
import { Badge } from './ui/badge';
import { ShoppingCart } from 'lucide-react';

interface ProductCardProps {
  product: Product;
  onClick: () => void;
}

export const ProductCard: React.FC<ProductCardProps> = ({ product, onClick }) => {
  return (
    <Card className="group cursor-pointer overflow-hidden transition-all hover:shadow-lg" onClick={onClick}>
      <div className="relative aspect-square overflow-hidden bg-gray-100">
        <img
          src={product.images[0]}
          alt={product.name}
          className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
        />
        {product.stock < 10 && product.stock > 0 && (
          <Badge className="absolute right-2 top-2 bg-orange-500">Low Stock</Badge>
        )}
        {product.stock === 0 && (
          <Badge className="absolute right-2 top-2 bg-red-500">Out of Stock</Badge>
        )}
      </div>
      <CardContent className="p-4">
        <h3 className="mb-1 line-clamp-1 font-medium">{product.name}</h3>
        <p className="mb-2 text-sm text-gray-500">{product.brand}</p>
        <div className="flex items-center justify-between">
          <span className="text-lg font-semibold">${product.price}</span>
          <div className="flex h-8 w-8 items-center justify-center rounded-full bg-green-500 text-white opacity-0 transition-opacity group-hover:opacity-100">
            <ShoppingCart className="h-4 w-4" />
          </div>
        </div>
      </CardContent>
    </Card>
  );
};
