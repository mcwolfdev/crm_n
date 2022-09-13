@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <nav class="breadcrumbs">
                    <ol class="breadcrumb" style="--bs-breadcrumb-margin-bottom: 0;">
                        <li class="breadcrumb-item navbar-right"><a href="/">Головна</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Робота</li>
                    </ol>
                </nav>
            <h1>Робота</h1>
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success" href="/job/create"><i class="fa fa-plus"></i> Додати роботу</a>
                    <a class="btn btn-warning" href="#"><i class="fas fa-search"></i> Пошук</a>
                </div>

                <div class="card-body">




                        <table id="1122" class="table table-hover text-nowrap" style="font-size: 12px;">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">ПІБ Клієнта</th>
                                <th scope="col">Телефон</th>
                                <th scope="col">Номер рами</th>
                                <th scope="col">ТЗ</th>
                                {{--<th scope="col">Створив</th>--}}
                                <th scope="col">Виконавець</th>
                                <th scope="col">Створений</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Дія</th>
                            </tr>
                            <tr>
                                <th scope="col"><input id="id" class="form-control" style="width: 50px; height: 30px; font-size: 12px;" name="id"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                {{--<th scope="col"></th>--}}
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($job_all as $job)
                                <tr class="{{$job->status}} cont">
                                <th scope="row">{{$job->id}}</th>
                                <td class="col-md-8">{{$job->getClientFullName()}}</td>
                                <td>{{$job->getClientPhoneNumber()}}</td>
                                <td>{{$job->getVehicleFrameNumber()}}</td>
                                {{--<td>{{$job->getBrandName()}} - {{$job->getModelName()}}</td>--}}
                                <td>{{$job->getBrandName()}} - {{$job->getModelName()}}</td>
                                {{--<td>{{$job->getCreatorName()}}</td>--}}
                                <td>{{$job->getPerformerName()}}</td>
                                <td>{{$job->created_at->format('d-M-Y')}}</td>
                                <td><span class="job-status {{$job->status}}">@if($job->status == 'new') новий @elseif($job->status == 'on-the-job') в роботі @elseif($job->status == 'pending') в очікуванні @elseif($job->status == 'done') виконано @elseif($job->status == 'closed') закритий@endif</span></td>
                                <td>
                                    <a href="#" id="trigger" data-bs-toggle="modal" data-bs-target="#viewModal{{$job->id}}" class="btn btn-default btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="{{route('job_edit',$job->id)}}" class="btn btn-default btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="{{route('job_print', $job->id)}}" class="btn btn-default btn-sm"><i class="fa fa-print" aria-hidden="true"></i></a>

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



{{--<script>
    // после загрузки страницы
    document.addEventListener('DOMContentLoaded', function() {
        // элемент, содержащий контент модального окна (например, имеющий id="modal")
        const elemModal = document.querySelector('#modal');
        // активируем элемент в качестве модального окна с параметрами по умолчанию
        const modal = new bootstrap.Modal(elemModal);
        // при клике
        document.addEventListener('click', function(e) {
            // получим цель (элемент на который нажали)
            const target = e.target;
            // завершим выполнение функции, если цель не имеет атрибут data-list
            if (!target.dataset.list) {
                return;
            }
            // получим содержимое списка
            let html = document.querySelector(target.dataset.list).innerHTML;
            // установим .modal-body содержимое html
            elemModal.querySelector('.modal-body').innerHTML = '<ul>' + html + '</ul>';
            // откроем модальное окно
            modal.show();
        });
    });
</script>

<ul id="list-1" class="d-none">
    {{$job_all[0]}}
</ul>
<ul id="list-2" class="d-none">
    <li>Ten</li>
    <li>Eleven</li>
    <li>Twelve</li>
</ul>

<button type="button" class="btn btn-primary" data-list="#list-1">modal с одним списком</button>
<button type="button" class="btn btn-primary" data-list="#list-2">modal с другим списком</button>

<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
--}}



@foreach($job_all as $key=>$job)
<!-- Modal -->
<div hidden>{{$kayjob = $job->id}}</div>
<div class="modal fade" id="viewModal{{$job->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Заявка № <b>{{$job->id}}</b> від <b>{{$job->created_at->format('d-M-Y')}}</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ПІБ клієнта: <b>{{$job->getClientFullName()}}</b><br>
                Телефон: <b>{{$job->getClientPhoneNumber()}}</b><br>
                [<b>{{$job->getVehicleFrameNumber()}}</b>] {{$job->getBrandName()}} - {{$job->getModelName()}}
                <hr>
                Виконавець: @if(empty($job->getPerformerName())) <b><не назначено></b> @else <b>{{$job->getPerformerName()}}</b>@endif<br>
                Статус: <span class="job-status {{$job->status}}">@if($job->status == 'new') новий @elseif($job->status == 'on-the-job') в роботі @elseif($job->status == 'pending') в очікуванні @elseif($job->status == 'done') виконано @elseif($job->status == 'closed') закритий@endif</span>
                <hr>
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="ion ion-clipboard mr-1"></i>
                            Роботи (checklist):
                        </h3>
                    </div>

                    <div class="card-body">
                        <ul class="todo-list ui-sortable" data-widget="todo-list">
                            @foreach($job->Tasks as $task)
                            <li class="@if($job->status == 'closed') done @endif">
                                <div class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" @if($job->status == 'closed') disabled @endif value="" name="todo1" id="todoCheck1" @if($job->status == 'closed') checked @endif>
                                    <label for="todoCheck1"></label>
                                </div>

                                <span class="text">{{$task->getTaskCatalogue->name}}</span>

                                <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>

                                @if($job->status != 'closed')
                                <div class="tools">
                                    <i class="fas fa-edit"></i>
                                    <i class="fas fa-trash-o"></i>
                                </div>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if(empty($job->getPerformerName()))
                    <a href="{{route('TakeJob', $kayjob)}}"><button type="button" class="btn btn-primary">Взяти в роботу</button></a>
                @endif
                @if($job->status == 'new')
                    <a href="{{route('ToWorkJob', $kayjob)}}"><button type="button" class="btn btn-info">В роботу</button></a>
                    <a href="{{route('SuspendJob', $kayjob)}}"><button type="button" class="btn btn-warning">Відкласти</button></a>
                @endif
                @if($job->status == 'on-the-job')
                    <a href="{{route('Donejob', $kayjob)}}"><button type="button" class="btn btn-success">Виконано</button></a>
                    <a href="{{route('SuspendJob', $kayjob)}}"><button type="button" class="btn btn-warning">Відкласти</button></a>
                    <a href="{{route('CloseJob', $kayjob)}}"><button type="button" class="btn btn-danger">Зачинити</button></a>
                @endif
                @if($job->status == 'pending')
                    <a href="{{route('ToWorkJob', $kayjob)}}"><button type="button" class="btn btn-info">В роботу</button></a>
                @endif
                @if($job->status == 'done')
                    <a href="{{route('CloseJob', $kayjob)}}"><button type="button" class="btn btn-danger">Зачинити</button></a>
                @endif
                {{--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>--}}
            </div>
        </div>
    </div>
</div>
@endforeach


@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (Session::has('success'))
    @if(Session()->get('success') == 'done')

   <script>
        Swal.fire({
            title: 'Робота виконана :)',
            width: 600,
            padding: '3em',
            color: '#716add',
            background: '#fff url(/img/trees.png)',
            backdrop: `
    rgba(0,0,123,0.4)
    url("/img/nyan-cat.gif")
    left top
    no-repeat
  `
        })
    </script>
    @elseif(Session()->get('success') == 'on-the-job')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Статус змінено',
            showConfirmButton: false,
            timer: 1500
        })
    </script>
{{--    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: 'Signed in successfully'
        })
    </script>--}}
    @endif
@endif


    <style>
        .breadcrumbs {
            /*padding: 8px 15px;*/
            padding: 0;
            margin-bottom: 20px;
            list-style: none;
            background-color: #f5f5f5;
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

        .job-status.on-the-job {
            background-color: #00CCCC;
        }

        .job-status.new {
            background-color: #337ab7;
        }

        .job-status.pending {
            background-color: #f0ad4e;
        }

        .job-status.closed {
            background-color: #777;
        }

        .job-status.done {
            background-color: #66CC66;
        }

        /*tbody > tr.new {
            background: #e4e4fd;
        }

        table thead {
            background: #fff;
        }*/

        /*.job-update table thead {
            background: transparent;
        }*/

        tr {
            background: #fff;
        }
        tr:nth-of-type(odd) {
            background: #fff;
        }
        tr.cont:hover {
            background: #FFFFCC!important;
        }
        tr.new {
            background: #e4e4fd;
        }
        tr.on-the-job {
            background: #FFF;
        }
        tr.pending {
            background: #ffe4af;
        }
        tr.done {
            background: #CCFFCC;
        }
        tr.closed {
            background: #CCCCCC;
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
                /*$(this).val('');*/
                ids = $(this).val();
                if ($(this).val() == ''){
                    window.location = '/';
                }
                window.location = 'job/find_job='+ids;
            }
        });
    </script>
@endsection
