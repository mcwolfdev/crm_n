@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <nav class="breadcrumbs">
                    <ol class="breadcrumb" style="--bs-breadcrumb-margin-bottom: 0;">
                        <li class="breadcrumb-item navbar-right"><a href="/">Головна</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Відділи</li>
                    </ol>
                </nav>
            <h1>Відділи</h1>

            <span>Всього: <b>{{$departments_all_count}}</b> @if($departments_all_count == 0)записів.@endif @if($departments_all_count==1)запис.@endif @if($departments_all_count==2)записи.@endif @if($departments_all_count==3)записи.@endif @if($departments_all_count==4)записи.@endif @if($departments_all_count>4)записів.@endif</span>
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-plus"></i> Додати відділ</a>
                </div>

                <div class="card-body">

                        <table class="table table-hover text-nowrap" style="font-size: 12px;">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-danger_edit alert-dismissible">
                                    <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Помилка',
                                        showConfirmButton: false,
                                        timer: 2500
                                    })
                                </script>
                            @endif
                            <thead>
                            <tr>
                                <th scope="col" style="width: 20px;">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Назва</th>
                                <th scope="col">Співробітники</th>
                                <th scope="col">Дія</th>
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"><input id="id" class="form-control" style="width: 60px; height: 30px; font-size: 12px;" name="id"></th>
                                <th scope="col"><input id="id" class="form-control" style="width: 160px; height: 30px; font-size: 12px;"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($departments_all->count() == 0)
                                <tr>
                                    <th scope="row">-</th>
                                    <th>немає жодного запису...</th>
                                    <td>-</td>
                                    <td>
                                        -
                                    </td>
                                </tr>
                            @else
                            @foreach($departments_all as $kay=>$department)
                            <tr>
                                <th scope="row">{{$kay+1}}</th>
                                <th>{{$department->id}}</th>
                                <td><i class="fas fa-map-marked-alt"></i> {{$department->name}} [{{$department->address}}]</td>
                                <td>-</td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#ModalEdit_{{$department->id}}" data-url="222"><i class="fas fa-pencil-alt"></i></a>
                                    <a class="DeleteDep" onclick="delDept(this)" data-url="{{ route('department_delete', $department->id) }}" data-dept-name="{{$department->name}}"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    <br>
                    <div style="padding-left: 1em;">
                        {{ $departments_all->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Створення відділу</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible" style="display:none">
                </div>

                <form action="#" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-warehouse"></i></span>
                        </div>
                        <input type="text" name="department_name" id="department_name" class="department_name form-control" placeholder="Назва відділу">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                        </div>
                        <input type="text" id="department_details" class="form-control" placeholder="Реквізити">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                        </div>
                        <input type="text" id="department_address" class="form-control" placeholder="Адреса відділу">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відмінити</button>
                <button type="button" class="btn btn-primary" id="formSubmit">Створити</button>
            </div>
        </div>
    </div>
</div>

@foreach($departments_all as $dept)
<!-- Modal Edit -->
<div class="modal fade" id="ModalEdit_{{$dept->id}}" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Редагування відділу</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-danger_edit alert-dismissible" style="display:none">
                </div>

                <form action="{{ route('department_edit')}}" method="post">
                    <input type="hidden" name="department_id" value="{{$dept->id}}">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-warehouse"></i></span>
                        </div>
                        <input type="text" name="department_name_edit" class="form-control" value="{{$dept->name}}">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                        </div>
                        <input type="text" name="department_details_edit" class="form-control" value="{{$dept->details}}">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                        </div>
                        <input type="text" name="department_address_edit" class="form-control" value="{{$dept->address}}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відмінити</button>
                        <button type="submit" class="btn btn-primary">Зберегти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@if(Session()->get('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Зміни внесено!',
            showConfirmButton: false,
            timer: 2000
        })
    </script>
@endif


{{--@if(Session()->get('errors'))

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Помилка :(',
            showConfirmButton: false,
            timer: 1500
        })
    </script>
@endif--}}



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

<script>
    $(document).ready(function(){
        $('#formSubmit').click(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $.ajax({
                url: "{{ route('department_new')}}",
                method: 'post',
                data: {
                    department_name: $('#department_name').val(),
                    department_details: $('#department_details').val(),
                    department_address: $('#department_address').val(),
                },

                success: function(result){
                    if(result.errors)
                    {
                        $('.alert-danger').html('');
                        $('.alert-danger').append('<button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>');
                        $('.alert-danger').append('<h5><i class="icon fas fa-ban"></i> Помилка</h5>');

                        $.each(result.errors, function(key, value){
                            Swal.fire(
                                'Помилка!',
                                result.errors.join("<br>").toString(),
                                'error'
                            );
                            $('.alert-danger').show();
                            $('.alert-danger').append('<li>'+value+'</li>');
                        });
                    }
                    else
                    {
                        $('.alert-danger').hide();
                        $('#exampleModal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Новий відділ '+$('#department_name').val()+' додано!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function () {
                            window.location.href= '{{asset('settings/departments')}}';
                        });
                    }
                }
            });
        });
    });
</script>



<script>
    function delDept(btn) {
        url = $(btn).data('url');
        dept = $(btn).data('dept-name');
    }

    $(function () {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $('.DeleteDep').click(function () {
            Swal.fire({
                title: 'Ви впевнені?',
                text: "Видалити відділ "+dept,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Відмінити',
                confirmButtonText: 'Так, видалити!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Видалено!',
                        'Відділ видалено.',
                        'success'
                    ).then(function () {
                        window.location = url;
                    });
                }
            })
        });
    });
</script>

    <script>
        function editDept(btn) {
            url = $(btn).data('url');
            dept_id = $(btn).data('id');
            dept = $(btn).data('dept-name');
            details = $(btn).data('dept-details');
            address = $(btn).data('dept-address');
        }

        $('.editDept').click(function () {
            $('<div class="modaledit fade" id="ModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel">' +
                '<div class="modal-dialog">' +
                '<div class="modal-content">' +
                '<div class="modal-header">' +
                '<h5 class="modal-title" id="exampleModalLabel">Створення відділу</h5>' +
                '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
                '</div>' +
                '<div class="modal-body">' +

                '<div class="alert alert-danger alert-dismissible" style="display:none">' +

                '</div>' +

                '<form action="#" method="post">' +
                '@csrf' +
                '<div class="input-group mb-3">' +
                '<div class="input-group-prepend">' +
                '<span class="input-group-text"><i class="fas fa-warehouse"></i></span>' +
                '</div>' +
                '<input type="text" name="department_name" id="department_name" class="department_name form-control" placeholder="Назва відділу">' +
                '</div>' +
                '<div class="input-group mb-3">' +
                '<div class="input-group-prepend">' +
                '<span class="input-group-text"><i class="fas fa-home"></i></span>' +
                '</div>' +
                '<input type="text" id="department_details" class="form-control" placeholder="Реквізити">' +
                '</div>' +
                '<div class="input-group mb-3">' +
                '<div class="input-group-prepend">' +
                '<span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>' +
                '</div>' +
                '<input type="text" id="department_address" class="form-control" placeholder="Адреса відділу">' +
                '</div>' +
                '</form>' +
                '</div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відмінити</button>' +
                '<button type="button" class="btn btn-primary" id="formSubmit">Створити</button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>')
        });

    </script>
@endsection
