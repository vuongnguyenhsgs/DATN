@extends('layouts.admin-layout')

@section('page-title','Sửa thông tin hóa đơn')

@section('page-name','Sửa thông tin hóa đơn')

@section('page-content')
<script type="text/javascript">
    $(document).ready(function () {
        $('.combobox-select2').select2();
    });
</script>
<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="x_panel">
        <div class="x_content">
            <form action="/Admin/materials/add" method="POST" id="frmAddNewMaterial">
                <input type="hidden" id="crsf_token_form" name="_token" value="{!! csrf_token() !!}">
                <input type="hidden" id="bill-detail" value="">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="row" style="text-align: center">
                            <h3>Thông tin hóa đơn</h3>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-4">
                                <label>Tên khách hàng</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="txtCustomerName" class="form-control" value="{!!$bills[0]->customer_name!!}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-4">
                                <label>Số điện thoại</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="txtPhone" class="form-control" value="{!!$bills[0]->customer_phone!!}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-4">
                                <label>Địa chỉ</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" id="txtAddress" class="form-control" value="{!!$bills[0]->customer_address!!}">
                            </div>
                        </div>
                        <div class="row form-group"><div class="col-lg-4"></div><div class="col-lg-8"><label class="label-err" id="lblErrAddBill"></label></div></div>
                        <div class="row form-group" style="text-align: center">
                            <button type="button" id="btnAddBillOk" class="btn btn-primary">Lưu</button>
                            <button type="button" id="btnAddBillCancel" class="btn btn-primary">Hủy</button>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-6">
                        <div class="row" style="text-align: center">
                            <h3>Chi tiết hóa đơn</h3>
                        </div>
                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                <th>Tên món</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                                <th>Tùy chọn</th>
                                </thead>
                                <tbody id="tblDetailBill">
                                    @foreach($billDetails as $billDetail)
                                    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <label>Tổng tiền: </label>
                            <label id="lblTotal"></label>
                        </div>
                        <div class="row">
                            <button type="button" class="btn btn-primary" id="btnAddToBill">Thêm món</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="dim"></div>

<div class="noti-dialog" id="noti-add-bill">
    <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center">
            <h3 class="panel-title">THÔNG BÁO</h3>
        </div>
        <div class="panel-body" style="padding: 0px">
            <div class="col-lg-12" id="div-loading-image" style="text-align: center; display: none">
                <img style="width: 150px; height: 100px;" src="/images/Loading_icon.gif">
            </div>
            <div class="row row-input"><label id="lblNotiContent"></label></div>
            <div id="div-button" class="row row-input" style="text-align: center; display: block">
                <button type="button" id="btnNotiOk" class="btn btn-primary btn-custom">Đóng</button>
            </div>
        </div>
    </div>
</div>

<div class="box" id="popAddToBill">
    <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center">
            <h3 class="panel-title">THÊM ĐỒ UỐNG</h3>
        </div>
        <div class="panel-body" style="padding: 0px">
            <div class="row row-input"><label class="label-err" id="errAddToBill"></label></div>
            <div class="row row-input">
                <div class="col-lg-3"><label>Tên món</label></div>
                <div class="col-lg-8">
                    <select id="cobDrinkToBill" class="combobox-select2 form-control" style="width: 100%">
                        @foreach($drinks as $drink)
                        <option value="{!!$drink->id.'-'.$drink->price!!}">{!!$drink->name!!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row row-input">
                <div class="col-lg-3"><label>Số lượng</label></div>
                <div class="col-lg-8">
                    <input type="text" id="txtQuantity" class="form-control">
                </div>
            </div>
            <div class="row row-input" style="text-align: center">
                <button type="button" id="btnAddToBillOk" class="btn btn-primary btn-custom">OK</button>
                <button type="button" id="btnAddToBillCancel" class="btn btn-primary btn-custom">Hủy</button>
            </div>
        </div>
    </div>
</div>
@endsection