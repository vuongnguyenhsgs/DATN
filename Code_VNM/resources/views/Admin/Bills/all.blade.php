@extends('layouts.admin-layout')

@section('page-name','Danh sách hóa đơn')

@section('page-content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-all-bill').DataTable({
            "language": {
                "lengthMenu": "Hiển thị _MENU_ bản ghi",
                "zeroRecords": "Không có bản ghi nào",
                "info": "Hiển thị bản ghi thứ _START_ tới _END_ trên _TOTAL_ bản ghi",
                "infoFiltered": "(Lọc từ _MAX_ bản ghi)",
                "search": ""
            }
        });
        $('.combobox-select2').select2();
        $('select#cobStatus > option[value="{!!$status!!}"]').attr('selected', 'true');
        $('input.input-datepicker').datepicker({
            dateFormat: 'dd/mm/yy'
        });
    });
</script>
<input type="hidden" value="{!!$status!!}" id="searchStatus">
<div class="x_panel">
    <div class="x_content">
        <form method="GET" id="frmSearchBill" action="{!!url('/Admin/bills/all')!!}">
            <div class="row col-lg-12">
                <div class="col-lg-4">
                    <div class="col-lg-4"><label>Loại hóa đơn</label></div>
                    <div class="col-lg-8">
                        <select class="form-control" id="cobStatus" name="status">
                            <option value="0">Đang chờ duyệt</option>
                            <option value="1">Đang chế biến (online)</option>
                            <option value="2">Chế biến xong (online)</option>
                            <option value="3">Đang giao hàng (online)</option>
                            <option value="4">Đã giao hàng (online)</option>
                            <option value="5">Chờ thanh toán</option>
                            <option value="6">Đã thanh toán</option>
                            <option value="7">Đã hủy</option>
                        </select>
                    </div>
                </div>
                <div class="row col-lg-1"></div>
                <div class="row col-lg-7">
                    <div class="row">
                        <div class="col-lg-2">
                            <label>Thời gian: </label>
                        </div>
                        <div class="col-lg-7">
                            <div class="col-lg-5">
                                @if($startDate == null)
                                <input class="form-control input-datepicker" name="txtStartDate" id="txtStartDate" style="width: 120px" >
                                @else
                                <input class="form-control input-datepicker" value="{!!date_format(new DateTime($startDate),'d/m/Y')!!}" style="width: 120px" name="txtStartDate" id="txtStartDate" >
                                @endif
                            </div>
                            <div class="col-lg-1" style="text-align: left">
                                <label>đến</label>
                            </div>
                            <div class="col-lg-5">
                                @if($endDate == null)
                                <input  class="form-control input-datepicker" name="txtEndDate" id="txtEndDate" style="width: 120px">
                                @else
                                <input class="form-control input-datepicker" value="{!!date_format(new DateTime($endDate),'d/m/Y')!!}" style="width: 120px" name="txtEndDate" id="txtEndDate" >
                                @endif

                            </div>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-info" id="btnSearchBill">Tìm kiếm</button>
                        </div>
                    </div>
                    <div class="row col-lg-12">
                        <label class="label-err" id="lblErrTimeFormat"></label>
                    </div>
                </div>
            </div>
        </form>
        <div class="row" style="margin-top: 0px">
            <input type="hidden" id="crsf_token_form" value="{{ csrf_token() }}"/>
            <a style="text-decoration: underline" href="#" id="linkStatistic">Thống kê</a>
            <table id="datatable-all-bill" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 70px">Mã hóa đơn</th>
                        <th>Tên khách hàng</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Tổng tiền</th>
                        <th>Ngày lập</th>
                        <th>Nhân viên</th>
                        @if($status != 7)
                        <th>Tùy chọn</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($bills as $bill)
                    <tr>
                        <td style="text-align: center" class="bill-id"><a href="#" class="details-bill" style="text-decoration: underline">{!!$bill->id!!}</a></td>
                        <td class="td-customer-name">{!!$bill->customer_name!!}</td>
                        <td class="td-customer-address">{!!$bill->customer_address!!}</td>
                        <td class="td-customer-phone">{!!$bill->customer_phone!!}</td>
                        <td style="text-align: right" class="td-bill-total">{!!number_format($bill->total,'0','',',')!!}</td>
                        <td style="text-align: center" class="td-created-at">{!!date_format(new DateTime($bill->created_at),'H:i:s d-m-Y')!!}</td>
                        <td>{!!$bill->fullname!!}</td>
                        <td style="text-align: center">
                            @if($status == 2)
                            <button class="btnShip" value="{!!$bill->id!!}"><a><i class="fa fa-remove"></i> Giao hàng </a></button>
                            @endif
                            @if($status == 4 || $status == 5)
                            <button class="btnGetMoney" value="{!!$bill->id!!}"><a><i class="fa fa-remove"></i> Thu tiền </a></button>
                            @endif
                            @if($status != 7)
                            <button class="btnDeleteBill" value="{!!$bill->id!!}"><a><i class="fa fa-remove"></i> Xóa </a></button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="dim"></div>

<div class="confirm-dialog" id="confirm-delete-bill">
    <div class="panel panel-info">
        <input type="hidden" id="deletedId" value="">
        <div class="panel-heading" style="text-align: center">
            <h3 class="panel-title">Xác nhận xóa</h3>
        </div>
        <div class="panel-body" style="padding: 0px">
            <div class="row row-input"><label>Bạn có chắc muốn xóa?</label></div>
            <div class="row row-input" style="text-align: center">
                <button type="button" id="btnDeleteBillOk" class="btn btn-info btn-custom">OK</button>
                <button type="button" id="btnDeleteBillCancel" class="btn btn-info btn-custom">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div class="confirm-dialog" id="confirm-change-bill">
    <div class="panel panel-info">
        <input type="hidden" id="billId" value="">
        <div class="panel-heading" style="text-align: center">
            <h3 class="panel-title">Xác nhận</h3>
        </div>
        <div class="panel-body" style="padding: 0px">
            <div class="row row-input"><label id="lblConfirmContent">Thanh toán và in hóa đơn?</label></div>
            <div class="row row-input" style="text-align: center">
                <button type="button" id="btnGetMoneyOk" class="btn btn-info btn-custom">OK</button>
                <button type="button" id="btnGetMoneyCancel" class="btn btn-info btn-custom">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div class="box" id="popShipper">
    <input type="hidden" id="billIdShip" value="">
    <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center">
            <h3 class="panel-title">Nhân viên giao hàng</h3>
        </div>
        <div class="panel-body" style="padding: 0px">
            <div class="row row-input">
                <div class="col-lg-1"></div>
                <div class="col-lg-3"><label>Tên nhân viên</label></div>
                <div class="col-lg-8" style="text-align: left">
                    <select id="cobShipper" class="combobox-select2 form-control" style="width: 250px">
                        @foreach($employees as $employee)
                        <option value="{!!$employee->id!!}">{!!$employee->fullname!!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row row-input" style="text-align: center">
                <button type="button" id="btnShipperOk" class="btn btn-primary btn-custom">OK</button>
                <button type="button" id="btnShipperCancel" class="btn btn-primary btn-custom">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div class="noti-dialog" id="noti-delete-bill">
    <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center">
            <h3 class="panel-title">THÔNG BÁO</h3>
        </div>
        <div class="panel-body" style="padding: 0px">
            <div class="col-lg-12" id="div-loading-image" style="text-align: center; display: none">
                <img style="width: 150px; height: 100px;" src="{!!asset('images/Loading_icon.gif')!!}">
            </div>
            <div class="row row-input"><label id="lblNotiContent"></label></div>
            <div class="row row-input" style="text-align: center">
                <button type="button" id="btnNotiOk" class="btn btn-primary btn-custom">Đóng</button>
            </div>
        </div>
    </div>
</div>

<div class="box2 statistic-page" id="view-bill-detail-online">
    <input type="hidden" id="billIdDetail" value="">
    <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center">
            <h3 class="panel-title">HÓA ĐƠN</h3>
        </div>
        <div class="panel-body" style="padding: 0px">
            <div class="col-sm-12" id="div-loading-image" style="text-align: center; display: none">
                <img style="width: 150px; height: 100px;" src="{!!asset('/images/Loading_icon.gif')!!}">
            </div>
            <div class="row row-input"><label id="lblNotiContent"></label></div>
            <div class="row" id="bill-detail-content" style="display: none">
                <div class="row" style="text-align: center">
                    <label id="lblBillId"></label>
                </div>
                <div class="col-sm-12 row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-3" style="text-align: left"><label>Tên khách hàng:</label></div>
                    <div class="col-sm-6" style="text-align: left"><label id="lblCustomerName"></label></div>
                </div>
                <div class="col-sm-12 row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-3" style="text-align: left"><label>Địa chỉ:</label></div>
                    <div class="col-sm-6" style="text-align: left"><label id="lblCustomerAddress"></label></div>
                </div>
                <div class="col-sm-12 row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-3" style="text-align: left"><label>Số điện thoại:</label></div>
                    <div class="col-sm-6" style="text-align: left"><label id="lblCustomerPhone"></label></div>
                </div>
                <div class="col-sm-12 row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-3" style="text-align: left"><label>Ngày lập:</label></div>
                    <div class="col-sm-6" style="text-align: left"><label id="lblCreatedAt"></label></div>
                </div>
                <div class="col-sm-12 row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-3" style="text-align: left"><label>Tổng tiền:</label></div>
                    <div class="col-sm-6" style="text-align: left"><label id="lblTotal"></label></div>
                </div>
                <div class="col-sm-12" style="text-align: center; margin-top: 20px">
                    <table class="table table-bordered">
                        <thead>
                        <th>Tên hàng</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                        </thead>
                        <tbody id="tblDetailBillOnline">
                        </tbody>
                    </table>
                </div>
                
                <div class="row row-input" style="text-align: center">
                    <button class="btn btn-info" type="button" id="btnPrint" style="width: 80px">In</button>
                    <button class="btn btn-info" type="button" id="btnClose" style="width: 80px">Đóng</button>
                </div>
            </div> 
        </div>
    </div>
</div>

<div class="box2" id="div-statistic">
    <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center">
            <h3 class="panel-title">THỐNG KÊ DOANH THU</h3>
        </div>
        <div class="panel-body" style="padding: 0px">
            <div class="col-sm-12" id="div-loading-image" style="text-align: center; display: none">
                <img style="width: 150px; height: 100px;" src="{!!asset('/images/Loading_icon.gif')!!}">
            </div>
            <div class="row label-noti-statistic"><label id="lblNotiContent"></label></div>
            <div class="row" id="statistic-content" style="display: block">
                <div class="col-sm-12 row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-4" style="text-align: left"><label>Thời gian thống kê: </label></div>
                    <div class="col-sm-6" style="text-align: left"><label id="lblTime"></label></div>
                </div>
                <div class="col-sm-12 row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-4" style="text-align: left"><label>Tổng số đơn hàng:</label></div>
                    <div class="col-sm-6" style="text-align: left"><label id="lblTotalQty"></label></div>
                </div>
                <div class="col-sm-12 row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-4" style="text-align: left"><label>Số đơn hàng tại quán:</label></div>
                    <div class="col-sm-6" style="text-align: left"><label id="lblOnlQty"></label></div>
                </div>
                <div class="col-sm-12 row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-4" style="text-align: left"><label>Số đơn hàng online:</label></div>
                    <div class="col-sm-6" style="text-align: left"><label id="lblOffQty"></label></div>
                </div>
                <div class="col-sm-12 row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-4" style="text-align: left"><label>Tổng số tiền:</label></div>
                    <div class="col-sm-6" style="text-align: left"><label id="lblTotal"></label></div>
                </div>
                <div class="col-sm-12 row" style="text-align: center">
                    <label>Số lượng yêu cầu các loại đồ uống</label>
                </div>
                <div class="col-sm-12" style="text-align: center; margin-top: 20px">
                    <table class="table table-bordered">
                        <thead>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lần yêu cầu</th>
                        </thead>
                        <tbody id="tblStatistic">
                        </tbody>
                    </table>
                </div>
                <div class="row row-input" style="text-align: center">
                    <button class="btn btn-info" type="button" id="btnCloseStatistic" style="width: 80px">Đóng</button>
                </div>
            </div> 
        </div>
    </div>
</div>

@endsection