@extends('layouts.public-layout')

@section('cart')
<style>
    td{
        text-align: center;
    }
</style>
<input type="hidden" id="crsf_token_form" name="_token" value="{!! csrf_token() !!}">
<input type="hidden" id="billDetail">
<div class="row">
    <div class="table cart_info" style="margin-top: 30px; text-align: center">
        <table class="table table-condensed">
            <thead>
                <tr class="cart_menu" style="background: #FE980F">
                    <td class="image">Tên món</td>
                    <td class="description" style="text-align: left"></td>
                    <td class="price">Đơn giá</td>
                    <td class="quantity">Số lượng</td>
                    <td class="total">Thành tiền</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $cartItem)
                <tr id="{!!$cartItem->id!!}" class="cart-item">
                    <td class="cart_product">
                        <a href=""><img src="{!!asset('storage/images/drinks/'.$cartItem->attributes['image1'])!!}" alt=""
                                        style="width: 150px; height: 100px"></a>
                    </td>
                    <td class="cart_description">
                        <h4><a href="{!!url('/drink/detail/'.$cartItem->id)!!}">{!!$cartItem->name!!}</a></h4>
                    </td>
                    <td class="cart_price">
                        <p>{!!number_format($cartItem->price,'0','',',')!!}</p>
                    </td>
                    <td class="cart_quantity">
                        <div class="cart_quantity_button" style="padding-left: 70px">
                            <input class="cart_quantity_input number-input" type="text" value="{!!$cartItem->quantity!!}" size="3">
                        </div>
                    </td>
                    <td class="cart_total">
                        <p class="cart_total_price">{!!number_format(($cartItem->price * $cartItem->quantity),'0','',',')!!}</p>
                    </td>
                    <td class="cart_delete">
                        <button type="button" class="btn btn-primary cart_delete_item"
                                value="{!!$cartItem->id!!}"><i class="fa fa-times"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
<div class="row">
    <div class="col-lg-8"></div>
    <div class="col-lg-4">
        <label>Tổng tiền: </label>
        <label id="lblTotal">{!!number_format(Cart::getTotal(),'0','',',').' VND'!!}</label>
    </div>
</div>
<div class="row">
    <label class="label-err" id="lblErrCheckCart"></label>
</div>
<div class="row">
    <div class="row row-input" style="text-align: center">
        <button type="button" id="btnCheckout" class="btn btn-primary">Mua hàng</button>
        <button type="button" id="btnSaveCart" class="btn btn-primary">Lưu giỏ hàng</button>
    </div>
</div>

<div class="dim"></div>

<div class="confirm-dialog" id="confirm-remove-from-cart">
    <div class="panel panel-info">
        <input type="hidden" id="deletedId">
        <div class="panel-heading" style="text-align: center">
            <h3 class="panel-title">Xác nhận xóa</h3>
        </div>
        <div class="panel-body" style="padding: 0px">
            <div class="row row-input"><label>Bạn có chắc muốn hủy mua sản phẩm này?</label></div>
            <div class="row row-input" style="text-align: center">
                <button type="button" id="btnRemoveCartOk" class="btn btn-primary btn-custom">OK</button>
                <button type="button" id="btnRemoveCartCancel" class="btn btn-primary btn-custom">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div class="box" id="checkout-dialog">
    <div class="col-lg-12">
        <div class="row" style="text-align: center">
            <h3>Thông tin hóa đơn</h3>
        </div>
        <div class="row form-group">
            <div class="col-lg-4" style="text-align: left">
                <label>Tên khách hàng</label>
            </div>
            <div class="col-lg-8">
                <input type="text" id="txtCustomerName" class="form-control">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-4" style="text-align: left">
                <label>Số điện thoại</label>
            </div>
            <div class="col-lg-8">
                <input type="text" id="txtPhone" class="form-control">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-4" style="text-align: left">
                <label>Địa chỉ</label>
            </div>
            <div class="col-lg-8">
                <input type="text" id="txtAddress" class="form-control">
            </div>
        </div>
        <div class="row form-group"><div class="col-lg-4"></div><div class="col-lg-8"><label class="label-err hidden" id="lblErr">Vui lòng nhập đủ thông tin để chúng tôi có thể giao hàng tới tận tay bạn sớm nhất</label></div></div>
        <div class="row form-group" style="text-align: center">
            <button type="button" id="btnCheckoutOk" class="btn btn-primary">Lưu</button>
            <button type="button" id="btnCheckoutCancel" class="btn btn-primary">Hủy</button>
        </div>
    </div>
</div>

<div class="noti-dialog">
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