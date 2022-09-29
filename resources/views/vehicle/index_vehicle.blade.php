@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <nav class="breadcrumbs">
                    <ol class="breadcrumb" style="--bs-breadcrumb-margin-bottom: 0;">
                        <li class="breadcrumb-item navbar-right"><a href="/">Головна</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Транспортні засоби</li>
                    </ol>
                </nav>
            <h1>Транспортні засоби</h1>

            <span>Всього: <b>{{$vehicle_all->count()}}</b> @if($vehicle_all->count()==0)записів.@endif @if($vehicle_all->count()==1)запис.@endif @if($vehicle_all->count()==2)записи.@endif @if($vehicle_all->count()==3)записи.@endif @if($vehicle_all->count()==4)записи.@endif @if($vehicle_all->count()>4)записів.@endif</span>
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success" href="#"><i class="fa fa-plus"></i> Додати Т.З.</a>
                </div>

                <div class="card-body">

                        <table class="table table-hover text-nowrap" style="font-size: 12px;">
                            <thead>
                            <tr>
                                <th scope="col" style="width: 20px;">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Номер шасі</th>
                                <th scope="col">Бренд</th>
                                <th scope="col">Модель</th>
                                <th scope="col">Пробіг</th>
                                <th scope="col">Тип пробігу</th>
                                <th scope="col">Дія</th>
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"><input id="id" class="form-control" style="width: 60px; height: 30px; font-size: 12px;" name="id"></th>
                                <th scope="col"><input id="id" class="form-control" style="width: 160px; height: 30px; font-size: 12px;"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vehicle_all as $kay=>$vehicle)
                            <tr>
                                <th scope="row">{{$kay+1}}</th>
                                <th>{{$vehicle->id}}</th>
                                <td>{{$vehicle->frame_number}}</td>
                                <td>{{$vehicle->Moodel->Brand->name}}</td>
                                <td>{{$vehicle->Moodel->name}}</td>
                                <td>@if (!$vehicle->mileage) - @else{{$vehicle->mileage}}@endif</td>
                                <td>@if (!$vehicle->mileage_type) - @else @if($vehicle->mileage_type == 1) км. @elseif($vehicle->mileage_type == 2) год. @endif @endif</td>
                                <td>
                                    <a href="#"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="#"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <style>
        .breadcrumbs {
            padding: 55px 0px;
            margin-bottom: -30px;
            list-style: none;
            border-radius: 4px;
        }

        .job-status {
            padding: 0.2em 0.6em 0.3em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25em;
        }

    </style>
    <script>
        $(document).ready(function () {
            $('[name=id]').bind('change keyup input click', function () {
                if (this.value.match(/[^0-9]/g)) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                }
            });
        });

        $("#id").keyup(function(event){
            if(event.keyCode == 13){
                $("#id").click();
                $(this).val('');
            }
        });
    </script>
@endsection
