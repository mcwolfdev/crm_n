@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <nav class="breadcrumbs">
                    <ol class="breadcrumb" style="--bs-breadcrumb-margin-bottom: 0;">
                        <li class="breadcrumb-item navbar-right"><a href="/">Головна</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Користувачі</li>
                    </ol>
                </nav>
            <h1>Користувачі</h1>

            <span>Всього: <b>{{$user_all_count}}</b>
                @if($user_all_count == 0)записів.
                @endif @if($user_all_count==1)запис.
                @endif @if($user_all_count==2)записи.
                @endif @if($user_all_count==3)записи.
                @endif @if($user_all_count==4)записи.
                @endif @if($user_all_count>4)записів.
                @endif
            </span>
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success" href="#"><i class="fa fa-plus"></i> Додати користувача</a>
                </div>

                <div class="card-body">

                        <table class="table table-hover text-nowrap" style="font-size: 12px;">
                            <thead>
                            <tr>
                                <th scope="col" style="width: 20px;">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Телефон</th>
                                <th scope="col">ПІБ</th>
                                <th scope="col">Статус</th>
                                <th scope="col">До сплати</th>
                                <th scope="col">Дія</th>
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"><input id="id" class="form-control" style="width: 60px; height: 30px; font-size: 12px;" name="id"></th>
                                <th scope="col"><input id="id" class="form-control" style="width: 160px; height: 30px; font-size: 12px;"></th>
                                <th scope="col"><input id="id" class="form-control" style="width: 160px; height: 30px; font-size: 12px;"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user_all as $kay=>$user)
                            <tr @if($user->hidden == 1) style="background-color: #ccc;" @endif>
                                <th scope="row">{{$kay+1}}</th>
                                <th>{{$user->id}}</th>
                                <td>{{$user->email}}</td>
                                <td>{{$user->name}}</td>
                                @if ($user->hidden == 0)
                                    <td><i class="fas fa-check text-success"></i> (працює)</td>
                                @elseif ($user->hidden == 1)
                                    <td><i class="fas fa-times text-danger"></i> (звільнено @if(!empty($user->dismissed)) {{$user->dismissed}}@endif)</td>
                                @endif
                                <td>{{number_format($user->getToPay($user->id), 2, '.', ' ')}} грн.</td>


                                <td>
                                    <a href="{{route('user_pay',$user->id)}}"><i class="fas fa-dollar-sign"></i></a>
                                    <a href="{{route('user_edit',$user->id)}}"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="#"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    <br>
                    <div style="padding-left: 1em;">
                        {{ $user_all->links() }}
                    </div>
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
