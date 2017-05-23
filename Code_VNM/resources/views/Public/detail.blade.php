@extends('layouts.public-layout')

@section('detail-drink')
<div class="product-details"><!--product-details-->
    <input type="hidden" id="txtDrinkId" value="{!!$drinks[0]->id!!}">
    <input type="hidden" id="txtDrinkName" value="{!!$drinks[0]->name!!}">
    <input type="hidden" id="txtPrice" value="{!!$drinks[0]->price!!}">
    <input type="hidden" id="image1" value="{!!$drinks[0]->image1!!}">
    <input type="hidden" id="crsf_token_form" name="_token" value="{!! csrf_token() !!}">
    <div class="col-sm-5">
        <div id="similar-product" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <a href=""><img src="{!!asset('storage/images/drinks/'.$drinks[0]->image1)!!}" alt=""></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-7" style="margin-left: 0px; padding: 0">
        <div class="product-information"><!--/product-information-->
            <h2>{!!$drinks[0]->name!!}</h2>
            <span>
                <span id="spanTotal">{!!number_format($drinks[0]->price,'0','',',').' VND'!!}</span>
                <label>Quantity:</label>
                <input type="text" id="txtQuantity" />
                <button type="button" class="btn btn-fefault cart" id="addDrinkToCart">
                    <i class="fa fa-shopping-cart"></i>
                    Mua
                </button>
            </span>
            <label class="label-err" id="lblQuantityErr"></label>
            <p><b>Availability:</b> In Stock</p>
            
        </div><!--/product-information-->
    </div>
</div><!--/product-details-->

<div class="dim"></div>

<div class="noti-dialog" id="noti-add-bill">
    <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center">
            <h3 class="panel-title">THÔNG BÁO</h3>
        </div>
        <div class="panel-body" style="padding: 0px">
            <div class="col-lg-12" id="div-loading-image" style="text-align: center; display: none">
                <img style="width: 150px; height: 100px;" src="{!!asset('/images/Loading_icon.gif')!!}">
            </div>
            <div class="row row-input"><label id="lblNotiContent"></label></div>
            <div id="div-button" class="row row-input" style="text-align: center; display: block">
                <button type="button" id="btnNotiOk" class="btn btn-primary btn-custom">Đóng</button>
            </div>
        </div>
    </div>
</div>
@endsection