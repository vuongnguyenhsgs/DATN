@extends('layouts.public-layout')

@section('slideview')
<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>

                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="col-lg-12">
                                <img src="{!!asset('images/banner2.jpg')!!}">
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-lg-12">
                                <img src="{!!asset('images/banner1.jpg')!!}">
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-lg-12">
                                <img src="{!!asset('images/banner3.jpg')!!}">
                            </div>
                        </div>

                    </div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section><!--/slider-->
@endsection

@section('feature-item')
<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Features Items</h2>
    @foreach($drinks as $drink)
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-center">
                    <img src="{!!asset('storage/images/drinks/'.$drink->image1)!!}" style="width: 150px; height: 150px;" alt="" />
                    <h2>{!!number_format($drink->price,'0','',',')!!}</h2>
                    <p>{!!$drink->name!!}</p>
                    <a href="{!!url('/drink/detail/'.$drink->id)!!}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
    @endsection

    @section('pagination')
    {!!$drinks->links()!!}
    @endsection