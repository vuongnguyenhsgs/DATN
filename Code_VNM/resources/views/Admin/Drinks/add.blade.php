@extends('layouts.admin-layout')

@section('page-title','Thêm mới đồ uống')

@section('page-name','Thêm mới đồ uống')

@section('page-content')
<script type="text/javascript">
    $(document).ready(function () {
        $('.combobox-select2').select2({
            templateResult: function (data) {
                if (data.id == null) {
                    return data.text;
                }

                var $option = $("<span></span>");
                var $preview1 = $("<a style=\"float:right\" onclick=\"editCategory(" + data.id + ")\"><span style=\"margin: 0px 0px 0px 6px\" id=\"iconEditCate\" class=\"glyphicon glyphicon-pencil\"></span></a>");
                var $preview2 = $("<a style=\"float:right\" onclick=\"delCategory(" + data.id + ")\"><span style=\"margin: 0px 0px 0px 6px\" id=\"iconDelCate\" class=\"glyphicon glyphicon-trash\"></span></a>");
                $preview1.on('mouseup', function (evt) {
                    // Select2 will remove the dropdown on `mouseup`, which will prevent any `click` events from being triggered
                    // So we need to block the propagation of the `mouseup` event
                    evt.stopPropagation();
                });
                $preview1.on('click', function (evt) {
                    editCategory(data.id, data.text);
                });

                $preview2.on('mouseup', function (evt) {
                    evt.stopPropagation();
                });
                $preview2.on('click', function (evt) {
                    delCategory(data.id, data.text);
                });


                $option.text(data.text);
                $option.append($preview2);
                $option.append($preview1);

                return $option;
            }

        });
        function editCategory(id, name) {
            alert(id);
        }
        function delCategory(id, name) {
            alert(id);
        }

    });


</script>
<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="x_panel">
        <div class="x_content">
            <form action="{!!url('/Admin/drinks/add')!!}" method="POST" id="frmAddNewDrink" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <input type="hidden" id="type-request" name="type" value="{!!$type!!}">
                @if($type == 'edit')
                <input type="hidden" name="drinkId" value="{!!$drinks[0]->id!!}">
                @endif
                <div class="row col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group col-lg-6 col-lg-offset-1">
                        <div class="row row-input">
                            <div class="col-lg-4">
                                <label class="">Loại đồ uống</label>
                            </div>
                            <div class="col-lg-8" style="vertical-align: middle">
                                @if($type == 'add')
                                <select id="cobCategory" name="cobCategory" class="combobox-select2 form-control" style="width: 67%">
                                    @foreach($categories as $category)
                                    <option value="{!!$category->id!!}">{!!$category->name!!}</option>
                                    @endforeach
                                </select>
                                @else
                                <select id="cobCategory" name="cobCategory" class="combobox-select2 form-control" style="width: 67%">
                                    @foreach($categories as $category)
                                        @if($category->id == $drinks[0]->category_id)
                                        <option value="{!!$category->id!!}" selected="selected">{!!$category->name!!}</option>
                                        @else
                                        <option value="{!!$category->id!!}">{!!$category->name!!}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                                <button type="button" class="btn btn-primary" id="addNewCategory" style="width: 30%">Thêm mới</button>
                            </div>
                        </div>
                        <div class="row row-input">
                            <div class="col-lg-4">
                                <label class="">Tên đồ uống</label>
                            </div>
                            <div class="col-lg-8">
                                @if($type == 'add')
                                <input type="text" id="txtDrinkName" name="txtDrinkName" class="form-control">
                                @else
                                <input type="text" id="txtDrinkName" name="txtDrinkName" value="{!!$drinks[0]->name!!}"  class="form-control" readonly>
                                @endif
                                <label class="label-err hidden" id="errDrinkName"></label>
                            </div>
                        </div>
                        <div class="row row-input">
                            <div class="col-lg-4">
                                <label class="">Đơn giá</label>
                            </div>
                            <div class="col-lg-8">
                                @if($type == 'add')
                                <input type="text" id="txtPrice" name="txtPrice" class="form-control">
                                @else
                                <input type="text" id="txtPrice" name="txtPrice" value="{!!$drinks[0]->price!!}" class="form-control">
                                @endif
                                <label class="label-err hidden" id="errPrice"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-4">
                        <div class="col-lg-offset-2"><label>Ảnh sản phẩm</label></div>
                        <div class="col-lg-10 col-lg-offset-2">
                            <div class="image view">
                                @if($type == 'add')
                                <img id="drinkImage">
                                @else
                                <img id="drinkImage" style="width: 150px; height: 150px" src="{!!asset('storage/images/drinks/'.$drinks[0]->image1)!!}">
                                @endif
                                
                            </div>
                            <div>
                                <input type="file" id="drinkImageInput" name="drinkImageInput" onchange="readURL(this);">
                                <label class="label-err hidden" id="errImage"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group col-lg-6 col-lg-offset-1">
                        <div class="row row-input">
                            <div class="col-lg-4">
                                <label class="">Mô tả sản phẩm</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group col-lg-8 col-lg-offset-3">
                        <div class="row col-lg-12 row-input">
                            <div id="alerts"></div>
                            <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-one">
                                <div class="btn-group">
                                    <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                    <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                    <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                    <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                                </div>

                                <div class="btn-group">
                                    <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                    <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                                    <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                                    <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                                </div>

                                <div class="btn-group">
                                    <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                    <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                    <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                                    <a class="btn btn-info" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                                </div>

                                <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink" aria-expanded="false"><i class="fa fa-link"></i></a>
                                    <div class="dropdown-menu input-append">
                                        <input class="span2" placeholder="URL" type="text" data-edit="createLink">
                                        <button class="btn" type="button">Add</button>
                                    </div>
                                    <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                                </div>

                                <div class="btn-group">
                                    <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                                    <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                                </div>
                            </div>
                            <div id="editor-one" class="editor-wrapper placeholderText" contenteditable="true"><blockquote style="text-align: justify; margin: 0px 0px 0px 40px; border: none; padding: 0px;"><br></blockquote></div>
                            <textarea name="txtDescription" id="txtDescription" style="display:none;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row col-lg-12 col-md-12 col-sm-12" style="text-align: center">
                    <button class="btn btn-primary btn-custom" id="btnAddDrinkOk" type="button">Lưu</button>
                    <button class="btn btn-primary btn-custom" id="btnAddDrinkCancel" type="button">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="dim"></div>
<div class="box" id="popAddNewCategory">
    <input type="hidden" id="crsf_token_form" name="_token" value="{{ csrf_token() }}"/>
    <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center">
            <h3 class="panel-title">THÊM LOẠI ĐỒ UỐNG MỚI</h3>
        </div>
        <div class="panel-body" style="padding: 0px">
            <div class="row row-input"><label class="label-err" id="errAddNewCategory"></label></div>
            <div class="row row-input">
                <div class="col-lg-3"><label>Tên loại</label></div>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="txtCategoryName" id="txtCategoryName">
                </div>
            </div>
            <div class="row row-input" style="text-align: center">
                <button type="button" id="btnAddNewCategoryOk" class="btn btn-primary btn-custom">Lưu</button>
                <button type="button" id="btnAddNewCategoryCancel" class="btn btn-primary btn-custom">Hủy</button>
            </div>
        </div>
    </div>
</div>
@endsection