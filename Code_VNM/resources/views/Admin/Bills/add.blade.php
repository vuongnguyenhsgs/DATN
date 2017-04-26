@extends('layouts.admin-layout')

@section('page-title','Thêm mới hóa đơn')

@section('page-name','Thêm mới hóa đơn')

@section('page-content')
<script type="text/javascript">
    $(document).ready(function () {
        $('.combobox-select2').select2();

        $("input#date-picker").datepicker({
        });
    });

</script>
@endsection