@extends('layouts.user')

@section('title', 'Home')

@section('contents')
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Yoga Studio Template">
    <meta name="keywords" content="Yoga, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<style>
    .btn {
        background-color: #A9B388;
        color: #FEFAE0;
    }
    .btn.hover {
        background-color: #FEFAE0;
        color: #A9B388;
    }
    .add-to-cart-btn {
        display: block;
        margin: auto;
    }
    /* .shadow-sm {
        background-color: #5F6F52;
    } */
    .primary-btn:hover {
        background-color: #FEFAE0; 
        color: #5F6F52;
    }
    .features-ads .single-features-ads {
    padding: 30px;
    border: 1px solid #ebebeb;
    text-align: center; /* Center align content */
}

.features-ads .single-features-ads h4 {
    font-size: 24px;
    color: #333;
    margin-bottom: 15px;
}

.features-ads .single-features-ads p {
    font-size: 16px;
    color: #777;
    line-height: 1.7;
    text-align: justify;
}
</style>

<body style="background-color: #FEFAE0;">
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    
    <!-- Search model -->
	<div class="search-model">
		<div class="h-100 d-flex align-items-center justify-content-center">
			<div class="search-close-switch">+</div>
			<form class="search-model-form">
				<input type="text" id="search-input" placeholder="Search here">
			</form>
		</div>
	</div>
	<!-- Search model end -->

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="container-fluid">
            <div class="inner-header">
                <div class="logo">
                    <a href=""><img src="img/VINTHRI.png" width=150 height=150 alt=""></a>
                </div>
                <div class="header-right">
                    <img src="img/icons/search.png" alt="" class="search-trigger" style="margin-right: 5px;">
                    <a href="{{ url('/home') }}"> <img src="img/icons/man.png" alt="" style="margin-right: 5px;"> </a>
                    <a href="{{ url('/home') }}">
                        <img src="img/icons/bag.png" alt="">
                        <!-- <span>2</span> -->
                    </a>
                </div>
                <!-- <div class="user-access">
                    <a href="#">Register</a>
                    <a href="#" class="in">Sign in</a>
                </div> -->
                <nav class="main-menu mobile-menu">
                    <ul>
                        <li><a class="active" href="">Home</a></li>
                        <li><a href="{{url('/shop')}}">Shop</a>
                            <!-- <ul class="sub-menu">
                                <li><a href="">Tops/ Shirts</a></li>
                                <li><a href="">Bags</a></li>
                                <li><a href="">Short/ Pants</a></li>
                            </ul> -->
                        </li>
                        <li><a href="./product-page.html">Reviews</a></li>
                        <li><a href="./check-out.html">About</a></li>
                    </ul>
                </nav>
            </div>
    </header>
    <!-- Header End -->

    <!-- Hero Slider Begin -->
    <section class="hero-slider">
            <div class="single-slider-item set-bg" data-setbg="img/home_slider.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1>VINTAGE</h1>
                            <h2>Thrift.</h2>
                            <a href="#" class="primary-btn">See More</a>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <section class="features-section spad">
    <div class="container"> <!-- Added container -->
        <div class="features-ads">
            <div class="row justify-content-center"> <!-- Center align row -->
                <div class="col-lg-8">
                    <div class="single-features-ads first">
                        <h4 class="text-center">WALA AKO MAISIP</h4> <!-- Center align heading -->
                        <p class="text-justify"> <!-- Justify text -->
                            Fusce urna quam, euismod sit amet mollis quis, vestibulum quis velit. Vestibulum malesuada aliquet libero viverra cursus.
                            Fusce urna quam, euismod sit amet mollis quis, vestibulum quis velit. Vestibulum malesuada aliquet libero viverra cursus.
                            Fusce urna quam, euismod sit amet mollis quis, vestibulum quis velit. Vestibulum malesuada aliquet libero viverra cursus.
                            Fusce urna quam, euismod sit amet mollis quis, vestibulum quis velit. Vestibulum malesuada aliquet libero viverra cursus.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Hero Slider End -->
    <section class="latest-products spad">
        <div class="container">
            <div class="product-filter">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="section-title">
                            <h2 style="color: #5F6F52;">PRODUCTS</h2>
                        </div>
                    </div>
                </div>

<div class="single-product-item">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($inventories as $inventory)
                <div class="overflow-hidden shadow-sm sm:rounded-lg" width="500px" height="350">
                    <div class="p-6" style="background-color: #FEFAE0;">
                        <div class="mt-2">
                            @php
                            $images = explode(',', $inventory->product->images);
                            @endphp
                            @foreach ($images as $image)
                            <img src="/productImages/{{ $image }}" width="200px" style="margin-right: 20px;">
                            @endforeach
                        </div>
                        <div class="flex justify-center items-center">
                            <h6 class="product-text mt-2 font-weight-bold" style="color: #5F6F52; text-align: center;">{{ $inventory->product->name }}</h6>
                        </div>
                        <div class="flex justify-center items-center">
                            <p class="product-text" style="color: #B99470; text-align: center;">₱{{ $inventory->product->unit_price }}</p>
                        </div>

                        <div>
                        @if($inventory->stock == 0)
                            <p class="text-danger text-center">Out of Stock</p>
                        @else
                            <p class="text-success text-center">In Stock</p>
                        @endif
                        </div>
                        <a href="{{ route('cart.show_add_form', ['productId' => $inventory->product_id]) }}" class="primary-btn pc-btn add-to-cart-btn text-center" style="background-color: #A9B388;">Add to Cart</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
</section>
    <!-- Latest Product End -->

    <!-- Footer Section Begin -->
    <footer>
    <div class="social-links-warp text-center pt-5">
        <p style="color: #FEFAE0;"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved.
        </p>
    </div>
 
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/main.js"></script>
</body>
</main>
@endsection