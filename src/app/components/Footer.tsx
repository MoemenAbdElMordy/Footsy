import React from 'react';
import { Link } from 'react-router-dom';
import { Facebook, Instagram, Twitter, Mail, Phone, MapPin } from 'lucide-react';

export const Footer: React.FC = () => {
  return (
    <footer className="border-t bg-gray-900 text-gray-300">
      <div className="container mx-auto px-4 py-12">
        <div className="grid gap-8 md:grid-cols-4">
          {/* About */}
          <div>
            <h3 className="mb-4 text-lg font-semibold text-white">Footsy</h3>
            <p className="text-sm">
              Your premier destination for quality footwear. We offer the latest styles for men, women, and kids.
            </p>
          </div>

          {/* Quick Links */}
          <div>
            <h3 className="mb-4 text-lg font-semibold text-white">Quick Links</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link to="/shop" className="hover:text-green-500">
                  Shop All
                </Link>
              </li>
              <li>
                <Link to="/men" className="hover:text-green-500">
                  Men's Collection
                </Link>
              </li>
              <li>
                <Link to="/women" className="hover:text-green-500">
                  Women's Collection
                </Link>
              </li>
              <li>
                <Link to="/kids" className="hover:text-green-500">
                  Kids' Collection
                </Link>
              </li>
            </ul>
          </div>

          {/* Customer Service */}
          <div>
            <h3 className="mb-4 text-lg font-semibold text-white">Customer Service</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link to="#" className="hover:text-green-500">
                  Contact Us
                </Link>
              </li>
              <li>
                <Link to="#" className="hover:text-green-500">
                  Shipping Info
                </Link>
              </li>
              <li>
                <Link to="#" className="hover:text-green-500">
                  Returns
                </Link>
              </li>
              <li>
                <Link to="#" className="hover:text-green-500">
                  FAQ
                </Link>
              </li>
            </ul>
          </div>

          {/* Contact */}
          <div>
            <h3 className="mb-4 text-lg font-semibold text-white">Contact</h3>
            <ul className="space-y-2 text-sm">
              <li className="flex items-center gap-2">
                <Phone className="h-4 w-4" />
                <span>+1 (555) 123-4567</span>
              </li>
              <li className="flex items-center gap-2">
                <Mail className="h-4 w-4" />
                <span>support@footsy.com</span>
              </li>
              <li className="flex items-center gap-2">
                <MapPin className="h-4 w-4" />
                <span>123 Fashion St, NY 10001</span>
              </li>
            </ul>
            <div className="mt-4 flex gap-4">
              <a href="#" className="hover:text-green-500">
                <Facebook className="h-5 w-5" />
              </a>
              <a href="#" className="hover:text-green-500">
                <Instagram className="h-5 w-5" />
              </a>
              <a href="#" className="hover:text-green-500">
                <Twitter className="h-5 w-5" />
              </a>
            </div>
          </div>
        </div>

        <div className="mt-8 border-t border-gray-800 pt-8 text-center text-sm">
          <p>&copy; 2026 Footsy. All rights reserved.</p>
        </div>
      </div>
    </footer>
  );
};
