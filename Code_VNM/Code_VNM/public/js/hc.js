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

function removeCommas(str) {
    return(str.replace(/,/g, ''));
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

    $(function () {
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            scrollDistance: 300, // Distance from top/bottom before showing element (px)
            scrollFrom: 'top', // 'top' or 'bottom'
            scrollSpeed: 300, // Speed back to top (ms)
            easingType: 'linear', // Scroll to top easing (see http://easings.net/)
            animation: 'fade', // Fade, slide, none
            animationSpeed: 200, // Animation in speed (ms)
            scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
            //scrollTarget: false, // Set a custom target element for scrolling to the top
            scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
            scrollTitle: false, // Set a custom <a> title if required.
            scrollImg: false, // Set true to use image
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647 // Z-Index for the overlay
        });
    });

    /**
     * Hàm thêm dấu phẩy ngăn cách ở đơn giá sản phẩm
     */
    $("input#txtPrice, input#txtQuantity, input.number-input").keyup(function (event) {
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
//                url: "http://heavencoffee.96.lt/Code_VNM/public/" + "/Admin/categories/add",
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
//                url: "http://heavencoffee.96.lt/Code_VNM/public/" + "/Admin/drinks/is-existed",
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
//            url: "http://heavencoffee.96.lt/Code_VNM/public/" + "/Admin/drinks/delete",
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
//        var url = "http://heavencoffee.96.lt/Code_VNM/public/" + '/Admin/drinks/edit/' + $(this).val();
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
//            url: "http://heavencoffee.96.lt/Code_VNM/public/" + "/Admin/materials/delete",
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
//            url: "http://heavencoffee.96.lt/Code_VNM/public/" + "/Admin/productions/delete",
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

    /**
     * 
     */
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
                url: "http://heavencoffee.96.lt/Code_VNM/public/" + "/Admin/materials/is-existed",
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
//                            url: "http://heavencoffee.96.lt/Code_VNM/public/" + "/Admin/materials/add",
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

    /**
     * Hiển thị pop-up thêm đồ uống vào hóa đơn
     */
    $('button#btnAddToBill').click(function () {
        $('.dim').show();
        $('div#popAddToBill').show('fast');
    });

    /**
     * Click OK ở pop-up thêm đồ uống vào hóa đơn
     */
    $('button#btnAddToBillOk').click(function () {
        //Kiểm tra số lượng
        if ($('input#txtQuantity').val() === '') {
            $('label#errAddToBill').text('Vui lòng nhập số lượng');
            return;
        } else {
            //Thêm row vào bảng chi tiết hóa đơn
            var name = $('#cobDrinkToBill option:selected').text();
            var value = $('select#cobDrinkToBill').val().split('-');
            var content = "<tr class=\"bill-detail\">";
            content += "<td>" + name + "</td>";
            content += "<td class=\"drink-id\ hidden\">" + value[0] + "</td>";
            content += "<td class=\"quantity\">" + $('input#txtQuantity').val() + "</td>";
            content += "<td class=\"drink-price\">" + addCommas(value[1]) + "</td>";
            content += "<td class=\"subTotal\">" + addCommas(parseInt(value[1]) * parseInt($('input#txtQuantity').val())) + "</td>";
            content += "<td style=\"text-align:center\"><span class=\"fa fa-times cancel\"></span></td>"
            content += "</tr>";
            $('#tblDetailBill').append(content);
            //Tính lại tổng tiền
            var total = 0;
            if ($('label#lblTotal').text() !== '') {
                total = parseInt(removeCommas($('label#lblTotal').text()));
            }
            total += parseInt($('input#txtQuantity').val()) * value[1];
            $('label#lblTotal').text(addCommas(total + ""));
            //Ẩn pop-up
            $('.dim, div#popAddToBill').hide();
        }
    });

    /**
     * Xử lý sự kiện click vào icon xóa 1 sản phẩm khỏi chi tiết hóa đơn
     */
    $(document).on('click', 'span.cancel', function () {
        var total = 0;
        //Tính lại tổng tiền
        if ($('label#lblTotal').text() !== '') {
            total = parseInt(removeCommas($('label#lblTotal').text()));
        }
        total -= parseInt(removeCommas($(this).parent().siblings('.subTotal').text()));
        $('label#lblTotal').text(addCommas("" + total));
        //Xóa row
        $(this).closest('tr').remove();
    });

    /**
     * Hủy thêm sản phẩm vào chi tiết hóa đơn
     */
    $('button#btnAddToBillCancel').click(function () {
        $('.dim, div#popAddToBill').hide();
        $('input#txtQuantity').val('');
    });

    /**
     * Lưu thông tin hóa đơn
     */
    $('button#btnAddBillOk').click(function () {
        //Chuyển giá trị thẻ input về blank
        $('input#bill-detail').val('');
        //Xóa thông báo lỗi
        $('label#lblErrAddBill').text('');
        //Kiểm tra nhập tên khách hàng
        if ($('input#txtCustomerName').val().trim() === '') {
            $('label#lblErrAddBill').text('Vui lòng nhập tên khách hàng');
            return;
        }
        //Kiểm tra nhập sản phẩm
        if ($('tr.bill-detail').length === 0) {
            $('label#lblErrAddBill').text('Vui lòng chọn ít nhất 1 món');
            return;
        }
        //Sinh chuỗi chi tiết hóa đơn
        $.each($('tr.bill-detail'), function (i, val) {
            var temp = $(this).children('td.drink-id').text() + '-' +
                    removeCommas($(this).children('td.quantity').text()) + '-' +
                    removeCommas($(this).children('td.drink-price').text()) + ',';
            $('input#bill-detail').val($('input#bill-detail').val() + temp);
        });
        //Lưu hóa đơn
        $.ajax({
            url: "/Admin/bills/add",
//            url: "http://heavencoffee.96.lt/Code_VNM/public/" + "/Admin/bills/add",
            type: 'POST',
            data: {
                txtCustomerName: $('input#txtCustomerName').val(),
                txtPhone: $('input#txtPhone').val(),
                txtAddress: $('input#txtAddress').val(),
                billDetail: $('input#bill-detail').val(),
                total: removeCommas($('label#lblTotal').text()),
                _token: $('input#crsf_token_form').val()
            },
            //Hiện hộp thoại đợi
            beforeSend: function (xhr) {
                $('.dim, #noti-add-bill').show();
                $('div#div-loading-image').show();
                $('label#lblNotiContent').text("Đang xử lý...");
                $('div#div-button').hide();
            },
            success: function (data, textStatus, jqXHR) {
                if (data === 'true') {
                    $('.dim, #noti-add-bill').show();
                    $('div#div-loading-image').hide();
                    $('label#lblNotiContent').text("Thêm thành công");
                    $('div#div-button').show();
                    $('button#btnNotiOk').click(function () {
                        $('.dim, #noti-add-bill').hide();
                    });
                } else {
                    $('.dim, #noti-add-bill').show();
                    $('div#div-loading-image').hide();
                    $('label#lblNotiContent').text("Thêm không thành công");
                    $('div#div-button').show();
                    $('button#btnNotiOk').click(function () {
                        $('.dim, #noti-add-bill').hide();
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.dim, #noti-add-bill').show();
                $('div#div-loading-image').hide();
                $('label#lblNotiContent').text("Thêm không thành công");
                $('div#div-button').show();
                $('button#btnNotiOk').click(function () {
                    $('.dim, #noti-add-bill').hide();
                });
            }
        });
    });

    //Thêm sản phẩm vào giỏ hàng ở màn hình chi tiết sản phẩm
    $('button#addDrinkToCart').click(function () {
        alert('clicked');
        $('label#lblQuantityErr').text('');
        if ($('input#txtQuantity').val() === '') {
            $('label#lblQuantityErr').text('Hãy nhập số lượng');
            return;
        } else {
            $.ajax({
                url: "/cart/addToCart",
//                url: "http://heavencoffee.96.lt/Code_VNM/public/" + "/cart/addToCart",
                type: 'POST',
                data: {
                    txtDrinkId: $('input#txtDrinkId').val(),
                    txtDrinkName: $('input#txtDrinkName').val(),
                    txtPrice: $('input#txtPrice').val(),
                    txtQuantity: $('input#txtQuantity').val(),
                    image1: $('input#image1').val(),
                    _token: $('input#crsf_token_form').val()
                },
                beforeSend: function (xhr) {
                    $('div.noti-dialog, .dim').show();
                    $('div#div-loading-image').show();
                    $('label#lblNotiContent').text("Đang lưu...");
                    $('div#div-button').hide();
                },
                success: function (data, textStatus, jqXHR) {
                    if (data === 'true') {
                        $('div.noti-dialog, .dim').show();
                        $('div#div-loading-image').hide();
                        $('label#lblNotiContent').text("Đã thêm vào giỏ hàng");
                        $('div#div-button').show();
                        $('button#btnNotiOk').click(function () {
                            $('div.noti-dialog, .dim').hide();
                        });
                    } else {
                        $('.dim, #noti-add-bill').show();
                        $('div#div-loading-image').hide();
                        $('label#lblNotiContent').text("Thêm không thành công, hãy thử lại");
                        $('div#div-button').show();
                        $('button#btnNotiOk').click(function () {
                            $('div.noti-dialog, .dim').hide();
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });
        }
    });

    /**
     * Hiện pop-up xác nhận bỏ sản phẩm khỏi giỏ hàng
     */
    $('.cart_delete_item').click(function () {
        $('button#btnRemoveCartOk').val($(this).val());
        $('div.confirm-dialog, .dim').show();
    });

    /**
     * Đồng ý xóa sản phẩm khỏi giỏ hàng
     */
    $('button#btnRemoveCartOk').click(function () {
        var rowId = 'tr#' + $(this).val();
        $.ajax({
            url: "/cart/remove",
//            url: "http://heavencoffee.96.lt/Code_VNM/public/" + "/cart/remove",
            type: 'POST',
            data: {
                itemId: $(this).val(),
                _token: $('input#crsf_token_form').val()
            },
            success: function (data, textStatus, jqXHR) {
                if (data === 'true') {
                    $(rowId).remove();
                    $('div.confirm-dialog, .dim').hide();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });

    $('button#btnRemoveCartCancel').click(function () {
        $('div.confirm-dialog, .dim').hide();
    });

    /**
     * Checkout
     */
    $('button#btnCheckout').click(function () {
        if ($('.cart_quantity_input').length === 0) {
            $('label#lblErrCheckCart').text('Vui lòng chọn ít nhất 1 sản phẩm');
            $('label#lblErrCheckCart').removeClass('hidden');
        } else {
            $('label#lblErrCheckCart').addClass('hidden');
            var count = 0;
            $.each($('input.cart_quantity_input'), function (i, val) {
                if ($(this).val().trim() === '') {
                    count++;
                }
            });
            if (count > 0) {
                $('label#lblErrCheckCart').text('Vui lòng nhập số lượng');
                $('label#lblErrCheckCart').removeClass('hidden');
            } else {
                $('label#lblErr').addClass('hidden');
                $('div#checkout-dialog, .dim').show();
            }
        }
    });

    $('button#btnCheckoutOk').click(function () {
        //Nếu nhập thiếu thông tin thì hiện thông báo lỗi
        if ($('input#txtCustomerName').val().trim() === '' || $('input#txtPhone').val().trim() === '' || $('input#txtAddress').val().trim() === '') {
            $('label#lblErr').removeClass('hidden');
        } else {
            //Thêm vào nếu k có lỗi
            //Cập nhật cart trước
            var cartDetail = '';
            $.each($('td.cart_quantity'), function (i, val) {
                cartDetail += $(this).parent('tr').attr('id') + '-' + $(this).children().children('.cart_quantity_input').val().trim() + '-'
                        + removeCommas($(this).siblings('.cart_price').children('p').text()) + ',';
            });
            //Thêm hóa đơn
            $.ajax({
                url: "/cart/add-bill",
//                url: "http://heavencoffee.96.lt/Code_VNM/public/" + "/cart/add-bill",
                type: 'POST',
                data: {
                    txtCustomerName: $('input#txtCustomerName').val(),
                    txtPhone: $('input#txtPhone').val(),
                    txtAddress: $('input#txtAddress').val(),
                    cartDetail: cartDetail,
                    _token: $('input#crsf_token_form').val()
                },
                beforeSend: function (xhr) {
                    $('div.noti-dialog, .dim').show();
                    $('div#div-loading-image').show();
                    $('div#checkout-dialog').hide();
                    $('label#lblNotiContent').text("Đang thực hiện...");
                    $('div#div-button').hide();
                },
                success: function (data, textStatus, jqXHR) {
                    if (data === 'true') {
                        $('div.noti-dialog, .dim').show();
                        $('div#div-loading-image').hide();
                        $('label#lblNotiContent').text("Đơn hàng đã được xác nhận");
                        $('div#div-button').show();
                        $('button#btnNotiOk').click(function () {
                            $('div.noti-dialog, .dim').hide();
                        });
                    } else {
                        $('.dim, #noti-add-bill').show();
                        $('div#div-loading-image').hide();
                        $('label#lblNotiContent').text("Chưa thành công, hãy thử lại");
                        $('div#div-button').show();
                        $('button#btnNotiOk').click(function () {
                            $('div.noti-dialog, .dim').hide();
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });
        }
    });

    /**
     * Lưu hóa đơn
     */
    $('button#btnSaveCart').click(function () {
        var cartDetail = '';
        //Tạo chuỗi chi tiết hóa đơn
        $.each($('td.cart_quantity'), function (i, val) {
            cartDetail += $(this).parent('tr').attr('id') + '-' + $(this).children().children('.cart_quantity_input').val().trim() + ',';
        });
        $.ajax({
            url: "/cart/update",
//            url: "http://heavencoffee.96.lt/Code_VNM/public/" + "/cart/update",
            type: 'POST',
            data: {
                cartDetail: cartDetail,
                _token: $('input#crsf_token_form').val()
            },
            beforeSend: function (xhr) {
                $('div.noti-dialog, .dim').show();
                $('div#div-loading-image').show();
                $('label#lblNotiContent').text("Đang lưu...");
                $('div#div-button').hide();
            },
            success: function (data, textStatus, jqXHR) {
                if (data === 'true') {
                    $('div.noti-dialog, .dim').show();
                    $('div#div-loading-image').hide();
                    $('label#lblNotiContent').text("Lưu thành công");
                    $('div#div-button').show();
                    $('button#btnNotiOk').click(function () {
                        $('div.noti-dialog, .dim').hide();
                    });
                } else {
                    $('.dim, #noti-add-bill').show();
                    $('div#div-loading-image').hide();
                    $('label#lblNotiContent').text("Lưu không thành công, hãy thử lại");
                    $('div#div-button').show();
                    $('button#btnNotiOk').click(function () {
                        $('div.noti-dialog, .dim').hide();
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });

    /**
     * Tính tổng tiền khi có thay đổi số lượng sản phẩm
     */
    $('input.cart_quantity_input').keyup(function () {
        var total = 0;
        $.each($('td.cart_price'), function (i, val) {
            var quantity = $(this).siblings('td.cart_quantity').children().children('input').val();
            var price = $(this).children('p').text();
            if (quantity !== '') {
                total += parseInt(removeCommas(quantity)) * parseInt(removeCommas(price));
            }
        });
        $('label#lblTotal').text(addCommas(total));
    });

    $('button#btnSearchBill').click(function () {
        $('label#lblErrTimeFormat').text('');
        if ($('input#txtStartDate').val().trim() !== '' && !isValidDate($('input#txtStartDate').val().trim())) {
            $('label#lblErrTimeFormat').text('Vui lòng nhập đúng định dạng thời gian');
            return;
        }
        if ($('input#txtEndDate').val().trim() !== '' && !isValidDate($('input#txtEndDate').val().trim())) {
            $('label#lblErrTimeFormat').text('Vui lòng nhập đúng định dạng thời gian');
            return;
        }
        $('form#frmSearchBill').submit();
    });

    $('button.btnDeleteBill').click(function () {
        $('input#deletedId').val($(this).val());
        $('div#confirm-delete-bill, .dim').show();
    });

    $('button#btnDeleteBillOk').click(function () {
        $('div#confirm-delete-bill').hide();
        $.ajax({
            url: "/Admin/bills/update-bill",
            type: 'POST',
            data: {
                billId: $('input#deletedId').val(),
                status: 7,
                employee_id: $('select#cobShipper').val(),
                _token: $('input#crsf_token_form').val()
            },
            beforeSend: function (xhr) {
                $('div.noti-dialog, .dim').show();
                $('div#div-loading-image').show();
                $('label#lblNotiContent').text("Đang xử lý...");
                $('div#div-button').hide();
            },
            success: function (data, textStatus, jqXHR) {
                if (data === 'true') {
                    $('div.noti-dialog, .dim').show();
                    $('div#div-loading-image').hide();
                    $('label#lblNotiContent').text("Xóa thành công");
                    $('div#div-button').show();
                    $('button#btnNotiOk').click(function () {
                        window.location.href = '/Admin/bills/all';
                    });
                } else {
                    $('.dim, div.noti-dialog').show();
                    $('div#div-loading-image').hide();
                    $('label#lblNotiContent').text("Xóa không thành công, hãy thử lại");
                    $('div#div-button').show();
                    $('button#btnNotiOk').click(function () {
                        $('.dim, div.noti-dialog').hide();
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });

    $('button#btnDeleteBillCancel').click(function () {
        $('div#confirm-delete-bill, .dim').hide();
    });

    $('a.details-bill').click(function () {
        //Thêm nội dung mới
        $('label#lblBillId').text($(this).parent().siblings('td.bill-id > a').text());
        $('label#lblCustomerName').text($(this).parent().siblings('td.td-customer-name').text());
        $('label#lblCustomerAddress').text($(this).parent().siblings('td.td-customer-address').text());
        $('label#lblCustomerPhone').text($(this).parent().siblings('td.td-customer-phone').text());
        $('label#lblTotal').text(addCommas($(this).parent().siblings('td.td-bill-total').text()));
        //xóa content cũ
        $('tbody#tblDetailBillOnline > tr').remove();
        $.ajax({
            url: "/Admin/bills/detail",
//            url: "http://heavencoffee.96.lt/Code_VNM/public/" + "/Admin/bills/detail",
            type: 'POST',
            data: {
                billId: $(this).text(),
                _token: $('input#crsf_token_form').val()
            },
            beforeSend: function (xhr) {
                $('div#view-bill-detail-online, .dim').show();
                $('div#div-loading-image').show();
                $('label#lblNotiContent').text("Đang xử lý...");
                $('div.label-noti').show();
                $('div#bill-detail-content').hide();
                $('div#div-button').hide();
            },
            success: function (data, textStatus, jqXHR) {
                $('div.label-noti').hide();
                if (data !== '') {
                    for (i = 0; i < data.length; i++) {
                        var content = '<tr>';
                        content += '<td>' + data[i].name + '</td>';
                        content += '<td>' + data[i].quantity + '</td>';
                        content += '<td>' + data[i].price + '</td>';
                        content += '<td>' + parseInt(data[i].quantity) * parseInt(data[i].price) + '</td>';
                        $('tbody#tblDetailBillOnline').append(content);
                    }
                    $('div#div-loading-image').hide();
                    $('label#lblNotiContent').text("");
                    $('div#bill-detail-content').show();
                } else {

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
        $('div#view-bill-detail-online, .dim').show();
    });

    $('button#btnClose').click(function () {
        $('.dim, div#view-bill-detail-online').hide();
    });

    $('button.btnEditBill').click(function () {

        window.location.href = '/Admin/bills/edit/' + $(this).val();
//        window.location.href = "http://heavencoffee.96.lt/Code_VNM/public/" + '/Admin/bills/edit/' + $(this).val();
    });

    $('button#btnPrint').click(function () {
        window.print();
    });

    $('button.btnViewBillDetail').click(function () {

    });

    $('a#linkStatistic').click(function () {
        $('label#lblErrTimeFormat').text('');
        if ($('input#txtStartDate').val().trim() !== '' && !isValidDate($('input#txtStartDate').val().trim())) {
            $('label#lblErrTimeFormat').text('Vui lòng nhập đúng định dạng thời gian');
            return;
        }
        if ($('input#txtEndDate').val().trim() !== '' && !isValidDate($('input#txtEndDate').val().trim())) {
            $('label#lblErrTimeFormat').text('Vui lòng nhập đúng định dạng thời gian');
            return;
        }
        $.ajax({
            url: "/Admin/bills/statistic",
            type: 'POST',
            data: {
                status: $('select#cobStatus').val(),
                txtStartDate: $('input#txtStartDate').val().trim(),
                txtEndDate: $('input#txtEndDate').val().trim(),
                _token: $('input#crsf_token_form').val()
            },
            beforeSend: function (xhr) {
                $('tbody#tblStatistic > tr').remove();
                $('div#div-statistic, .dim').show();
                $('div#div-loading-image').show();
                $('label#lblNotiContent').text("Đang xử lý...");
                $('div.label-noti-statistic').show();
                $('div#bill-detail-content').hide();
                $('div#div-button').hide();
            },
            success: function (data, textStatus, jqXHR) {
                $('div.label-noti-statistic,#div-loading-image').hide();
                if ($('input#txtStartDate').val().trim() === '') {
                    if ($('input#txtEndDate').val().trim() === '') {
                        $('label#lblTime').text('Tính đến ngày ' + getCurrentDateTime());
                    } else {
                        $('label#lblTime').text('Tính đến ngày ' + $('input#txtEndDate').val().trim());
                    }
                } else {
                    if ($('input#txtEndDate').val().trim() === '') {
                        $('label#lblTime').text($('input#txtStartDate').val().trim() + ' - ' + getCurrentDateTime());
                    } else {
                        $('label#lblTime').text($('input#txtStartDate').val().trim() + ' - ' + $('input#txtEndDate').val().trim());
                    }
                }
                $('label#lblTotalQty').text(data[0]);
                $('label#lblOnlQty').text(data[1]);
                $('label#lblOffQty').text(parseInt(data[0]) - parseInt(data[1]));
                $('label#lblTotal').text(addCommas(data[2]) + ' VNĐ');
                for (i = 0; i < data[3].length; i++) {
                    var content = '<tr>';
                    content += '<td style="text-align:center">' + (i + 1) + '</td>';
                    content += '<td style="text-align:center">' + data[3][i].name + '</td>';
                    content += '<td style="text-align:center">' + data[3][i].quantity + '</td>';
                    content += '</tr>';
                    $('tbody#tblStatistic').append(content);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
        $('.dim, #div-statistic').show();
    });

    $('button#btnCloseStatistic').click(function () {
        $('.dim, #div-statistic').hide();
    });

    $('button.btnShip').click(function () {
        $('button#btnShipperOk').val($(this).val());
        $('input#billIdShip').val($(this).val());
        $('div#popShipper, .dim').show();
    });

    $('button#btnShipperOk').click(function () {
        $.ajax({
            url: "/Admin/bills/update-bill",
            type: 'POST',
            data: {
                billId: $(this).val(),
                status: 3,
                employee_id: $('select#cobShipper').val(),
                _token: $('input#crsf_token_form').val()
            },
            beforeSend: function (xhr) {
                $('div.noti-dialog, .dim').show();
                $('div#div-loading-image').show();
                $('label#lblNotiContent').text("Đang xử lý...");
                $('div#div-button').hide();
            },
            success: function (data, textStatus, jqXHR) {
                if (data === 'true') {
                    $('div.noti-dialog, .dim').show();
                    $('div#div-loading-image').hide();
                    $('label#lblNotiContent').text("Cập nhật thành công");
                    $('div#div-button').show();
                    $('button#btnNotiOk').click(function () {
                        $('div.noti-dialog, div#popShipper').hide();
                        $.ajax({
                            url: "/Admin/bills/" + $('input#billIdShip').val(),
                            type: 'GET',
                            success: function (data, textStatus, jqXHR) {
                                $('label#lblBillId').text('Số hóa đơn ' + data[0].id);
                                $('label#lblCustomerName').text(data[0].customer_name);
                                $('label#lblCustomerAddress').text(data[0].customer_address);
                                $('label#lblCustomerPhone').text(data[0].customer_phone);
                                $('label#lblTotal').text(addCommas(data[0].total));
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                            }
                        });


                        $.ajax({
                            url: "/Admin/bills/detail",
//            url: "http://heavencoffee.96.lt/Code_VNM/public/" + "/Admin/bills/detail",
                            type: 'POST',
                            data: {
                                billId: $('input#billIdShip').val(),
                                _token: $('input#crsf_token_form').val()
                            },
                            beforeSend: function (xhr) {
                                $('div#view-bill-detail-online, .dim').show();
                                $('div#div-loading-image').show();
                                $('label#lblNotiContent').text("Đang xử lý...");
                                $('div.label-noti').show();
                                $('div#bill-detail-content').hide();
                                $('div#div-button').hide();
                            },
                            success: function (data, textStatus, jqXHR) {
                                $('div.label-noti').hide();
                                if (data !== '') {
                                    for (i = 0; i < data.length; i++) {
                                        var content = '<tr>';
                                        content += '<td>' + data[i].name + '</td>';
                                        content += '<td>' + data[i].quantity + '</td>';
                                        content += '<td>' + data[i].price + '</td>';
                                        content += '<td>' + parseInt(data[i].quantity) * parseInt(data[i].price) + '</td>';
                                        $('tbody#tblDetailBillOnline').append(content);
                                    }
                                    $('div#div-loading-image').hide();
                                    $('label#lblNotiContent').text("");
                                    $('div#bill-detail-content').show();
                                } else {

                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                            }
                        });
                    });
                } else {
                    $('.dim, div.noti-dialog').show();
                    $('div#div-loading-image').hide();
                    $('label#lblNotiContent').text("Cập nhật không thành công, hãy thử lại");
                    $('div#div-button').show();
                    $('button#btnNotiOk').click(function () {
                        $('.dim, div.noti-dialog').hide();
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
    $('button#btnShipperCancel').click(function () {
        $('div#popShipper, .dim').hide();
    });

    $('button.btnGetMoney').click(function () {
        $('input#billId').val($(this).val());
        $('div#confirm-change-bill, .dim').show();
    });

    $('button#btnGetMoneyOk').click(function () {
        $.ajax({
            url: "/Admin/bills/update-bill",
            type: 'POST',
            data: {
                billId: $('input#billId').val(),
                status: 6,
                employee_id: $('select#cobShipper').val(),
                _token: $('input#crsf_token_form').val()
            },
            beforeSend: function (xhr) {
                $('div.noti-dialog, .dim').show();
                $('div#div-loading-image').show();
                $('label#lblNotiContent').text("Đang xử lý...");
                $('div#div-button').hide();
            },
            success: function (data, textStatus, jqXHR) {
                if (data === 'true') {
                    $('div.noti-dialog, .dim').show();
                    $('div#div-loading-image').hide();
                    $('label#lblNotiContent').text("Cập nhật thành công");
                    $('div#div-button').show();
                    $('button#btnNotiOk').click(function () {
                        $('div.noti-dialog, div.confirm-dialog').hide();
                        $.ajax({
                            url: "/Admin/bills/" + $('input#billId').val(),
                            type: 'GET',
                            success: function (data, textStatus, jqXHR) {
                                $('label#lblBillId').text('Số hóa đơn ' + data[0].id);
                                $('label#lblCustomerName').text(data[0].customer_name);
                                $('label#lblCustomerAddress').text(data[0].customer_address);
                                $('label#lblCustomerPhone').text(data[0].customer_phone);
                                $('label#lblTotal').text(addCommas(data[0].total));
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                            }
                        });


                        $.ajax({
                            url: "/Admin/bills/detail",
//            url: "http://heavencoffee.96.lt/Code_VNM/public/" + "/Admin/bills/detail",
                            type: 'POST',
                            data: {
                                billId: $('input#billId').val(),
                                _token: $('input#crsf_token_form').val()
                            },
                            beforeSend: function (xhr) {
                                $('div#view-bill-detail-online, .dim').show();
                                $('div#div-loading-image').show();
                                $('label#lblNotiContent').text("Đang xử lý...");
                                $('div.label-noti').show();
                                $('div#bill-detail-content').hide();
                                $('div#div-button').hide();
                            },
                            success: function (data, textStatus, jqXHR) {
                                $('div.label-noti').hide();
                                if (data !== '') {
                                    for (i = 0; i < data.length; i++) {
                                        var content = '<tr>';
                                        content += '<td>' + data[i].name + '</td>';
                                        content += '<td>' + data[i].quantity + '</td>';
                                        content += '<td>' + data[i].price + '</td>';
                                        content += '<td>' + parseInt(data[i].quantity) * parseInt(data[i].price) + '</td>';
                                        $('tbody#tblDetailBillOnline').append(content);
                                    }
                                    $('div#div-loading-image').hide();
                                    $('label#lblNotiContent').text("");
                                    $('div#bill-detail-content').show();
                                } else {

                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                            }
                        });
                    });
                } else {
                    $('.dim, div.noti-dialog').show();
                    $('div#div-loading-image').hide();
                    $('label#lblNotiContent').text("Cập nhật không thành công, hãy thử lại");
                    $('div#div-button').show();
                    $('button#btnNotiOk').click(function () {
                        $('.dim, div.noti-dialog').hide();
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });

    $('button#btnGetMoneyCancel').click(function () {
        $('div#confirm-change-bill, .dim').hide();
    });
});

function isValidDate(str) {
    if (!(/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/.test(str))) {
        return false;
    }
    return true;
}

//Chuyển định dạng ngày từ dd/mm/yyyy sang yyyy-mm-dd hh:mm:ss
function convertDatetoDateTime(date) {
    var arrDate = date.split("/");
    return arrDate[2] + "-" + arrDate[1] + "-" + arrDate[0] + " 00:00:00";
}

function convertDateTimetoDate(date) {
    var arrDate = date.split(" ");
    var arrDate2 = arrDate[0].split("-");
    return arrDate2[2] + "/" + arrDate2[1] + "/" + arrDate2[0];
}

function getCurrentDateTime() {
    d = new Date();
    return d.getDate() + '/' + (d.getMonth() + 1) + '/' + d.getFullYear();
}