import React, { useState, useMemo } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import { ProductCard } from '../components/ProductCard';
import { mockProducts, brands, colors } from '../data/mockData';
import { Filters } from '../types';
import { Input } from '../components/ui/input';
import { Label } from '../components/ui/label';
import { Checkbox } from '../components/ui/checkbox';
import { Slider } from '../components/ui/slider';
import { Button } from '../components/ui/button';
import { Sheet, SheetContent, SheetTrigger } from '../components/ui/sheet';
import { Filter, X } from 'lucide-react';

export const ShopPage: React.FC = () => {
  const navigate = useNavigate();
  const location = useLocation();
  const [searchQuery, setSearchQuery] = useState('');
  const [filters, setFilters] = useState<Filters>({
    minPrice: 0,
    maxPrice: 300,
    sizes: [],
    colors: [],
    brands: [],
  });

  // Get category from URL path
  const category = location.pathname.includes('/men')
    ? 'men'
    : location.pathname.includes('/women')
    ? 'women'
    : location.pathname.includes('/kids')
    ? 'kids'
    : undefined;

  const filteredProducts = useMemo(() => {
    return mockProducts.filter((product) => {
      // Category filter
      if (category && product.category !== category) return false;

      // Search filter
      if (searchQuery && !product.name.toLowerCase().includes(searchQuery.toLowerCase())) {
        return false;
      }

      // Price filter
      if (product.price < (filters.minPrice || 0) || product.price > (filters.maxPrice || 300)) {
        return false;
      }

      // Brand filter
      if (filters.brands && filters.brands.length > 0 && !filters.brands.includes(product.brand)) {
        return false;
      }

      // Color filter
      if (filters.colors && filters.colors.length > 0) {
        if (!product.colors.some((color) => filters.colors?.includes(color))) {
          return false;
        }
      }

      // Size filter
      if (filters.sizes && filters.sizes.length > 0) {
        if (!product.sizes.some((size) => filters.sizes?.includes(size))) {
          return false;
        }
      }

      return true;
    });
  }, [searchQuery, filters, category]);

  const handleBrandToggle = (brand: string) => {
    setFilters((prev) => ({
      ...prev,
      brands: prev.brands?.includes(brand)
        ? prev.brands.filter((b) => b !== brand)
        : [...(prev.brands || []), brand],
    }));
  };

  const handleColorToggle = (color: string) => {
    setFilters((prev) => ({
      ...prev,
      colors: prev.colors?.includes(color)
        ? prev.colors.filter((c) => c !== color)
        : [...(prev.colors || []), color],
    }));
  };

  const handlePriceChange = (values: number[]) => {
    setFilters((prev) => ({
      ...prev,
      minPrice: values[0],
      maxPrice: values[1],
    }));
  };

  const clearFilters = () => {
    setFilters({
      minPrice: 0,
      maxPrice: 300,
      sizes: [],
      colors: [],
      brands: [],
    });
    setSearchQuery('');
  };

  const FilterContent = () => (
    <div className="space-y-6">
      {/* Search */}
      <div>
        <Label>Search</Label>
        <Input
          placeholder="Search products..."
          value={searchQuery}
          onChange={(e) => setSearchQuery(e.target.value)}
          className="mt-2"
        />
      </div>

      {/* Price Range */}
      <div>
        <Label>Price Range</Label>
        <div className="mt-4">
          <Slider
            min={0}
            max={300}
            step={10}
            value={[filters.minPrice || 0, filters.maxPrice || 300]}
            onValueChange={handlePriceChange}
          />
          <div className="mt-2 flex justify-between text-sm text-gray-600">
            <span>${filters.minPrice}</span>
            <span>${filters.maxPrice}</span>
          </div>
        </div>
      </div>

      {/* Brands */}
      <div>
        <Label>Brands</Label>
        <div className="mt-2 space-y-2">
          {brands.map((brand) => (
            <div key={brand} className="flex items-center">
              <Checkbox
                id={`brand-${brand}`}
                checked={filters.brands?.includes(brand)}
                onCheckedChange={() => handleBrandToggle(brand)}
              />
              <label htmlFor={`brand-${brand}`} className="ml-2 cursor-pointer text-sm">
                {brand}
              </label>
            </div>
          ))}
        </div>
      </div>

      {/* Colors */}
      <div>
        <Label>Colors</Label>
        <div className="mt-2 space-y-2">
          {colors.map((color) => (
            <div key={color} className="flex items-center">
              <Checkbox
                id={`color-${color}`}
                checked={filters.colors?.includes(color)}
                onCheckedChange={() => handleColorToggle(color)}
              />
              <label htmlFor={`color-${color}`} className="ml-2 cursor-pointer text-sm">
                {color}
              </label>
            </div>
          ))}
        </div>
      </div>

      <Button onClick={clearFilters} variant="outline" className="w-full">
        <X className="mr-2 h-4 w-4" />
        Clear Filters
      </Button>
    </div>
  );

  const pageTitle = category
    ? `${category.charAt(0).toUpperCase() + category.slice(1)}'s Collection`
    : 'All Products';

  return (
    <div className="container mx-auto px-4 py-8">
      <div className="mb-8 flex items-center justify-between">
        <div>
          <h1 className="mb-2 text-3xl font-bold">{pageTitle}</h1>
          <p className="text-gray-600">{filteredProducts.length} products found</p>
        </div>
        {/* Mobile Filter Button */}
        <Sheet>
          <SheetTrigger asChild>
            <Button variant="outline" className="lg:hidden">
              <Filter className="mr-2 h-4 w-4" />
              Filters
            </Button>
          </SheetTrigger>
          <SheetContent>
            <h2 className="mb-6 text-lg font-semibold">Filters</h2>
            <FilterContent />
          </SheetContent>
        </Sheet>
      </div>

      <div className="flex gap-8">
        {/* Desktop Filters */}
        <aside className="hidden w-64 flex-shrink-0 lg:block">
          <div className="sticky top-24">
            <h2 className="mb-6 text-lg font-semibold">Filters</h2>
            <FilterContent />
          </div>
        </aside>

        {/* Products Grid */}
        <div className="flex-1">
          {filteredProducts.length > 0 ? (
            <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
              {filteredProducts.map((product) => (
                <ProductCard
                  key={product.id}
                  product={product}
                  onClick={() => navigate(`/product/${product.id}`)}
                />
              ))}
            </div>
          ) : (
            <div className="py-16 text-center">
              <p className="text-lg text-gray-500">No products found matching your criteria.</p>
              <Button onClick={clearFilters} className="mt-4">
                Clear Filters
              </Button>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};
