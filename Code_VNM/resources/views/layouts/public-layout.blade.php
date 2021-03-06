<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Home | E-Shopper</title>
        <link href="{!!asset('vendors/bootstrap/dist/css/bootstrap.min.css')!!}" rel="stylesheet">
        <link href="{!!asset('css/jquery-ui.css') !!}" rel="stylesheet">
        <link href="{!!asset('vendors/font-awesome/css/font-awesome.min.css')!!}" rel="stylesheet">
        <link href="{!!asset('css/prettyPhoto.css')!!}" rel="stylesheet">
        <link href="{!!asset('css/animate.css')!!}" rel="stylesheet">
        <link href="{!!asset('css/main.css')!!}" rel="stylesheet">
        <link href="{!!asset('css/responsive.css')!!}" rel="stylesheet">
        
        
        
    </head><!--/head-->

    <body>
        <header id="header"><!--header-->
            <input type="hidden" id="crsf_token_form" value="{{ csrf_token() }}"/>
            <div class="header-middle"><!--header-middle-->
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="logo pull-left">
                                <a href="{!!url('/home')!!}"><img src="{!!asset('images/logo-hc-min.jpg')!!}" alt="Home" /></a>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="col-sm-3">

                            </div>
                            <div class="shop-menu pull-right">
                                <ul class="nav navbar-nav">
                                    <li>
                                        <form id="frmSearch" method="GET" action="/search">
                                        <div class="search_box pull-right">
                                            <input type="text" class="form-control" name="key" id="txtSearchKey" placeholder="Search">
                                        </div>
                                            </form>
                                    </li>
                                    <li><a href="#"><i class="fa fa-star"></i> Liên hệ</a></li>
                                    <li><a href="{!!url('/cart')!!}"><i class="fa fa-shopping-cart"></i> Giỏ hàng
                                            @if($cartQuantity != 0)
                                            {!!'('.$cartQuantity.')'!!}
                                            @endif
                                        </a></li>
                                    <li><a href="{!!url('/login')!!}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/header-middle-->

        </header><!--/header-->

        @yield('slideview')

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="left-sidebar">
                            <h2>Thực đơn</h2>
                            <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                                @foreach($categories as $category)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><a href="{!!url('/category/'.$category->id)!!}">{!!$category->name!!}</a></h4>
                                    </div>
                                </div>
                                @endforeach
                            </div><!--/category-products-->

                            <div class="shipping text-center"><!--shipping-->
                                <img src="{!!asset('images/left-banner.jpg')!!}" alt="" />
                            </div><!--/shipping-->

                        </div>
                    </div>

                    <div class="col-sm-9 padding-right">
                        @yield('detail-drink')
                        @yield('feature-item')
                        @yield('cart')
                        <div class="features_items" style="text-align: center">
                            @yield('pagination')
                        </div>
                    </div><!--features_items-->

                    <div class="category-tab"><!--category-tab-->
                        <div class="tab-content">
                        </div>
                    </div><!--/category-tab-->
                </div>
            </div>
        </div>
    </section>

    <footer id="footer"><!--Footer-->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="companyinfo">
                            <h2><span>e</span>-shopper</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="images/home/iframe1.png" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="images/home/iframe2.png" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="images/home/iframe3.png" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="images/home/iframe4.png" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="address">
                            <img src="images/home/map.png" alt="" />
                            <p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-widget">
            <div class="container">

            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
                    <p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>
                </div>
            </div>
        </div>

    </footer><!--/Footer-->

    

    <script src="{!!asset('vendors/jquery/dist/jquery.min.js')!!}"></script>
    <script src="{!!asset('vendors/bootstrap/dist/js/bootstrap.min.js')!!}"></script>
    <script src="{!!asset('js/jquery.scrollUp.min.js')!!}"></script>
    <script src="{!!asset('js/jquery-ui.min.js')!!}"></script>
    <!--<script src="js/price-range.js"></script>-->
    <script src="{!!asset('js/jquery.prettyPhoto.js')!!}"></script>
    <script src="{!!asset('js/hc.js')!!}"></script>
    
    <script type="text/javascript" language="JavaScript">
    $('#txtSearchKey').keyup(function () {
        var arr = [];
        if ($('#txtSearchKey').val() !== "") {
            $.ajax({
                url: "{!!url('/search-key')!!}"  + '/' + $(this).val(),
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    var i = 0;
                    if(data.length > 0){
                        $.each(data, function (index, value) {
                        if(i < 5){
                            arr[index] = value["name"];
                            i++;
                        }

                    });
                    }
                    
                    $('#txtSearchKey').autocomplete({
                        source: arr,
                        select: function(event, ui) {
                            $('#txtSearchKey').val(ui.item.label);
                            $('form#frmSearch').submit();
                        }
                    });
                },
                error: function () {
                }
            });
        }
    });

</script>
    
</body>
</html>