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
                <form action="{{route('user_edit_proces')}}" method="post" class="needs-validation" novalidate>
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    @csrf
                    <div class="card-body">
                        <h4>Ім'я</h4>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="user_name" class="form-control" placeholder="Ім'я" value="{{$user->name}}" required>
                        </div>
                        <h4>Дата народження</h4>
                        <div class="input-group mb-3">
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input type="text" name="birth_date" class="form-control" id="datepicker" value="{{$user->birth_date}}" required>
                            </div>
                        </div>
                        <h4>Телефон</h4>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" name="phone_number" class="form-control" data-inputmask='"mask": "+380 (99) 999-99-99"' data-mask value="{{$user->phone}}" required>
                        </div>

                        <h4>E-mail</h4>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" name="user_email" class="form-control" placeholder="Email" value="{{$user->email}}" required>
                        </div>
                        <h4>Пароль</h4>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-lock"></i></span>
                            </div>
                            <input type="password" name="user_password" class="form-control" placeholder="Пароль (для зміни ввеіть новий)">
                        </div>
                        <h4>Ставка</h4>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                            <input type="number" name="user_rate" class="form-control" placeholder="Фіксована заробітна плата" value="{{$user->rate}}">
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

<script src="{{asset('js/jquery.inputmask.min.js')}}"></script>
<script>
    $(function () {

        $('[data-mask]').inputmask()
    });
</script>


<link href="{{asset('css/bootstrap-datepicker.css')}}" rel="stylesheet" type="text/css">

<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<!-- bootstrap datepicker -->
<script src="{{asset('js/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('js/datepicker/locales/bootstrap-datepicker.uk.js')}}" charset="UTF-8"></script>
<script>
    $(function () {
        //Date picker
        $('#datepicker').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            clearBtn: true,
            language: "uk",
            multidateSeparator: "-",
            autoclose: true,
            todayHighlight: true,
            toggleActive: true
        })
    })
</script>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
{{--
<script src="{{asset('js/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('js/moment/moment.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('js/daterangepicker/daterangepicker.css')}}">

<script>
    $(function () {

        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges   : {
                    'Today'       : [moment(), moment()],
                    'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                    'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate  : moment()
            },
            function (start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })

        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

    })

</script>--}}
@endsection
