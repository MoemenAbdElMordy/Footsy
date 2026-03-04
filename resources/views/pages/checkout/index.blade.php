@extends('layouts.app')

@push('styles')
<style>
    #card-element {
        padding: .5rem .75rem;
        border-radius: .375rem;
        border: 1px solid var(--bs-border-color);
        background-color: var(--color-input-background);
    }
    #card-element.is-focused {
        border-color: rgba(13, 110, 253, .55);
        box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .15);
    }
    #card-element.is-invalid {
        border-color: rgba(220, 53, 69, .7);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-3 px-md-4 py-3 py-md-4">
    <h1 class="h3 h2-md display-6 fw-bold mb-3 mb-md-4">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="row g-3 g-md-4">
            <!-- Shipping Information -->
            <div class="col-12 col-lg-8">
                <div class="card mb-3 mb-md-4">
                    <div class="card-header p-3 p-md-4">
                        <h3 class="h6 h5-md fw-semibold mb-0">Shipping Information</h3>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        @if(!empty($addresses) && $addresses->count())
                            <div class="mb-3">
                                <label for="savedAddress" class="form-label small-md-base">Use saved address</label>
                                <select id="savedAddress" class="form-select" style="background-color: var(--color-input-background);">
                                    <option value="">-- Select --</option>
                                    @foreach($addresses as $addr)
                                        <option value="{{ $addr->id }}"
                                            data-full-name="{{ $addr->full_name }}"
                                            data-address="{{ $addr->address }}"
                                            data-city="{{ $addr->city }}"
                                            data-state="{{ $addr->state }}"
                                            data-zip-code="{{ $addr->zip_code }}"
                                            data-phone="{{ $addr->phone }}"
                                            {{ (!empty($defaultAddress) && $defaultAddress->id === $addr->id) ? 'selected' : '' }}>
                                            {{ $addr->label ?: 'Address' }} - {{ $addr->city }}, {{ $addr->state }}
                                            {{ $addr->is_default ? '(Default)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="text-muted small mt-1">Select an address to auto-fill the shipping form.</div>
                            </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="fullName" class="form-label small-md-base">Full Name *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="fullName" 
                                       name="full_name"
                                       value="{{ old('full_name', auth()->user()->name ?? '') }}"
                                       required
                                       style="background-color: var(--color-input-background);">
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label small-md-base">Address *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="address" 
                                       name="address"
                                       value="{{ old('address') }}"
                                       required
                                       style="background-color: var(--color-input-background);">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="city" class="form-label small-md-base">City *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="city" 
                                       name="city"
                                       value="{{ old('city') }}"
                                       required
                                       style="background-color: var(--color-input-background);">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="state" class="form-label small-md-base">State *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="state" 
                                       name="state"
                                       value="{{ old('state') }}"
                                       required
                                       style="background-color: var(--color-input-background);">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="zipCode" class="form-label small-md-base">ZIP Code *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="zipCode" 
                                       name="zip_code"
                                       value="{{ old('zip_code') }}"
                                       required
                                       style="background-color: var(--color-input-background);">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="phone" class="form-label small-md-base">Phone *</label>
                                <input type="tel" 
                                       class="form-control" 
                                       id="phone" 
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       required
                                       style="background-color: var(--color-input-background);">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header p-3 p-md-4">
                        <h3 class="h6 h5-md fw-semibold mb-0">Payment Method</h3>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="border rounded p-3 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="payment_method" 
                                       id="cod" 
                                       value="cod" 
                                       checked>
                                <label class="form-check-label" for="cod">
                                    <span class="fw-medium">Cash on Delivery</span>
                                    <p class="small text-muted mb-0">Pay when you receive your order</p>
                                </label>
                            </div>
                        </div>

                        <div class="border rounded p-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="card" value="card">
                                <label class="form-check-label" for="card">
                                    <span class="fw-medium">Card (Stripe)</span>
                                    <p class="small text-muted mb-0">Pay securely with your card</p>
                                </label>
                            </div>

                            <div id="cardPaymentBox" class="mt-3" style="display:none;">
                                <div id="card-element"></div>
                                <div id="card-errors" class="small text-danger mt-2" role="alert"></div>
                                <input type="hidden" name="order_id" id="order_id" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-12 col-lg-4">
                <div class="card sticky-top" style="top: calc(var(--spacing-xl) + 1rem);">
                    <div class="card-header">
                        <h3 class="h6 h5-md fw-semibold mb-0">Order Summary</h3>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="mb-4 d-flex flex-column gap-2">
                            @foreach($cartItems as $item)
                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">
                                        {{ $item->product->name }} x {{ $item->quantity }}
                                    </span>
                                    <span>${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-top pt-3 d-flex flex-column gap-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Subtotal</span>
                                <span>${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Shipping</span>
                                <span>{{ $shipping === 0 ? 'Free' : '$' . number_format($shipping, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Tax</span>
                                <span>${{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-2 fs-5 fw-semibold">
                                <span>Total</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <button type="submit" 
                                class="btn btn-success w-100 btn-lg mt-3 mt-md-4"
                                style="background-color: var(--color-success); border-color: var(--color-success);">
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const savedAddressSelect = document.getElementById('savedAddress');
    const inputFullName = document.getElementById('fullName');
    const inputAddress = document.getElementById('address');
    const inputCity = document.getElementById('city');
    const inputState = document.getElementById('state');
    const inputZip = document.getElementById('zipCode');
    const inputPhone = document.getElementById('phone');

    function isEmptyValue(v) {
        return !v || String(v).trim() === '';
    }

    function fillFromSelectedAddress(force = false) {
        if (!savedAddressSelect) return;
        const opt = savedAddressSelect.options[savedAddressSelect.selectedIndex];
        if (!opt || !opt.dataset) return;

        const data = opt.dataset;

        if (force || isEmptyValue(inputFullName.value)) inputFullName.value = data.fullName || inputFullName.value;
        if (force || isEmptyValue(inputAddress.value)) inputAddress.value = data.address || inputAddress.value;
        if (force || isEmptyValue(inputCity.value)) inputCity.value = data.city || inputCity.value;
        if (force || isEmptyValue(inputState.value)) inputState.value = data.state || inputState.value;
        if (force || isEmptyValue(inputZip.value)) inputZip.value = data.zipCode || inputZip.value;
        if (force || isEmptyValue(inputPhone.value)) inputPhone.value = data.phone || inputPhone.value;
    }

    if (savedAddressSelect) {
        savedAddressSelect.addEventListener('change', () => {
            if (!savedAddressSelect.value) return;
            fillFromSelectedAddress(true);
        });

        const allEmpty = isEmptyValue(inputAddress.value)
            && isEmptyValue(inputCity.value)
            && isEmptyValue(inputState.value)
            && isEmptyValue(inputZip.value)
            && isEmptyValue(inputPhone.value);

        if (savedAddressSelect.value && allEmpty) {
            fillFromSelectedAddress(true);
        }
    }

    const stripeKey = @json(config('stripe.key'));
    const stripe = stripeKey ? Stripe(stripeKey) : null;

    const checkoutForm = document.getElementById('checkoutForm');
    const codRadio = document.getElementById('cod');
    const cardRadio = document.getElementById('card');
    const cardPaymentBox = document.getElementById('cardPaymentBox');
    const cardErrors = document.getElementById('card-errors');
    const orderIdInput = document.getElementById('order_id');
    const submitBtn = checkoutForm.querySelector('button[type="submit"]');
    const originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';

    let elements = null;
    let cardElement = null;

    function showCardBox(show) {
        cardPaymentBox.style.display = show ? 'block' : 'none';
    }

    async function ensureStripeReady() {
        if (!stripe) {
            throw new Error('Stripe key is missing. Please set STRIPE_KEY in .env');
        }

        if (!elements) {
            elements = stripe.elements({
                appearance: {
                    theme: 'stripe',
                }
            });
            cardElement = elements.create('card', {
                hidePostalCode: true,
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#111827',
                        '::placeholder': { color: '#6b7280' }
                    },
                    invalid: {
                        color: '#dc3545'
                    }
                }
            });
            cardElement.mount('#card-element');

            cardElement.on('focus', () => {
                const el = document.getElementById('card-element');
                if (el) el.classList.add('is-focused');
            });

            cardElement.on('blur', () => {
                const el = document.getElementById('card-element');
                if (el) el.classList.remove('is-focused');
            });

            cardElement.on('change', (event) => {
                const el = document.getElementById('card-element');
                if (!el) return;

                if (event.error) {
                    el.classList.add('is-invalid');
                    cardErrors.textContent = event.error.message || 'Invalid card details.';
                } else {
                    el.classList.remove('is-invalid');
                    cardErrors.textContent = '';
                }
            });
        }
    }

    codRadio.addEventListener('change', () => showCardBox(false));
    cardRadio.addEventListener('change', async () => {
        showCardBox(true);
        try {
            await ensureStripeReady();
        } catch (e) {
            cardErrors.textContent = e.message;
        }
    });

    async function fetchWithTimeout(url, options = {}, timeoutMs = 30000) {
        const controller = new AbortController();
        const timer = setTimeout(() => controller.abort(), timeoutMs);
        try {
            return await fetch(url, { ...options, signal: controller.signal });
        } finally {
            clearTimeout(timer);
        }
    }

    checkoutForm.addEventListener('submit', async (e) => {
        if (!cardRadio.checked) {
            return;
        }

        e.preventDefault();
        cardErrors.textContent = '';

        try {
            await ensureStripeReady();

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...';
            }

            const formData = new FormData(checkoutForm);
            const paymentIntentRes = await fetchWithTimeout(@json(route('checkout.payment_intent')), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': @json(csrf_token()),
                    'Accept': 'application/json'
                },
                body: formData
            }, 30000);

            const piJson = await paymentIntentRes.json();
            if (!paymentIntentRes.ok) {
                throw new Error(piJson.message || 'Unable to start payment.');
            }

            orderIdInput.value = piJson.orderId;

            const fullName = (checkoutForm.querySelector('input[name="full_name"]') || {}).value || '';
            const zipCode = (checkoutForm.querySelector('input[name="zip_code"]') || {}).value || '';

            const { error } = await stripe.confirmCardPayment(piJson.clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: fullName,
                        address: {
                            postal_code: zipCode,
                        }
                    }
                }
            });

            if (error) {
                throw new Error(error.message || 'Payment failed.');
            }

            const confirmRes = await fetchWithTimeout(@json(route('checkout.confirm')), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': @json(csrf_token()),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ order_id: piJson.orderId })
            }, 30000);

            const confirmJson = await confirmRes.json();
            if (!confirmRes.ok) {
                throw new Error(confirmJson.message || 'Unable to confirm payment.');
            }

            window.location.href = confirmJson.redirect;
        } catch (err) {
            if (err && err.name === 'AbortError') {
                cardErrors.textContent = 'Request timed out. Please try again.';
            } else {
                cardErrors.textContent = err.message || 'Payment failed.';
            }
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHtml;
            }
        }
    });
</script>
@endpush

