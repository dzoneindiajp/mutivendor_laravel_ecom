<!-- footer area start -->
<footer>
    <!-- footer widget area start -->
    <div class="footer-widget-area pt-62 pb-56 pb-md-26 pt-sm-56 pb-sm-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="footer-widget">
                        <div class="footer-widget-title">
                            <div class="footer-logo">
                                @php
                                 $LOGO_icon = Config('constant.SETTINGS_IMAGE_URL').Config('Site.logo');
                                @endphp
                                <a href="index.html">
                                    <img src="{{$LOGO_icon}}" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="footer-widget-body">
                            {{-- <p>Here you can read some details about a nifty little lifecycle of your order's journey
                                from the time you place your order to your new treasures arriving at your doorstep.</p> --}}
                            <p>{{Config("Homepage.about_footer")}}</p>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="footer-widget">
                        <div class="footer-widget-title">
                            <h3>Quick link</h3>
                        </div>
                        <div class="footer-widget-body">
                            <ul class="useful-link">
                                <li><a href="#">Home</a></li>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Shop</a></li>
                                <li><a href="#">Categories</a></li>
                                <li><a href="#">Privacy policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="footer-widget">
                        <div class="footer-widget-title">
                            <h3>Reach Us</h3>
                        </div>
                        <div class="footer-widget-body">
                            <ul class="address-box">
                                <li>
                                    <p><i class="{{Config("Contact.mail_icon")}} color-yellow"></i>{{Config("Contact.contact_email")}}</p>
                                </li>
                                <li>
                                    <p><i class="{{Config("Contact.phone_icon")}} color-yellow"></i> {{Config("Contact.contact_number")}}</p>
                                </li>
                                <li>
                                    <p>
                                        <i class="{{Config("Contact.address_icon")}} color-yellow"></i> {{Config("Contact.address")}}
                                    </p>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="footer-widget">
                        <div class="footer-widget-title">
                            <h3>Stay In The Known</h3>
                        </div>
                        <p>To get our fantabulous updates & offers straight to your inbox!</p>
                        <div class="newsletter-inner">

                            <div class="newsletter-box">
                                <form id="mc-form">
                                    <input type="email" id="mc-email" autocomplete="off"
                                        placeholder="Your Email address">
                                    <button class="newsletter-btn" id="mc-submit"><i
                                            class="fa fa-paper-plane"></i></button>
                                </form>
                            </div>
                        </div>
                        <br />
                        <div class="social-share-area mt-10">
                            <div class="social-icon">
                                <a href="{{Config("Social.facebook")}}"><i class="fa fa-facebook"></i></a>
                                <a href="{{Config("Social.twitter")}}"><i class="fa fa-twitter"></i></a>
                                <a href="{{Config("Social.youtube")}}"><i class="fa fa-youtube-play"></i></a>
                                <a href="{{Config("Social.instagram")}}"><i class="fa fa-instagram"></i></a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer widget area end -->
    <!-- footer botton area start -->
    <div class="footer-bottom-area">
        <div class="container">
            <div class="pb-18">
                <div class="row align-items-center">
                    <div class="col-md-8 order-2 order-md-1">
                        <div class="copyright-text">
                            <p>{{Config("Site.copyright")}}</p>

                        </div>
                    </div>
                    @php
                        $payment_icon = Config('constant.SETTINGS_IMAGE_URL').Config('Homepage.paymet_image');
                    @endphp
                    <div class="col-md-4 ms-auto order-1 order-md-2">
                        <div class="footer-payment">
                            <img src="{{$payment_icon}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer botton area end -->

</footer>
<!-- footer area end -->

<!-- Quick view modal start -->
<div class="modal fade" id="offer_popup" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <img src="{{asset('assets/front/img/offer/offer-1.jpg')}}" width="100%" />
            </div>
        </div>
    </div>
</div>
<!-- Scroll to top start -->
<div class="scroll-top not-visible">
    <i class="fa fa-angle-up"></i>
</div>

<div class="fix-whatsapp">
    <a href="#" target="_blank"><img src="{{asset('assets/front/img/whatsapp.png')}}"><span class="text-chat"> Chat with us ! </span></a>
</div>

<script src="{{ asset('assets/front/js/vendor/modernizr-3.6.0.min.js') }}"></script>

<script src="{{ asset('assets/front/js/vendor/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/front/js/plugins.js') }}"></script>
<script src="{{ asset('assets/front/js/main.js') }}"></script>
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>


<script src="{{ asset('assets/front/js/ajax_request.js') }}"></script>