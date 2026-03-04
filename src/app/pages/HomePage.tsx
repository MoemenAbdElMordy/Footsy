import React from 'react';
import { useNavigate } from 'react-router-dom';
import { ArrowRight, ShoppingBag, TrendingUp, Shield } from 'lucide-react';
import { Button } from '../components/ui/button';
import { ProductCard } from '../components/ProductCard';
import { mockProducts } from '../data/mockData';
import { ImageWithFallback } from '../components/figma/ImageWithFallback';

export const HomePage: React.FC = () => {
  const navigate = useNavigate();
  const featuredProducts = mockProducts.filter((p) => p.featured);

  return (
    <div>
      {/* Hero Section */}
      <section className="relative h-[600px] overflow-hidden bg-gray-900">
        <div className="absolute inset-0">
          <ImageWithFallback
            src="https://images.unsplash.com/photo-1695459468644-717c8ae17eed?w=1600&q=80"
            alt="Hero"
            className="h-full w-full object-cover opacity-60"
          />
        </div>
        <div className="container relative mx-auto flex h-full items-center px-4">
          <div className="max-w-2xl text-white">
            <h1 className="mb-4 text-5xl font-bold md:text-6xl">Step Into Style</h1>
            <p className="mb-8 text-lg md:text-xl">
              Discover the latest footwear trends for men, women, and kids. Quality meets comfort in every step.
            </p>
            <div className="flex gap-4">
              <Button
                size="lg"
                className="bg-green-500 hover:bg-green-600"
                onClick={() => navigate('/shop')}
              >
                Shop Now
                <ArrowRight className="ml-2 h-5 w-5" />
              </Button>
              <Button size="lg" variant="outline" className="border-white text-white hover:bg-white hover:text-gray-900">
                View Collections
              </Button>
            </div>
          </div>
        </div>
      </section>

      {/* Categories Section */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="mb-12 text-center">
            <h2 className="mb-4 text-3xl font-bold">Shop by Category</h2>
            <p className="text-gray-600">Find the perfect footwear for everyone</p>
          </div>
          <div className="grid gap-6 md:grid-cols-3">
            {[
              {
                title: "Men's Collection",
                image: 'https://images.unsplash.com/photo-1579528542333-4148f1769c35?w=800&q=80',
                path: '/men',
              },
              {
                title: "Women's Collection",
                image: 'https://images.unsplash.com/photo-1554238113-6d3dbed5cf55?w=800&q=80',
                path: '/women',
              },
              {
                title: "Kids' Collection",
                image: 'https://images.unsplash.com/photo-1583979365152-173a8f14181b?w=800&q=80',
                path: '/kids',
              },
            ].map((category) => (
              <div
                key={category.title}
                className="group relative h-80 cursor-pointer overflow-hidden rounded-lg"
                onClick={() => navigate(category.path)}
              >
                <ImageWithFallback
                  src={category.image}
                  alt={category.title}
                  className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent" />
                <div className="absolute bottom-0 left-0 right-0 p-6 text-white">
                  <h3 className="mb-2 text-2xl font-bold">{category.title}</h3>
                  <span className="inline-flex items-center text-green-400">
                    Explore Now
                    <ArrowRight className="ml-2 h-4 w-4" />
                  </span>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Featured Products */}
      <section className="bg-gray-50 py-16">
        <div className="container mx-auto px-4">
          <div className="mb-12 text-center">
            <h2 className="mb-4 text-3xl font-bold">Featured Products</h2>
            <p className="text-gray-600">Our most popular items this season</p>
          </div>
          <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            {featuredProducts.map((product) => (
              <ProductCard
                key={product.id}
                product={product}
                onClick={() => navigate(`/product/${product.id}`)}
              />
            ))}
          </div>
          <div className="mt-12 text-center">
            <Button
              size="lg"
              variant="outline"
              onClick={() => navigate('/shop')}
            >
              View All Products
              <ArrowRight className="ml-2 h-4 w-4" />
            </Button>
          </div>
        </div>
      </section>

      {/* Features */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="grid gap-8 md:grid-cols-3">
            {[
              {
                icon: <ShoppingBag className="h-10 w-10 text-green-500" />,
                title: 'Free Shipping',
                description: 'Free shipping on orders over $50',
              },
              {
                icon: <TrendingUp className="h-10 w-10 text-green-500" />,
                title: 'Latest Trends',
                description: 'Stay ahead with newest styles',
              },
              {
                icon: <Shield className="h-10 w-10 text-green-500" />,
                title: 'Secure Payment',
                description: 'Your payment information is safe',
              },
            ].map((feature) => (
              <div key={feature.title} className="text-center">
                <div className="mb-4 flex justify-center">{feature.icon}</div>
                <h3 className="mb-2 text-xl font-semibold">{feature.title}</h3>
                <p className="text-gray-600">{feature.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>
    </div>
  );
};
