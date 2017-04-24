@extends('layouts.admin-layout')

@section('page-title','Có lỗi')

@section('page-name','Có lỗi')

@section('page-content')
<h3>{!!$messContent!!}</h3>
<a href="{!!$urlBack!!}">Quay lại</a>
@endsection