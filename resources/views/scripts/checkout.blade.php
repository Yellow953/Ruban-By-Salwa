<script async>
    // Stepper
    document.addEventListener("DOMContentLoaded", function () {
        const steps = document.querySelectorAll(".step");
        const stepperItems = document.querySelectorAll(".stepper-item");
        const progressBar = document.querySelector(".stepper-progress-bar");
        const orderTypeSelect = document.getElementById("order_type");
        let currentStep = 0;

        orderTypeSelect.addEventListener("change", function() {
            if (this.value === 'delivery') {
                loadGoogleMapsIfNeeded();
            }
            toggleDeliveryStepVisibility();
            updateStepper();
        });


        function toggleDeliveryStepVisibility() {
            const isStore = orderTypeSelect.value === "store";
            stepperItems[1].style.display = isStore ? "none" : "block";
            steps[1].style.display = isStore ? "none" : "block";
        }

        document.querySelectorAll(".next-step").forEach((btn) => {
            btn.addEventListener("click", function (e) {
                if (validateStep(currentStep)) {
                    if (currentStep === 0 && orderTypeSelect.value === "store") {
                        currentStep = 2;
                    } else if (currentStep < steps.length - 1) {
                        currentStep++;
                    }

                    if (currentStep === 1) {
                        loadGoogleMapsIfNeeded();
                    }

                    updateStepper();
                }
            });
        });

        document.querySelectorAll(".prev-step").forEach((btn) => {
            btn.addEventListener("click", function (e) {
                if (currentStep === 2 && orderTypeSelect.value === "store") {
                    currentStep = 0;
                } else if (currentStep > 0) {
                    currentStep--;
                }
                updateStepper();
            });
        });

        function updateStepper() {
            const isStore = orderTypeSelect.value === "store";
            const visibleSteps = isStore ? 2 : 3;

            const progress = Math.min((currentStep / (visibleSteps - 1)) * 100, 100);
            progressBar.style.width = `${progress}%`;

            stepperItems.forEach((item, index) => {
                const shouldShow = !(isStore && index === 1);
                item.style.display = shouldShow ? "flex" : "none";
                item.classList.toggle("active", index === currentStep);
                item.classList.toggle("completed", index < currentStep);
            });

            steps.forEach((step, index) => {
                if (isStore && index === 1) {
                    step.style.display = "none";
                } else {
                    step.style.display = index === currentStep ? "block" : "none";
                }
            });
        }

        function validateStep(stepIndex) {
            const currentStepEl = steps[stepIndex];
            let isValid = true;

            const requiredFields = currentStepEl.querySelectorAll("[required]:not([disabled])");
            requiredFields.forEach((field) => {
                if (!field.checkValidity()) {
                    field.reportValidity();
                    isValid = false;
                }
            });

            return isValid;
        }

        toggleDeliveryStepVisibility();
        updateStepper();
    });


    var businessId = {{ $business->id }};
    var cookieKey = `bag_${businessId}`;

    function getBagFromCookies() {
        try {
            const match = document.cookie.match(new RegExp(`(?:^| )${cookieKey}=([^;]+)`));
            return match ? JSON.parse(decodeURIComponent(match[1])) : [];
        } catch (e) {
            console.error('Error parsing bag data:', e);
            return [];
        }
    }

    function formatVariantOptions(variants) {
        if (!variants || variants.length === 0) return '';

        return variants.map(v => {
            const priceAdjustment = v.price_adjustment ? ` (+$${v.price_adjustment.toFixed(2)})` : '';
            return `${v.value}${priceAdjustment}`;
        }).join(', ');
    }

    $(document).ready(function() {
        var rate = {{ $rate }};
        var bag = getBagFromCookies();

        updateCheckoutSummary();

        function updateCheckoutSummary() {
            var orderSummary = $("#orderSummary");
            var subtotal = 0;
            var deliveryFee = {{ $business->delivery ?? 0 }};
            orderSummary.empty();

            if (bag.length === 0) {
                orderSummary.append('<p class="text-center text-muted">Your bag is empty.</p>');
                $("#checkoutButton").prop('disabled', true);
            } else {
                bag.forEach((item) => {
                    var itemTotal = item.price * item.quantity;
                    subtotal += itemTotal;

                    var variantText = item.variants && item.variants.length > 0
                        ? `<small class="d-block text-muted">${formatVariantOptions(item.variants)}</small>`
                        : '';

                    orderSummary.append(`
                        <div class="d-flex mb-4">
                            <img src="${item.image}" class="product-thumbnail me-3">
                            <div>
                                <h6 class="mb-1">${item.name}</h6>
                                ${variantText}
                                <small class="text-muted">Quantity: ${item.quantity}</small>
                                <div>$${itemTotal.toFixed(2)}</div>
                            </div>
                        </div>
                    `);
                });

                const orderType = document.getElementById("order_type").value;
                if (orderType === 'delivery') {
                    subtotal += deliveryFee;
                }
            }

            $("#checkoutSubtotal").text(`$${(subtotal - deliveryFee).toFixed(2)}`);
            $("#checkoutTotal").text(`$${subtotal.toFixed(2)}`);
            $("#checkoutTotalLBP").text(`${(subtotal * rate).toLocaleString()}LBP`);
        }
    });

    // Google Maps
    let map;
    let marker;
    let autocomplete;
    let isMapInitialized = false;
    let isGoogleMapsLoaded = false;

    function initMap() {
        const orderType = document.getElementById('order_type').value;

        if (orderType !== 'delivery' || isMapInitialized) return;

        if (!google || !google.maps) {
            alert('Failed to load Google Maps - please check your internet connection');
            return;
        }

        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -34.397, lng: 150.644 },
            zoom: 13,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false,
            styles: [
                {
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [{ visibility: "off" }]
                }
            ]
        });

        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('autocomplete'),
            { types: ['geocode'] }
        );

        marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            draggable: true,
            icon: {
                url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png",
                scaledSize: new google.maps.Size(40, 40)
            }
        });

        autocomplete.addListener('place_changed', () => {
            const place = autocomplete.getPlace();
            if (!place.geometry) {
                alert("Couldn't find that location - please try again");
                return;
            }
            updateLocation(
                place.geometry.location.lat(),
                place.geometry.location.lng(),
                place.formatted_address
            );
        });

        marker.addListener('dragend', (e) => {
            reverseGeocode(e.latLng.lat(), e.latLng.lng());
        });

        map.addListener('click', (e) => {
            reverseGeocode(e.latLng.lat(), e.latLng.lng());
        });

        document.getElementById('current-location').addEventListener('click', () => {
            if (navigator.geolocation) {
                const options = {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                };

                const btn = document.getElementById('current-location');
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Locating...';
                btn.disabled = true;

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        btn.innerHTML = '<i class="fas fa-location-arrow me-2"></i>Use Current Location';
                        btn.disabled = false;

                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        if (window.accuracyCircle) {
                            window.accuracyCircle.setMap(null);
                        }

                        window.accuracyCircle = new google.maps.Circle({
                            strokeColor: "#ff0000",
                            strokeOpacity: 0.8,
                            strokeWeight: 2,
                            fillColor: "#ff0000",
                            fillOpacity: 0.15,
                            map: map,
                            center: pos,
                            radius: position.coords.accuracy
                        });

                        if (position.coords.accuracy > 1000) {
                            showErrorToast(
                                `Low location accuracy (${Math.round(position.coords.accuracy)} meters).
                                Please drag the pin to your exact location.`,
                                10000
                            );
                        }

                        map.setCenter(pos);
                        map.fitBounds(accuracyCircle.getBounds(), {
                            padding: 50
                        });

                        reverseGeocode(pos.lat, pos.lng);
                    },
                    (error) => {
                        btn.innerHTML = '<i class="fas fa-location-arrow me-2"></i>Use Current Location';
                        btn.disabled = false;

                        let errorMessage;
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage = "Location access denied. Please enable permissions in your browser settings.";
                                errorMessage += '<br><a href="https://support.google.com/chrome/answer/142065" target="_blank">How to enable location permissions</a>';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage = "Location information unavailable. Please check your internet connection.";
                                break;
                            case error.TIMEOUT:
                                errorMessage = "Location request timed out. Please try again in an area with better GPS signal.";
                                break;
                            default:
                                errorMessage = "Error getting location.";
                        }
                        showErrorToast(errorMessage, 10000);
                    },
                    options
                );
            } else {
                showErrorToast("Geolocation is not supported by this browser.", 5000);
            }
        });

        function showErrorToast(message, duration = 5000) {
            const toast = document.createElement('div');
            toast.className = 'alert alert-danger position-fixed top-0 end-0 m-3';
            toast.style.maxWidth = '400px';
            toast.innerHTML = `
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <div>${message}</div>
                </div>
            `;
            document.body.appendChild(toast);

            setTimeout(() => toast.remove(), duration);
        }

        isMapInitialized = true;
    }

    function loadGoogleMapsIfNeeded() {
        const orderType = document.getElementById('order_type').value;

        if (orderType === 'delivery' && !isGoogleMapsLoaded) {
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initMap`;
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
            isGoogleMapsLoaded = true;
        }
    }

    function updateLocation(lat, lng, address) {
        map.panTo({ lat, lng });
        map.setZoom(17);
        marker.setPosition({ lat, lng });
        marker.setVisible(true);

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        document.getElementById('formatted_address').value = address;
        document.getElementById('autocomplete').value = address;
    }

    function reverseGeocode(lat, lng) {
        new google.maps.Geocoder().geocode(
            { location: { lat, lng } },
            (results, status) => {
                if (status === "OK" && results[0]) {
                    updateLocation(lat, lng, results[0].formatted_address);
                }
            }
        );
    }

    window.gm_authFailure = function() {
        alert('Google Maps authentication failed - please check your API key');
    };

    // Order
    document.getElementById("submitBtn").addEventListener("click", function (event) {
        event.preventDefault();
        var bag = getBagFromCookies();

        let name = document.querySelector("input[name='name']").value.trim();
        let phone = document.querySelector("input[name='phone']").value.trim();
        let orderType = document.getElementById("order_type").value;
        let total = document.getElementById("checkoutTotal").textContent.trim();
        let totalLBP = document.getElementById("checkoutTotalLBP").textContent.trim();
        let latitude = document.querySelector("#latitude").value.trim();
        let longitude = document.querySelector("#longitude").value.trim();
        const mapsLink = `https://www.google.com/maps?q=${latitude},${longitude}`;
        let deliveryFee = {{ $business->delivery ?? 0 }};
        let subtotalUSD = parseFloat(total.replace(/[^0-9.]/g, ""));
        let actualTotalUSD = subtotalUSD;
        let deliveryText = "";
        var rate = {{ $rate }};

        if (orderType === 'delivery' && (!latitude || !longitude)) {
            alert('Please select a delivery location');
            return;
        }

        let items = bag.map(item => {
            let itemText = `- ${item.name} (${item.quantity}pcs)`;
            if (item.variants && item.variants.length > 0) {
                itemText += ` [${formatVariantOptions(item.variants)}]`;
            }
            itemText += ` - $${(item.price * item.quantity).toFixed(2)}`;
            return itemText;
        }).join("\n");

        if (orderType === 'delivery') {
            deliveryText = `Delivery Fee: $${deliveryFee.toFixed(2)}\n`;
        }

        let message = `Order Confirmation\n\n` +
            `Client:\n${name}\n${phone}\n\n` +
            `Order Type: ${orderType}\n\n` +
            `Items:\n${items}\n\n` +
            deliveryText +
            `Total: $${actualTotalUSD.toFixed(2)}\n` +
            `Total LBP: ${(actualTotalUSD * rate).toLocaleString()} LBP\n\n` +
            (orderType === 'delivery' ? `Delivery Location:  \n ${mapsLink}\n\n` : '') +
            `Please confirm my order.`;

        let encodedMessage = encodeURIComponent(message);
        let businessWhatsApp = {{ $business->phone }};

        window.open(`https://wa.me/${businessWhatsApp}?text=${encodedMessage}`, "_blank");
    });

</script>