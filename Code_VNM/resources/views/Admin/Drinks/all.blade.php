@extends('layouts.admin-layout')

@section('page-title','Danh sách đồ uống')

@section('page-name','Danh sách đồ uống')

@section('page-content')

<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-all-drink').DataTable({
            "language": {
                "lengthMenu": "Hiển thị _MENU_ bản ghi",
                "zeroRecords": "Không có bản ghi nào",
                "infoEmpty": "No records available",
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
            <table id="datatable-all-drink" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Tên đồ uống</th>
                        <th>Loại đồ uống</th>
                        <th>Giá</th>
                        <th>Tùy chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach($drinks as $drink)
                    <tr>
                        <td>{!!$drink->name!!}</td>
                        <td class="td-center">{!!$drink->category_name!!}</td>
                        <td class="td-center">{!!number_format($drink->price,0,"",",")!!}</td>
                        <td class="td-center" style="width: 200px">
                            <button id="btnEditDrink" value="{!!$drink->id!!}"><a><i class="fa fa-edit"></i> Sửa </a></button>
                            <button id="btnDeleteDrink" value="{!!$drink->id!!}"><a><i class="fa fa-remove"></i> Xóa </a></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="dim"></div>

<div class="confirm-dialog" id="confirm-delete-drink">
    <div class="panel panel-info">
        <input type="hidden" id="deletedId">
        <div class="panel-heading" style="text-align: center">
            <h3 class="panel-title">Xác nhận xóa</h3>
        </div>
        <div class="panel-body" style="padding: 0px">
            <div class="row row-input"><label>Bạn có chắc muốn xóa?</label></div>
            <div class="row row-input" style="text-align: center">
                <button type="button" id="btnDeleteDrinkOk" class="btn btn-primary btn-custom">OK</button>
                <button type="button" id="btnDeleteDrinkCancel" class="btn btn-primary btn-custom">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div class="noti-dialog" id="noti-delete-drink">
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