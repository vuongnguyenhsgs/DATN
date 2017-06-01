@extends('layouts.admin-layout')

@section('page-title','Thêm mới nguyên liệu')

@section('page-name','Thêm mới nguyên liệu')

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
                <input type="hidden" id="type-request" name="type" value="{!!$type!!}">
                @if($type == 'edit')
                <input type="hidden" name="drinkId" value="{!!$drinks[0]->id!!}">
                @endif
                <div class="row">
                    <div class="form-group col-lg-5">
                        <div class="col-lg-4"><label>Tên nguyên liệu</label></div>
                        <div class="col-lg-8">
                            @if($type == 'add')
                            <input type="text" class="form-control" id="txtMaterialName" name="txtMaterialName">
                            @else
                            <input type="text" class="form-control" id="txtMaterialName" name="txtMaterialName" value="{!!$materials[0]->name!!}">
                            @endif
                        </div>
                    </div>
                    <div class="form-group col-lg-5 col-lg-offset-1">
                        <div class="col-lg-4"><label>Số lượng</label></div>
                        <div class="col-lg-8">
                            @if($type == 'add')
                            <input type="text" class="form-control" id="txtQuantity" name="txtQuantity">
                            @else
                            <input type="text" class="form-control" id="txtQuantity" name="txtQuantity" value="{!!$materials[0]->quantity!!}">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-5">
                        <div class="col-lg-4"><label>Hãng sản xuất</label></div>
                        <div class="col-lg-8">
                            <select class="combobox-select2 form-control" id="cobProduction">
                                <option value="0">--/--</option>
                                @if($type == 'add')
                                @foreach($productions as $production)
                                <option value="{!!$production->id!!}">{!!$production->name!!}</option>
                                @endforeach
                                @else
                                @foreach($productions as $production)
                                @if($production->id == $materials[0]->production_id)
                                <option value="{!!$production->id!!}" selected>{!!$production->name!!}</option>
                                @else
                                <option value="{!!$production->id!!}">{!!$production->name!!}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-5 col-lg-offset-1">
                        <div class="col-lg-4"><label>Đơn giá</label></div>
                        <div class="col-lg-8">
                            @if($type == 'add')
                            <input type="text" class="form-control" id="txtPrice" name="txtPrice">
                            @else
                            <input type="text" class="form-control" id="txtPrice" name="txtPrice" value="{!!$materials[0]->price!!}">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12">
                    <div class="col-lg-5">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-8"><label class="label-err" id="lblAddMaterial"></label></div>
                    </div>

                </div>
                <div class="row col-lg-12 col-md-12 col-sm-12" style="text-align: center">
                    <button class="btn btn-primary btn-custom" id="btnAddMaterialOk" type="button">Lưu</button>
                    <button class="btn btn-primary btn-custom" id="btnAddMaterialCancel" type="button">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="dim"></div>

<div class="noti-dialog" id="noti-add-material">
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