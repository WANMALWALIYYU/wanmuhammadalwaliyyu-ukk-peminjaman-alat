<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/image/logo-mcr.png">
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
                    // Hentikan animasi saat hover slider
                    slider.addEventListener('mouseenter', function() {
                        const penggunaBody = this.querySelector(selector === '.pengguna-slider' ?
                            '.pengguna-body' : '.pengguna-body-sec');
                        if (penggunaBody) {
                            penggunaBody.style.animationPlayState = 'paused';
                        }
                    });

                    // Lanjutkan animasi saat mouse keluar
                    slider.addEventListener('mouseleave', function() {
                        const penggunaBody = this.querySelector(selector === '.pengguna-slider' ?
                            '.pengguna-body' : '.pengguna-body-sec');
                        if (penggunaBody) {
                            penggunaBody.style.animationPlayState = 'running';
                        }
                    });
                }
            });

            // Kontrol animasi saat hover langsung ke item
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

            // Optimasi performa untuk animasi
            const sliders = document.querySelectorAll('.pengguna-body, .pengguna-body-sec');
            sliders.forEach(slider => {
                slider.style.willChange = 'transform';
            });

            // ====================================
            // PRODUCT SLIDER (4 KOLOM DENGAN ARROW)
            // ====================================
            const productSlider = document.getElementById('productSlider');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const dotsContainer = document.getElementById('sliderDots');

            if (productSlider && prevBtn && nextBtn && dotsContainer) {
                const slides = document.querySelectorAll('.product-slide');
                const slidesCount = slides.length;

                if (slidesCount > 0) {
                    let slidesPerView = getSlidesPerView();
                    const maxIndex = Math.max(0, Math.ceil(slidesCount / slidesPerView) - 1);
                    let currentIndex = 0;
                    let isTransitioning = false;

                    // Create dots
                    dotsContainer.innerHTML = ''; // Kosongkan dots container
                    for (let i = 0; i <= maxIndex; i++) {
                        const dot = document.createElement('button');
                        dot.classList.add('slider-dot');
                        if (i === 0) dot.classList.add('active');
                        dot.addEventListener('click', () => goToSlide(i));
                        dotsContainer.appendChild(dot);
                    }

                    const dots = document.querySelectorAll('.slider-dot');

                    // Update buttons state
                    function updateButtons() {
                        if (prevBtn) prevBtn.disabled = currentIndex === 0;
                        if (nextBtn) nextBtn.disabled = currentIndex === maxIndex;

                        // Update dots
                        dots.forEach((dot, index) => {
                            if (index === currentIndex) {
                                dot.classList.add('active');
                            } else {
                                dot.classList.remove('active');
                            }
                        });
                    }

                    // Go to specific slide
                    function goToSlide(index) {
                        if (isTransitioning || index < 0 || index > maxIndex) return;

                        isTransitioning = true;
                        currentIndex = index;

                        const slideWidth = slides[0].offsetWidth + 20; // termasuk gap
                        const translateX = -currentIndex * slideWidth * slidesPerView;

                        productSlider.style.transform = `translateX(${translateX}px)`;
                        updateButtons();

                        setTimeout(() => {
                            isTransitioning = false;
                        }, 500);
                    }

                    // Get slides per view based on screen size
                    function getSlidesPerView() {
                        if (window.innerWidth <= 480) return 1;
                        if (window.innerWidth <= 768) return 2;
                        if (window.innerWidth <= 1200) return 3;
                        return 4;
                    }

                    // Next slide
                    function nextSlide() {
                        if (currentIndex < maxIndex) {
                            goToSlide(currentIndex + 1);
                        }
                    }

                    // Previous slide
                    function prevSlide() {
                        if (currentIndex > 0) {
                            goToSlide(currentIndex - 1);
                        }
                    }

                    // Event listeners
                    prevBtn.addEventListener('click', prevSlide);
                    nextBtn.addEventListener('click', nextSlide);

                    // Handle resize
                    let resizeTimer;
                    window.addEventListener('resize', function() {
                        clearTimeout(resizeTimer);
                        resizeTimer = setTimeout(function() {
                            const newSlidesPerView = getSlidesPerView();
                            if (newSlidesPerView !== slidesPerView) {
                                slidesPerView = newSlidesPerView;
                                // Recalculate maxIndex
                                const newMaxIndex = Math.max(0, Math.ceil(slidesCount / slidesPerView) - 1);
                                if (newMaxIndex !== maxIndex) {
                                    location.reload(); // Refresh jika layout berubah drastis
                                } else {
                                    // Reset posisi jika perlu
                                    if (currentIndex > newMaxIndex) {
                                        goToSlide(newMaxIndex);
                                    }
                                }
                            }
                        }, 250);
                    });

                    // Touch events for mobile
                    let touchStartX = 0;
                    let touchEndX = 0;

                    productSlider.addEventListener('touchstart', (e) => {
                        touchStartX = e.changedTouches[0].screenX;
                    }, { passive: true });

                    productSlider.addEventListener('touchend', (e) => {
                        touchEndX = e.changedTouches[0].screenX;
                        handleSwipe();
                    }, { passive: true });

                    function handleSwipe() {
                        const swipeThreshold = 50;
                        const diff = touchStartX - touchEndX;

                        if (Math.abs(diff) > swipeThreshold) {
                            if (diff > 0 && currentIndex < maxIndex) {
                                // Swipe left
                                nextSlide();
                            } else if (diff < 0 && currentIndex > 0) {
                                // Swipe right
                                prevSlide();
                            }
                        }
                    }

                    // Initial update
                    updateButtons();
                }
            }

            // ====================================
            // APPLE-STYLE ACCORDION
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

            if (accordionButtons.length > 0 && featureVisualContainer) {
                // Fungsi untuk animasi fade-up Apple-style
                function appleFadeUpAnimation(element) {
                    element.style.animation = 'none';
                    element.offsetHeight; // Trigger reflow
                    element.style.animation = 'appleFadeInVisual 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards';
                }

                // Event listener untuk setiap accordion button
                accordionButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const accordionItem = this.closest('.accordion-item');
                        const visualType = accordionItem.getAttribute('data-visual');

                        if (visualData[visualType]) {
                            // Tambah efek transisi Apple-style
                            featureVisualContainer.classList.add('changing');
                            appleFadeUpAnimation(featureVisualContainer);

                            // Animasi smooth untuk perubahan konten
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

                                    // Update overlay dengan animasi
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

                                        // Animasikan kembali ke normal
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

                                        // Hapus efek transisi setelah selesai
                                        setTimeout(() => {
                                            featureVisualContainer.classList.remove('changing');
                                        }, 500);
                                    }, 150);
                                }, 200);
                            }, 100);
                        }

                        // Aktifkan container visual
                        if (!featureVisualContainer.classList.contains('active')) {
                            featureVisualContainer.classList.add('active');
                        }
                    });
                });

                // Set visual awal berdasarkan accordion pertama
                const firstActiveItem = document.querySelector('.accordion-item[data-visual]');
                if (firstActiveItem) {
                    const firstVisualType = firstActiveItem.getAttribute('data-visual');
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

                // Bootstrap accordion event listener
                const featureAccordion = document.getElementById('featureAccordion');
                if (featureAccordion) {
                    featureAccordion.addEventListener('show.bs.collapse', function(event) {
                        const targetId = event.target.id;
                        const accordionItem = document.querySelector(`[data-bs-target="#${targetId}"]`)?.closest('.accordion-item');

                        if (accordionItem) {
                            const visualType = accordionItem.getAttribute('data-visual');

                            if (visualData[visualType]) {
                                featureVisualContainer.classList.add('changing');
                                appleFadeUpAnimation(featureVisualContainer);

                                setTimeout(() => {
                                    if (featureImage) {
                                        featureImage.src = visualData[visualType].image;
                                        featureImage.alt = visualData[visualType].title;
                                    }

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

                                    setTimeout(() => {
                                        featureVisualContainer.classList.remove('changing');
                                    }, 500);
                                }, 200);
                            }
                        }
                    });
                }

                // Tambah efek hover pada accordion items
                const accordionItems = document.querySelectorAll('.accordion-item');
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
