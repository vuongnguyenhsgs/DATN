function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#drinkImage')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(150);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function () {
    /**
     * Hàm thêm dấu phẩy ngăn cách ở đơn giá sản phẩm
     */
    $("input#txtPrice, input#txtQuantity").keyup(function (event) {
        if (event.which >= 37 && event.which <= 40)
            return;
        $(this).val(function (index, value) {
            return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
        });
    });

    /**
     * Hiển thị ảnh vừa được chọn để upload lên
     * @param {type} input
     * @returns {undefined}
     */
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#drinkImage')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('button#addNewCategory').click(function () {
        $('.dim').show();
        $('.box').show('fast');
    });

    /**
     * Xử lý sự kiện click vào button Hủy trên pop-up thêm mới Loại đồ uống
     */
    $('button#btnAddNewCategoryCancel').click(function () {
        $('label#errAddNewCategory').text('');
        $('input#txtCategoryName').val('');
        $('.dim, #popAddNewCategory').hide();
    });

    /**
     * Xử lý sự kiện click vào button Lưu trên pop-up thêm mới Loại đồ uống
     */
    $('button#btnAddNewCategoryOk').click(function () {
        //Trường hợp để trống
        if ($('input#txtCategoryName').val().trim() === '') {
            $('label#errAddNewCategory').text('Vui lòng nhập đủ thông tin');
        } else {
            //Trường hợp đã nhập
            //Kiểm tra trùng
            $.ajax({
                url: "/Admin/categories/add",
                type: 'POST',
                data: {
                    txtCategoryName: $('input#txtCategoryName').val().trim(),
                    _token: $('input#crsf_token_form').val(),
                },
                success: function (data, textStatus, jqXHR) {
                    if (data === 'existed') {
                        //Trường hợp tên đã tồn tại
                        $('label#errAddNewCategory').text('Tên loại đồ uống đã có sẵn');
                    } else {
                        //Trường hợp thêm thành công
                        if (data > 0) {
                            $('label#errAddNewCategory').text('Thêm thành công');
                            //Thêm vào combobox
                            var content = "<option value=\"" + data + "\" selected=\"selected\">" + $('input#txtCategoryName').val().trim();
                            content += "</option>";
                            $('select#cobCategory').prepend(content);
                        } else {
                            //Trường hợp thêm không thành công
                            $('label#errAddNewCategory').text('Thêm không thành thành công');
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    //Hiện thông báo thêm không thành công
                    $('label#errAddNewCategory').text('Thêm không thành thành công');
                }
            });
        }
    });
    /**
     * Lưu thông tin đồ uống
     */
    $('button#btnAddDrinkOk').click(function () {
        $('label.label-err').addClass('hidden');
        var count = 0;
        //Kiểm tra nhập đủ thông tin
        if ($('input#txtDrinkName').val().trim() === '') {
            $('label#errDrinkName').text('Vui lòng nhập tên đồ uống');
            $('label#errDrinkName').removeClass('hidden');
            count++;
        }
        if ($('input#txtPrice').val().trim() === '') {
            $('label#errPrice').text('Vui lòng nhập giá');
            $('label#errPrice').removeClass('hidden');
            count++;
        }
        if ($('input#drinkImageInput').get(0).files.length === 0 && $('input#type-request').val() === 'add') {
            $('label#errImage').text('Vui lòng chọn ảnh');
            $('label#errImage').removeClass('hidden');
            count++;
        }
        //Nếu đã nhập tên thì kiểm tra trùng lặp
        if ($('input#txtDrinkName').val() !== '' && $('input#type-request').val() === 'add') {
            $.ajax({
                url: "/Admin/drinks/is-existed",
                type: 'POST',
                data: {
                    txtDrinkName: $('input#txtDrinkName').val(),
                    typeCheck: 'name',
                    _token: $('input#crsf_token_form').val()
                },
                success: function (data, textStatus, jqXHR) {
                    //Nếu tên trùng thì hiện thông báo lỗi
                    if (data === 'true') {
                        $('label#errDrinkName').text('Tên đồ uống đã tồn tại');
                        $('label#errDrinkName').removeClass('hidden');
                        count++;
                        return;
                    } else {
                        if (count > 0) {
                            return;
                        } else {
                            //Không có lỗi thì submit form
                            $('form#frmAddNewDrink').submit();
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            });
        } else if (count == 0) {
            $('form#frmAddNewDrink').submit();
        }

    });

    /*
     * Hiện pop-up khi click Xóa
     */
    $('button#btnDeleteDrink').click(function () {
        $('.dim').show('fast');
        $('#confirm-delete-drink').show('fast');
        $('input#deletedId').val($(this).val());
    });
    /**
     * Click đồng ý xóa
     */
    $('button#btnDeleteDrinkOk').click(function () {
        $('#confirm-delete-drink').hide();
        $.ajax({
            url: "/Admin/drinks/delete",
            type: 'POST',
            data: {
                drinkId: $('input#deletedId').val(),
                _token: $('input#crsf_token_form').val()
            },
            success: function (data, textStatus, jqXHR) {
                //Xóa thành công
                $('.dim, #noti-delete-drink').show('fast');
                if (data === 'true') {
                    $('label#lblNotiContent').text('Xóa thành công');
                    $('button#btnNotiOk').click(function () {
                        $('.dim, #noti-delete-drink').hide();
                        window.location.href = '/Admin/drinks/all';
                    });
                } else {
                    $('label#lblNotiContent').text('Xóa không thành công');
                    $('button#btnNotiOk').click(function () {
                        $('.dim, #noti-delete-drink').hide();
                    });
                }
            },
            //Xóa không thành công
            error: function (jqXHR, textStatus, errorThrown) {
                $('.dim, #noti-delete-drink').show('fast');
                $('label#lblNotiContent').text('Xóa không thành công');
                $('button#btnNotiOk').click(function () {
                    $('.dim, #noti-delete-drink').hide();
                });
            }
        });
    });

    /**
     * Click ok ở pop-up thông báo kết quả
     */
    $('button#btnNotiOk').click(function () {
        $('.dim, #noti-delete-drink').hide();
    });

    $('button#btnDeleteDrinkCancel').click(function () {
        $('.dim, #confirm-delete-drink').hide();
    });

    $('button#btnEditDrink').click(function () {
        var url = '/Admin/drinks/edit/' + $(this).val();
        window.location.href = url;
    });

    /**
     * Click button xóa nguyên liệu
     */
    $('button#btnDeleteMaterial').click(function () {
        $('.dim, #confirm-delete-material').show('fast');
        $('input#deletedId').val($(this).val());
    });

    /**
     * Click OK ở pop-up xác nhận xóa nguyên liệu
     */
    $('button#btnDeleteMaterialOk').click(function () {
        $('#confirm-delete-material').hide();
        $.ajax({
            url: "/Admin/materials/delete",
            type: 'POST',
            data: {
                materialId: $('input#deletedId').val(),
                _token: $('input#crsf_token_form').val()
            },
            success: function (data, textStatus, jqXHR) {
                //Xóa thành công
                $('.dim, #noti-delete-material').show('fast');
                if (data === 'true') {
                    $('label#lblNotiContent').text('Xóa thành công');
                    $('button#btnNotiOk').click(function () {
                        $('.dim, #noti-delete-material').hide();
                        window.location.href = '/Admin/materials/all';
                    });
                } else {
                    $('label#lblNotiContent').text('Xóa không thành công');
                    $('button#btnNotiOk').click(function () {
                        $('.dim, #noti-delete-material').hide();
                    });
                }
            },
            //Xóa không thành công
            error: function (jqXHR, textStatus, errorThrown) {
                $('.dim, #noti-delete-material').show('fast');
                $('label#lblNotiContent').text('Xóa không thành công');
                $('button#btnNotiOk').click(function () {
                    $('.dim, #noti-delete-material').hide();
                });
            }
        });
    });

    /**
     * Click Hủy ở pop-up xác nhận xóa nguyên liệu
     */
    $('button#btnDeleteMaterialCancel').click(function () {
        $('.dim, #confirm-delete-material').hide();
    });

    $('button#btnDeleteProduction').click(function () {
        $('.dim, #confirm-delete-production').show('fast');
        $('input#deletedId').val($(this).val());
    });

    /**
     * Click OK ở pop-up xác nhận xóa nguyên liệu
     */
    $('button#btnDeleteProductionOk').click(function () {
        $('#confirm-delete-production').hide();
        $.ajax({
            url: "/Admin/productions/delete",
            type: 'POST',
            data: {
                productionId: $('input#deletedId').val(),
                _token: $('input#crsf_token_form').val()
            },
            success: function (data, textStatus, jqXHR) {
                //Xóa thành công
                $('.dim, #noti-delete-production').show('fast');
                if (data === 'true') {
                    $('label#lblNotiContent').text('Xóa thành công');
                    $('button#btnNotiOk').click(function () {
                        $('.dim, #noti-delete-production').hide();
                        window.location.href = '/Admin/productions/all';
                    });
                } else {
                    $('label#lblNotiContent').text('Xóa không thành công');
                    $('button#btnNotiOk').click(function () {
                        $('.dim, #noti-delete-production').hide();
                    });
                }
            },
            //Xóa không thành công
            error: function (jqXHR, textStatus, errorThrown) {
                $('.dim, #noti-delete-production').show('fast');
                $('label#lblNotiContent').text('Xóa không thành công');
                $('button#btnNotiOk').click(function () {
                    $('.dim, #noti-delete-production').hide();
                });
            }
        });
    });

    /**
     * Click Hủy ở pop-up xác nhận xóa nguyên liệu
     */
    $('button#btnDeleteProductionCancel').click(function () {
        $('.dim, #confirm-delete-production').hide();
    });

    $('button#btnAddMaterialOk').click(function () {
        $('label#lblAddMaterial').text();
        if ($('input#txtMaterialName').val().trim() === '') {
            $('label#lblAddMaterial').text('Vui lòng nhập tên nguyên liệu');
            return;
        }
        if ($('input#txtQuantity').val() === '') {
            $('label#lblAddMaterial').text('Vui lòng nhập số lượng');
            return;
        }
        if ($('input#txtPrice').val() === '') {
            $('label#lblAddMaterial').text('Vui lòng nhập giá');
            return;
        }
        //Kiểm tra trùng tên
        if ($('input#txtMaterialName').val().trim() !== '') {
            $.ajax({
                url: "/Admin/materials/is-existed",
                type: 'POST',
                data: {
                    txtMaterialName: $('input#txtMaterialName').val().trim(),
                    _token: $('input#crsf_token_form').val(),
                },
                success: function (data, textStatus, jqXHR) {
                    if (data === 'true') {
                        $('label#lblAddMaterial').text('Tên nguyên liệu bị trùng, hãy thử lại');
                        return;
                    } else {
                        //Nếu không bị trùng thì thêm mới
                        $.ajax({
                            url: "/Admin/materials/add",
                            type: 'POST',
                            data: {
                                txtMaterialName: $('input#txtMaterialName').val().trim(),
                                txtPrice: $('input#txtPrice').val().trim(),
                                txtQuantity: $('input#txtQuantity').val().trim(),
                                cobProduction: $('select#cobProduction').val(),
                                _token: $('input#crsf_token_form').val(),
                            },
                            success: function (data, textStatus, jqXHR) {
                                if (data === 'true') {
                                    $('.dim').show();
                                    $('div#noti-add-material').show('fast');
                                    $('label#lblNotiContent').text('Thêm thành công');
                                    $('button#btnNotiOk').click(function () {
                                        $('.dim, div#noti-add-material').hide();
                                    });
                                } else {
                                    $('.dim').show();
                                    $('div#noti-add-material').show('fast');
                                    $('label#lblNotiContent').text('Thêm không thành công, hãy thử lại');
                                    $('button#btnNotiOk').click(function () {
                                        $('.dim, div#noti-add-material').hide();
                                    });
                                }

                            },
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('.dim').show();
                    $('div#noti-add-material').show('fast');
                    $('label#lblNotiContent').text('Thêm không thành công, hãy thử lại');
                    $('button#btnNotiOk').click(function () {
                        $('.dim, div#noti-add-material').hide();
                    });
                }
            });
        }
    });
});

