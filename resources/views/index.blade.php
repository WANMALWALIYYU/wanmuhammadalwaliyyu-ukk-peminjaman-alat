<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/image/logo-mcr.png') }}" />
    <title>MedikCareRent - @yield('pages')</title>

    <!-- BOOTSTRAP LINK -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- GOOGLE FONTS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- AOS (Animation On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- SWIPER JS  Carousel) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
</head>

<body>

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-content">
            <div class="logo-loading">
                <img src="{{ asset('assets/image/logo-name-mcr.png') }}" alt="Logo-name-mcr">
            </div>
            <div class="loading-bar">
                <div class="loading-progress"></div>
            </div>
        </div>
    </div>

    <!-- WhatsApp Floating -->
    <a href="https://api.whatsapp.com/send?phone=628132002611" target="_blank" class="whatsapp-float-produk">
        <div class="whatsapp-icon">
            <i class="fab fa-whatsapp"></i>
        </div>
        <span class="whatsapp-text">Hubungi Kami</span>
    </a>

    @include('pages.header')

    <main class="content">
        @yield('content')
    </main>


    @include('pages.footer')


    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ====================================
            // AMBIL TANGGAL UNTUK COPYRIGHT
            // ====================================
            const yearElement = document.getElementById('currentYear');
            if (yearElement) {
                yearElement.textContent = new Date().getFullYear();
            }

            // ====================================
            // BACK TO TOP BUTTON
            // ====================================
            const backToTop = document.getElementById('backToTop');
            if (backToTop) {
                window.addEventListener('scroll', function() {
                    if (window.pageYOffset > 300) {
                        backToTop.classList.add('show');
                    } else {
                        backToTop.classList.remove('show');
                    }
                });

                backToTop.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }

            // ====================================
            // INITIALIZE AOS
            // ====================================
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    easing: 'ease-in-out',
                    once: true,
                    offset: 100
                });
            }

            // ====================================
            // PRELOADER
            // ====================================
            window.addEventListener('load', function() {
                const preloader = document.querySelector('.preloader');
                if (preloader) {
                    setTimeout(() => {
                        preloader.style.opacity = '0';
                        preloader.style.visibility = 'hidden';
                    }, 500);
                }
            });

            // ====================================
            // PENGUNJUNG SLIDER (ANIMASI INFINITE)
            // ====================================
            const penggunaSliders = ['.pengguna-slider', '.pengguna-slider-sec'];

            penggunaSliders.forEach(selector => {
                const slider = document.querySelector(selector);
                if (slider) {
                    slider.addEventListener('mouseenter', function() {
                        const penggunaBody = this.querySelector(selector === '.pengguna-slider' ?
                            '.pengguna-body' : '.pengguna-body-sec');
                        if (penggunaBody) {
                            penggunaBody.style.animationPlayState = 'paused';
                        }
                    });

                    slider.addEventListener('mouseleave', function() {
                        const penggunaBody = this.querySelector(selector === '.pengguna-slider' ?
                            '.pengguna-body' : '.pengguna-body-sec');
                        if (penggunaBody) {
                            penggunaBody.style.animationPlayState = 'running';
                        }
                    });
                }
            });

            document.querySelectorAll('.move-img, .move-img-sec').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    const parentSlider = this.closest('.pengguna-slider, .pengguna-slider-sec');
                    if (parentSlider) {
                        const penggunaBody = parentSlider.querySelector(
                            '.pengguna-body, .pengguna-body-sec');
                        if (penggunaBody) {
                            penggunaBody.style.animationPlayState = 'paused';
                        }
                    }
                });

                item.addEventListener('mouseleave', function() {
                    const parentSlider = this.closest('.pengguna-slider, .pengguna-slider-sec');
                    if (parentSlider) {
                        const penggunaBody = parentSlider.querySelector(
                            '.pengguna-body, .pengguna-body-sec');
                        if (penggunaBody) {
                            penggunaBody.style.animationPlayState = 'running';
                        }
                    }
                });
            });

            const sliders = document.querySelectorAll('.pengguna-body, .pengguna-body-sec');
            sliders.forEach(slider => {
                slider.style.willChange = 'transform';
            });

            // ====================================
            // PRODUCT SLIDER (SCROLL HORIZONTAL - TIDAK MENGANGGU SCROLL VERTIKAL)
            // ====================================
            const productSliderWrapper = document.querySelector('.product-slider-wrapper');
            const productSlider = document.getElementById('productSlider');

            if (productSliderWrapper && productSlider) {
                let isDragging = false;
                let startX;
                let scrollLeft;
                let startScrollLeft;
                let isHorizontalScroll = false;
                let wheelTimeout;

                // Enable horizontal scroll with mouse wheel - TIDAK MENGANGGU SCROLL VERTIKAL
                productSliderWrapper.addEventListener('wheel', (e) => {
                    // Deteksi arah scroll - bandingkan deltaX dan deltaY
                    const deltaXAbs = Math.abs(e.deltaX);
                    const deltaYAbs = Math.abs(e.deltaY);

                    // Jika scroll lebih horizontal (kiri/kanan) ATAU user menekan Shift
                    if (deltaXAbs > deltaYAbs || e.shiftKey) {
                        // Ini adalah scroll horizontal - lakukan horizontal scroll
                        e.preventDefault();
                        productSliderWrapper.scrollLeft += e.deltaY || e.deltaX;
                        isHorizontalScroll = true;

                        // Reset flag setelah selesai scroll
                        clearTimeout(wheelTimeout);
                        wheelTimeout = setTimeout(() => {
                            isHorizontalScroll = false;
                        }, 100);
                    }
                    // Jika scroll vertikal (atas/bawah) - biarkan default
                    // TIDAK ADA preventDefault() - halaman tetap bisa scroll ke atas/bawah
                }, { passive: false });

                // Mouse drag to scroll
                productSliderWrapper.addEventListener('mousedown', (e) => {
                    isDragging = true;
                    startX = e.pageX - productSliderWrapper.offsetLeft;
                    scrollLeft = productSliderWrapper.scrollLeft;
                    productSliderWrapper.style.cursor = 'grabbing';
                });

                productSliderWrapper.addEventListener('mouseleave', () => {
                    isDragging = false;
                    productSliderWrapper.style.cursor = 'grab';
                });

                productSliderWrapper.addEventListener('mouseup', () => {
                    isDragging = false;
                    productSliderWrapper.style.cursor = 'grab';
                });

                productSliderWrapper.addEventListener('mousemove', (e) => {
                    if (!isDragging) return;
                    e.preventDefault();
                    const x = e.pageX - productSliderWrapper.offsetLeft;
                    const walk = (x - startX) * 2;
                    productSliderWrapper.scrollLeft = scrollLeft - walk;
                });

                productSliderWrapper.style.cursor = 'grab';

                // Touch events untuk mobile (agar scroll vertikal tetap berfungsi)
                let touchStartX = 0;
                let touchStartY = 0;
                let touchScrollLeft = 0;
                let isTouchDragging = false;

                productSliderWrapper.addEventListener('touchstart', (e) => {
                    touchStartX = e.touches[0].pageX - productSliderWrapper.offsetLeft;
                    touchStartY = e.touches[0].pageY;
                    touchScrollLeft = productSliderWrapper.scrollLeft;
                    isTouchDragging = true;
                }, { passive: true });

                productSliderWrapper.addEventListener('touchmove', (e) => {
                    if (!isTouchDragging) return;

                    const touchX = e.touches[0].pageX - productSliderWrapper.offsetLeft;
                    const touchY = e.touches[0].pageY;
                    const deltaX = Math.abs(touchX - touchStartX);
                    const deltaY = Math.abs(touchY - touchStartY);

                    // Jika scroll lebih horizontal daripada vertikal, lakukan horizontal scroll
                    if (deltaX > deltaY && deltaX > 10) {
                        e.preventDefault();
                        const walk = (touchX - touchStartX) * 1;
                        productSliderWrapper.scrollLeft = touchScrollLeft - walk;
                    }
                    // Jika scroll vertikal, biarkan default (tidak di-prevent)
                }, { passive: false });

                productSliderWrapper.addEventListener('touchend', () => {
                    isTouchDragging = false;
                });
            }

            // ====================================
            // APPLE-STYLE ACCORDION - SEMUA TERTUTUP AWALNYA
            // ====================================
            const accordionButtons = document.querySelectorAll('.accordion-button');
            const featureVisualContainer = document.getElementById('featureVisual');
            const featureImage = document.querySelector('.feature-image');
            const visualOverlay = document.querySelector('.visual-overlay h4');
            const visualDescription = document.querySelector('.visual-overlay p');
            const visualIndicator = document.querySelector('.visual-indicator');

            // Data untuk setiap visual
            const visualData = {
                'phone': {
                    image: 'assets/image/terpercaya.png',
                    title: 'Mobile-First Design',
                    icon: 'fas fa-mobile-alt',
                    description: 'Akses sistem kapan saja, di mana saja melalui aplikasi mobile yang responsif',
                    indicator: 'Mobile Optimized'
                },
                'laptop': {
                    image: 'assets/image/siap-pakai.png',
                    title: 'Desktop Experience',
                    icon: 'fas fa-laptop-medical',
                    description: 'Interface desktop yang powerful untuk manajemen rumah sakit yang komprehensif',
                    indicator: 'Full Desktop Support'
                },
                'video': {
                    image: 'assets/image/konsultasi.png',
                    title: 'Virtual Consultation',
                    icon: 'fas fa-video',
                    description: 'Konsultasi real-time dengan tim ahli kami melalui platform video terintegrasi',
                    indicator: 'Live Consultation'
                },
                'headset': {
                    image: 'assets/image/layanan.png',
                    title: '24/7 Support',
                    icon: 'fas fa-headset',
                    description: 'Tim support profesional siap membantu melalui berbagai platform komunikasi',
                    indicator: 'Always Available'
                },
                'tablet': {
                    image: 'assets/image/fleksibel.png',
                    title: 'Adaptive Interface',
                    icon: 'fas fa-tablet-alt',
                    description: 'Dashboard yang dapat disesuaikan untuk berbagai kebutuhan dan preferensi',
                    indicator: 'Fully Customizable'
                }
            };

            // TUTUP SEMUA ACCORDION AWALNYA
            if (accordionButtons.length > 0) {
                // Pastikan semua collapse tidak terbuka
                const allCollapses = document.querySelectorAll('.accordion-collapse');
                allCollapses.forEach(collapse => {
                    collapse.classList.remove('show');
                });

                // Pastikan semua button memiliki class 'collapsed'
                accordionButtons.forEach(button => {
                    button.classList.add('collapsed');
                    button.setAttribute('aria-expanded', 'false');
                });
            }

            if (accordionButtons.length > 0 && featureVisualContainer) {
                function appleFadeUpAnimation(element) {
                    element.style.animation = 'none';
                    element.offsetHeight;
                    element.style.animation = 'appleFadeInVisual 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards';
                }

                accordionButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const accordionItem = this.closest('.accordion-item');
                        const visualType = accordionItem.getAttribute('data-visual');

                        if (visualData[visualType]) {
                            featureVisualContainer.classList.add('changing');
                            appleFadeUpAnimation(featureVisualContainer);

                            setTimeout(() => {
                                if (featureImage) {
                                    featureImage.style.opacity = '0';
                                    featureImage.style.transform = 'translateY(10px)';
                                }

                                setTimeout(() => {
                                    if (featureImage) {
                                        featureImage.src = visualData[visualType].image;
                                        featureImage.alt = visualData[visualType].title;
                                    }

                                    if (visualOverlay) {
                                        visualOverlay.style.opacity = '0';
                                        visualOverlay.style.transform = 'translateY(5px)';
                                    }

                                    if (visualDescription) {
                                        visualDescription.style.opacity = '0';
                                        visualDescription.style.transform = 'translateY(5px)';
                                    }

                                    setTimeout(() => {
                                        if (visualOverlay) {
                                            visualOverlay.innerHTML =
                                                `<i class="${visualData[visualType].icon}"></i> ${visualData[visualType].title}`;
                                        }

                                        if (visualDescription) {
                                            visualDescription.textContent = visualData[visualType].description;
                                        }

                                        if (visualIndicator) {
                                            visualIndicator.innerHTML =
                                                `<i class="${visualData[visualType].icon}"></i> ${visualData[visualType].indicator}`;
                                        }

                                        if (featureImage) {
                                            featureImage.style.opacity = '1';
                                            featureImage.style.transform = 'translateY(0)';
                                        }

                                        if (visualOverlay) {
                                            visualOverlay.style.opacity = '1';
                                            visualOverlay.style.transform = 'translateY(0)';
                                        }

                                        if (visualDescription) {
                                            visualDescription.style.opacity = '1';
                                            visualDescription.style.transform = 'translateY(0)';
                                        }

                                        setTimeout(() => {
                                            featureVisualContainer.classList.remove('changing');
                                        }, 500);
                                    }, 150);
                                }, 200);
                            }, 100);
                        }

                        if (!featureVisualContainer.classList.contains('active')) {
                            featureVisualContainer.classList.add('active');
                        }
                    });
                });

                // Set visual awal berdasarkan accordion pertama (tapi jangan buka accordionnya)
                const firstItem = document.querySelector('.accordion-item[data-visual]');
                if (firstItem) {
                    const firstVisualType = firstItem.getAttribute('data-visual');
                    if (visualData[firstVisualType]) {
                        if (featureImage) {
                            featureImage.src = visualData[firstVisualType].image;
                            featureImage.alt = visualData[firstVisualType].title;
                        }

                        if (visualOverlay) {
                            visualOverlay.innerHTML =
                                `<i class="${visualData[firstVisualType].icon}"></i> ${visualData[firstVisualType].title}`;
                        }

                        if (visualDescription) {
                            visualDescription.textContent = visualData[firstVisualType].description;
                        }

                        if (visualIndicator) {
                            visualIndicator.innerHTML =
                                `<i class="${visualData[firstVisualType].icon}"></i> ${visualData[firstVisualType].indicator}`;
                        }

                        featureVisualContainer.classList.add('active');
                    }
                }

                accordionItems = document.querySelectorAll('.accordion-item');
                accordionItems.forEach(item => {
                    item.addEventListener('mouseenter', function() {
                        this.style.transition = 'transform 0.3s ease';
                    });

                    item.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0)';
                    });
                });
            }
        });
    </script>

</body>

</html>
