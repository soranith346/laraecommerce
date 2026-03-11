<!DOCTYPE html>
<html lang="en">

<head>
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta name="keywords" content="Car Accessories, HengHor">
    <meta name="description" content="Premium Car Accessories">
    <meta name="author" content="HengHor">

    <title>HengHor | Premium Auto</title>

    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    {{-- CSS Libraries --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('front-end/mycss/style.css') }}"/>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('front-end/images/favicon.png') }}" type="image/x-icon">
</head>

<body>

    {{-- Header --}}
    <header class="header_section">
        <div class="container"> 
            <nav class="navbar navbar-expand-lg">
                <div class="brand-logo" style="font-family: 'Poppins', sans-serif; font-size: 24px; font-weight: 700; letter-spacing: 1px;">
                    <span style="color: #333;">HENG</span><span style="color: #0f52b6;">HOR</span>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="bi bi-list" style="font-size: 30px;"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item active"><a class="nav-link" href="{{ route('index') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('allProduct') }}">Shop</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Why Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Testimonial</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                    </ul>

                    <div class="user_option">
                        @if (Auth::check())
                            <a href="{{ route('dashboard') }}"><i class="bi bi-person-fill"></i></a>
                        @else
                            <a href="{{ route('login') }}"><i class="bi bi-person"></i></a>
                        @endif

                        <a href="{{ route('cartProduct') }}">
                            <i class="bi bi-bag-check-fill"></i>
                            <span class="cart-badge">{{ $count }}</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    {{-- Hero Slider --}}
    <div class="hero_area">
        <section class="slider_section">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="detail-box" data-aos="fade-right">
                                        <h1>Premium <br> Accessories</h1>
                                        <p>Experience the next level of automotive excellence with our curated hardware.</p>
                                        <a href="contact.html" class="btn-main">Explore Now</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="slider_img-box" data-aos="zoom-in">
                                        <img src="{{ asset('front-end/images/image3.jpeg') }}" alt="Car Accessory">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="detail-box">
                                        <h1>Luxury <br> Interiors</h1>
                                        <p>Crafted for comfort, designed for the bold. Elevate your cockpit today.</p>
                                        <a href="shop.html" class="btn-main">Shop Collection</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="slider_img-box">
                                        <img src="{{ asset('front-end/images/image3.jpeg') }}" alt="Car Accessory">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </section>
    </div>

    {{-- Main Content Section --}}
    <section class="shop_section">
        @yield('index')
        @yield('product_detail')
        @yield('content')
        @yield('viewcart_product')
    </section>

    {{-- Info Section --}}
    <section class="info_section d-flex">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-3">
                    <h6>About Us</h6>
                    <p>HengHor Car Accessories provides top-tier modifications for car enthusiasts who demand quality and style.</p>
                </div>
                <div class="col-md-3">
                    <h6>Need Help</h6>
                    <p>Our experts are available 24/7 to help you choose the right accessories for your vehicle.</p>
                </div>
                <div class="col-md-3">
                    <h6>Contact Us</h6>
                    <div class="info_link-box d-flex flex-column gap-2">
                        <a href="#" class="text-white text-decoration-none"><i class="bi bi-geo-alt-fill"></i><span> Phnom Penh, Cambodia</span></a>
                        <a href="#" class="text-white text-decoration-none"><i class="bi bi-telephone-fill"></i><span> +070 413424</span></a>
                        <a href="#" class="text-white text-decoration-none"><i class="bi bi-envelope-fill"></i><span> maosoranith346@gmail.com</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="footer_section">
        <div class="container">
            <p>© HengHor Car Accessories</p>
        </div>
    </footer>

    {{-- JS Libraries --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="{{ asset('front-end/js/jquery-3.4.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- CSRF setup --}}
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
    </script>

    {{-- Swiper & AOS Init --}}
    <script>
        AOS.init({ duration: 1000, once: true });

        var swiper = new Swiper(".mySwiper", {
            loop: true,
            effect: "fade",
            fadeEffect: { crossFade: true },
            speed: 1000,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: ".swiper-pagination", clickable: true },
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        });
    </script>

    @stack('scripts')
    @yield('scripts')
</body>
</html>