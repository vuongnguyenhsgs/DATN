@extends('layouts.admin-layout')

@section('page-title','Danh sách nhà cung cấp')

@section('page-name','Danh sách nhà cung cấp')

@section('page-content')

<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-all-production').DataTable({
            "language": {
                "lengthMenu": "Hiển thị _MENU_ bản ghi",
                "zeroRecords": "Không có bản ghi nào",
                "info": "Hiển thị bản ghi thứ _START_ tới _END_ trên _TOTAL_ bản ghi",
                "infoFiltered": "(Lọc từ _MAX_ bản ghi)",
                "search": "Tìm kiếm"
            }
        });
    });
</script>

<div class="col-md-12 col-sm-12 col-xs-12">
    <input type="hidden" id="crsf_token_form" name="_token" value="{{ csrf_token() }}"/>
    <div class="x_panel">
        <div class="x_content">
            <table id="datatable-all-production" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Tên nhà cung cấp</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Tùy chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach($productions as $production)
                    <tr>
                        <td>{!!$production->name!!}</td>
                        <td class="td-center">{!!$production->address!!}</td>
                        <td class="td-center">{!!$production->phone!!}</td>
                        <td class="td-center" style="width: 200px">
                            <button id="btnEditProduction" value="{!!$production->id!!}"><a><i class="fa fa-edit"></i> Sửa </a></button>
                            <button id="btnDeleteProduction" value="{!!$production->id!!}"><a><i class="fa fa-remove"></i> Xóa </a></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="dim"></div>

<div class="confirm-dialog" id="confirm-delete-production">
    <div class="panel panel-info">
        <input type="hidden" id="deletedId">
        <div class="panel-heading" style="text-align: center">
            <h3 class="panel-title">Xác nhận xóa</h3>
        </div>
        <div class="panel-body" style="padding: 0px">
            <div class="row row-input"><label>Bạn có chắc muốn xóa?</label></div>
            <div class="row row-input" style="text-align: center">
                <button type="button" id="btnDeleteProductionOk" class="btn btn-primary btn-custom">OK</button>
                <button type="button" id="btnDeleteProductionCancel" class="btn btn-primary btn-custom">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div class="noti-dialog" id="noti-delete-production">
    <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center">
            <h3 class="panel-title">THÔNG BÁO</h3>
        </div>
        <div class="panel-body" style="padding: 0px">
            <div class="row row-input"><label id="lblNotiContent"></label></div>
            <div class="row row-input" style="text-align: center">
                <button type="button" id="btnNotiOk" class="btn btn-primary btn-custom">Đóng</button>
            </div>
        </div>
    </div>
</div>
@endsection

