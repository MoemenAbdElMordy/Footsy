<footer class="border-top bg-dark text-light mt-auto" style="background-color: var(--color-gray-900); color: var(--color-gray-300);">
    <div class="container-fluid px-3 px-md-4 py-4 py-md-5">
        <div class="row g-3 g-md-4">
            <!-- About -->
            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                <h3 class="h6 h5-md mb-2 mb-md-3 text-white">Footsy</h3>
                <p class="small">
                    Your premier destination for quality footwear. We offer the latest styles for men, women, and kids.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                <h3 class="h6 h5-md mb-2 mb-md-3 text-white">Quick Links</h3>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="{{ route('shop.index') }}" 
                           class="text-decoration-none text-light"
                           style="transition: color var(--transition-fast);">
                            Shop All
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('shop.category', 'men') }}" 
                           class="text-decoration-none text-light"
                           style="transition: color var(--transition-fast);">
                            Men's Collection
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('shop.category', 'women') }}" 
                           class="text-decoration-none text-light"
                           style="transition: color var(--transition-fast);">
                            Women's Collection
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('shop.category', 'kids') }}" 
                           class="text-decoration-none text-light"
                           style="transition: color var(--transition-fast);">
                            Kids' Collection
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                <h3 class="h6 h5-md mb-2 mb-md-3 text-white">Customer Service</h3>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="#" class="text-decoration-none text-light"
                           style="transition: color var(--transition-fast);">Contact Us</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-decoration-none text-light"
                           style="transition: color var(--transition-fast);">Shipping Info</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-decoration-none text-light"
                           style="transition: color var(--transition-fast);">Returns</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-decoration-none text-light"
                           style="transition: color var(--transition-fast);">FAQ</a>
                    </li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
                <h3 class="h6 h5-md mb-2 mb-md-3 text-white">Contact</h3>
                <ul class="list-unstyled small">
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-telephone"></i>
                        <span>+1 (555) 123-4567</span>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-envelope"></i>
                        <span>support@footsy.com</span>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-geo-alt"></i>
                        <span>123 Fashion St, NY 10001</span>
                    </li>
                </ul>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-light" style="transition: color var(--transition-fast);">
                        <i class="bi bi-facebook fs-5"></i>
                    </a>
                    <a href="#" class="text-light" style="transition: color var(--transition-fast);">
                        <i class="bi bi-instagram fs-5"></i>
                    </a>
                    <a href="#" class="text-light" style="transition: color var(--transition-fast);">
                        <i class="bi bi-twitter fs-5"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-top border-secondary mt-4 pt-4 text-center small">
            <p class="mb-0">&copy; {{ date('Y') }} Footsy. All rights reserved.</p>
        </div>
    </div>
</footer>

