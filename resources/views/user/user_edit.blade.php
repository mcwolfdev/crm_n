@extends('layouts.app')

@section('content')


<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
                <nav class="breadcrumbs" >
                    <ol class="breadcrumb" style="--bs-breadcrumb-margin-bottom: 30;">
                        <li class="breadcrumb-item navbar-right"><a href="/">Головна</a></li>
                        <li class="breadcrumb-item navbar-right"><a href="/settings/users">Користувачі</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$user->name}}</li>
                    </ol>
                </nav>
            <h1>Редагування користувача - {{$user->name}}</h1>

            <div class="card">
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

                {{--{{$user}}--}}
                <form action="{{route('user_edit_proces')}}" method="post">
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    @csrf
                    <div class="card-body">
                        <h4>Ім'я</h4>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="user_name" class="form-control" placeholder="Ім'я" value="{{$user->name}}">
                        </div>

                        <h4>E-mail</h4>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" name="user_email" class="form-control" placeholder="Email" value="{{$user->email}}">
                        </div>
                        <h4>Пароль</h4>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-lock"></i></span>
                            </div>
                            <input type="password" name="user_password" class="form-control" placeholder="Пароль (для зміни ввеіть новий)">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <h4>Роль</h4>
                            </div>
                            <select class="js-example-basic-multiple form-control" id="Role"
                                    name="Role" multiple="multiple" required
                                    oninvalid="this.setCustomValidity('Поле не може бути пустим')"
                                    oninput="setCustomValidity('')">
                                <option></option>
                                @foreach($role as $rol)
                                    <option value="{{$rol->id}}">{{$rol->name}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <h4>Відділ</h4>
                            </div>
                            <select class="department form-control" id="department"
                                    name="department" required
                                    oninvalid="this.setCustomValidity('Поле не може бути пустим')"
                                    oninput="setCustomValidity('')">
                                <option></option>
                                @foreach($departments as $department)
                                    <option value="{{$department->id}}">{{$department->name}} [{{$department->address}}]
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="custom-control custom-checkbox">
                                <input name="work" class="custom-control-input" type="checkbox" id="customCheckbox2" @if ($user->hidden == 1) checked="" @endif>
                                <label for="customCheckbox2" class="custom-control-label">Співробітника звільнено @if (!empty($user->dismissed)) ({{$user->dismissed}}) @endif</label>
                            </div>
                        </div>
                        <button class="btn btn-success" type="submit"><i class="far fa-save"></i> Зберегти</button>
                        {{--<a class="btn btn-success" type="submit"><i class="far fa-save"></i> Зберегти</a>--}}
                    </div>
                </form>
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
    <script>
        $(document).ready(function() {


            $('.department').select2({
                placeholder: 'Оберіть відділ',
                allowClear: true,
            });


            $('.js-example-basic-multiple').select2({
                placeholder: 'Оберіть права',
                allowClear: true,
                maximumSelectionLength: 1
            });

            @if($user->Roles->count() > 0)
                $('#Role').val({{$user->Roles[0]->id}}).trigger('change');
            @endif

            @if($user->department != null)
                @if($user->department->count() > 0)
                    $('#department').val({{$user->department->id}}).trigger('change');
                @endif
            @endif
        });
    </script>

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
@endsection
