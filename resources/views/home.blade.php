<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>bvend</title>
    <!-- Font Awesome Icons -->
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic'
        rel='stylesheet' type='text/css'>
    <!-- Plugin CSS -->
    <link href="{{asset('vendor/magnific-popup/magnific-popup.css')}}" rel="stylesheet">
    <!-- Theme CSS - Includes Bootstrap -->
    <link href="{{asset('css/creative.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <style type="text/css">
        * {
            font-family: 'Ubuntu';
        }

        .bvend_color {
            color: #007E33;
        }

        header.masthead {
            background: url('img/bvend_bg.jpg') no-repeat;
            background-size: cover;
        }

        .findoutbutton,
        .about {
            background-color: #999 !important;
        }

        .about {
            background-color: #007E33 !important;
        }

        #mainNav .navbar-nav .nav-item .nav-link {
            color: #007E33;
        }

        #mainNav.navbar-scrolled .navbar-nav .nav-item .nav-link.active {
            color: #007E33 !important;
        }

        .nav-link:hover {
            color: #007E33 !important;
        }

        .bg-bvend {}

        .divider {
            border-color: #007E33 !important;
        }

        .d-block {
            color: #000;
        }

        button:focus,
        button:active {
            outline: none !important;
            box-shadow: none;
        }

        .frame iframe {

            width: 48%;

        }

        @media only screen and (max-width: 600px) {
            .frame iframe {
                display: block;
                width: 70%;
                margin-top: 15px;
            }
        }
    </style>
</head>

<body id="page-top">
    <!-- Navigation -->
    <!-- <div class="links" style="margin-top: 50px">
            <a href="admin/login">Admin</a>
            <a href="manager/login">Manager</a>
            <a href="vendor/login">Vendor</a>
            <a href="user/send">User</a>
        </div>
 -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 navbar-toggleable-md" id="mainNav">
        <div class="container">
            <!-- <a class="navbar-brand js-scroll-trigger" href="#page-top">Start Bootstrap</a> -->
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <img style="width: 100px;" class="img-fluid" src="{{asset('img/bvend_web_logo.png')}}" alt="">
            </a>
            <button class="navbar-toggler mt-2" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse  justify-content-end" id="navbarResponsive">
                <ul class="navbar-nav ml-auto my-2 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#services">Bvend</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#portfolio">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead -->
    <header class="masthead">
        <div class="container h-100 bg-bvend">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-10 align-self-end">
                    <h1 class="text-uppercase text-white  font-weight-bold">the first smart vending machine of
                        bangladesh</h1>
                    <hr class="divider my-4">
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <!-- <p class="font-weight-ligh text-white mb-5">Bvend - A startup company introducing smart and cashless vending solution</p> -->
                    <h2 class="text-uppercase text-white mb-5">#made in bangladesh</h2>
                    <a class="btn btn-primary btn-xl js-scroll-trigger findoutbutton" href="#about">Find Out More</a>
                </div>
            </div>
        </div>
    </header>
    <!-- Video Section -->

    <section class="page-section">
        <div class="container">
            <center class='mb-4'>
                <a href="https://play.google.com/store/apps/details?id=com.bvend"> <img
                        src="{{asset('img/play_store.png')}}" alt="play store" width=300 height=120 /> </a>
            </center>
            <div class="frame" align="center">
                <iframe height="400" class="embed-responsive-item" src="https://www.youtube.com/embed/UejostH6xwg"
                    allowfullscreen></iframe>
                <iframe height="400" class="embed-responsive-item" src="https://www.youtube.com/embed/OD6HTeafzM4"
                    allowfullscreen></iframe>
            </div>
        </div>
    </section>
    <!-- Video Section -->
    <!-- About Section -->
    <section class="page-section bg-primary about" id="about">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-white mt-0  text-center">About Bvend</h2>
                    <hr class="divider light my-4">
                    <p class="text-white mb-4  text-justify">
                        Bvend Technologies Limited is the first smart vending solution startup company in Bangladesh,
                        started in February 2019. It recognized the nearby quality products demand and tremendous
                        potentiality of vending business in Bangladesh. Bvend team is promised to make vending with 50%
                        low cost using local materials, customize hardware, software technology and produce affordable
                        vending in Bangladesh. This is the first company who has introduced mobile payment and cashless
                        vending solution in Bangladesh.
                    </p>
                    <!-- <a class="btn btn-light btn-xl js-scroll-trigger" href="#services">Get Started!</a> -->
                </div>
            </div>
        </div>
    </section>


    <!-- Services Section -->
    <section class="page-section" id="services">
        <div class="container">
            <h2 class="text-center mt-0">How Bvend Works</h2>
            <hr class="divider my-4">
            <div class="row justify-content-center">
                <div class="col-sm-10 p-2">
                    <img class="img-fluid" src="{{asset('img/bg.png')}}" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- Portfolio Section -->
    <section id="portfolio" class="bg-light pt-5 pb-5">
        <h2 class="text-center">Gallery</h2>
        <hr class="divider my-4">

        <div class="col-lg-10 col-sm-10 container p-0">
            <div class="row no-gutters">
                <div class="col-sm-4 p-2">
                    <a class="portfolio-box" href="{{asset('img/gallery_1.jpg')}}">
                        <img class="img-fluid" src="{{asset('img/gallery_1.jpg')}}" alt="">
                        <!-- <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div> -->
                    </a>
                </div>
                <div class="col-lg-4 p-2">
                    <a class="portfolio-box" href="{{asset('img/gallery_2.jpg')}}">
                        <img class="img-fluid" src="{{asset('img/gallery_2.jpg')}}" alt="">
                        <!-- 
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div> -->
                    </a>
                </div>
                <div class="col-lg-4 p-2">
                    <a class="portfolio-box" href="{{asset('img/gallery_7.jpg')}}">
                        <img class="img-fluid" src="{{asset('img/gallery_7.jpg')}}" alt="">
                        <!-- 
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div> -->
                    </a>
                </div>


                <div class="col-lg-4 p-2">
                    <a class="portfolio-box" href="{{asset('img/gallery_5.jpg')}}">
                        <img class="img-fluid" src="{{asset('img/gallery_5.jpg')}}" alt="">
                        <!-- <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div> -->
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6  p-2">
                    <a class="portfolio-box" href="{{asset('img/gallery_3.jpg')}}">
                        <img class="img-fluid" src="{{asset('img/gallery_3.jpg')}}" alt="">
                        <!-- <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div> -->
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6  p-2">
                    <a class="portfolio-box" href="{{asset('img/gallery_4.jpg')}}">
                        <img class="img-fluid" src="{{asset('img/gallery_4.jpg')}}" alt="">
                        <!-- <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div> -->
                    </a>
                </div>

                <!-- <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="img/portfolio/fullsize/6.jpg">
                            <img class="img-fluid" src="img/portfolio/thumbnails/6.jpg" alt="">
                            <div class="portfolio-box-caption p-3">
                                <div class="project-category text-white-50">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div>
                        </a>
                    </div> -->
            </div>
        </div>
    </section>
    <!-- Call to Action Section -->
    <!-- <section class="page-section bg-dark text-white">
            <div class="container text-center">
                <h2 class="mb-4">Free Download at Start Bootstrap!</h2>
                <a class="btn btn-light btn-xl" href="https://startbootstrap.com/themes/creative/">Download Now!</a>
            </div>
        </section> -->
    <!-- Contact Section -->
    <section class="page-section bg-dark" id="contact">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    <h2 class="mt-0 text-white">Let's Get In Touch!</h2>
                    <hr class="divider my-4">
                    <p class="mb-5 text-white">Any questions? call or send us an email and we will get back to you as
                        soon as possible!</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6  text-center mb-5 mb-lg-0">
                    <i class="fas fa-phone fa-3x mb-3 bvend_color"></i>
                    <div class="text-white">+880 1913 663 370</div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="fas fa-envelope fa-3x mb-3 bvend_color"></i>
                    <!-- Make sure to change the email address in anchor text AND the link below! -->
                    <a class="d-block text-white" href="mailto:info@bvend.xyz">info@bvend.xyz</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="small text-center">Copyright &copy; 2023 - Bvend Technologies Ltd.</div>
        </div>
    </footer>
    <!-- Bootstrap core JavaScript -->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Plugin JavaScript -->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('vendor/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <!-- Custom scripts for this template -->
    <script src="{{asset('js/creative.min.js')}}"></script>
</body>

</html>