@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <nav class="breadcrumbs">
                    <ol class="breadcrumb" style="--bs-breadcrumb-margin-bottom: 0;">
                        <li class="breadcrumb-item"><a href="/">Головна</a></li>
                        <li class="breadcrumb-item"><a href="/">Робота</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Нова робота</li>
                    </ol>
                </nav>
            <h1>Нова робота</h1>
            <div class="card" style="background-color: transparent;">

                <div class="card-body">
                    <div class="job-form">

                        <form action="{{ route('create_job_input_fields') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            {{--<input type="hidden" name="_csrf" value="JHqK8d90WYuRtb6Mhc3N0X0hcEVwXuiZvobtgFmgBYxXO_-QrS1g4dqC7eHngIWDRBIyNzQssOuPwITtFM5NtQ==">--}}
                            @csrf
                            <div class="row client-info">
                                <div class="col-md-8">
                                    <div class="form-group field-client-full_name required">
                                        <label class="control-label" for="client-full_name">ПІБ Клієнта</label>
                                        <select class="js-example-basic-single form-control" id="Client"
                                                name="Client" required oninvalid="this.setCustomValidity('Поле не може бути пустим')" oninput="setCustomValidity('')">
                                            <option></option>
                                            {{--@foreach($client_all as $client)
                                                <option value="{{$client->id}}">{{$client->name}}</option>
                                            @endforeach--}}

                                        </select>

                                        <div class="help-block">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group field-client-phone_number required">
                                        <label class="control-label" for="client-phone_number">Телефон</label>
                                        {{--<input type="text" id="client-phone_number" class="form-control bfh-phone" name="Client[phone_number]" data-format="+380 (dd) ddd-dd-dd" data-number="" aria-required="true">--}}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" id="client-phone_number" name="client-phone_number" class="form-control" data-inputmask='"mask": "+380 (99) 999-99-99"' data-mask required oninvalid="this.setCustomValidity('Поле не може бути пустим')" oninput="setCustomValidity('')">
                                        </div>
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group field-vehicle-frame_number required">
                                        <label class="control-label" for="vehicle-frame_number">Номер рами</label>
                                        <select class="vehicle-frame_number form-control" id="vehicle-frame_number"
                                                name="vehicle-frame_number" required oninvalid="this.setCustomValidity('Поле не може бути пустим')" oninput="setCustomValidity('')">
                                            <option></option>
                                            {{--@foreach($client_all as $client)
                                                <option data-phone="{{$client->phone}}"
                                                        value="{{$client->id}}">{{$client->name}} /
                                                    phone: {{$client->phone}}</option>
                                            @endforeach--}}

                                        </select>
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group field-brand-name required">
                                        <label class="control-label" for="brand-name">Бренд</label>
                                        <select class="brand form-control" id="brand" name="brand" required oninvalid="this.setCustomValidity('Поле не може бути пустим')" oninput="setCustomValidity('')">
                                            <option></option>
                                            {{--@foreach($brands_all as $brand)
                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                            @endforeach--}}

                                        </select>

                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group field-model-name required">
                                        <label class="control-label" for="model-name">Модель</label>
                                        <select class="model form-control" id="model" name="model" required oninvalid="this.setCustomValidity('Поле не може бути пустим')" oninput="setCustomValidity('')">
                                            <option></option>
                                            {{--@foreach($models_brand as $mod_brand)
                                                <option value="{{$mod_brand->id}}">{{$mod_brand->name}}</option>
                                            @endforeach--}}

                                        </select>


                                        <div class="help-block"></div>
                                    </div>        </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group field-job-performer_id">
                                        <label class="control-label" for="job-performer_id">Обрати виконавця</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-plus"></i></span>
                                            </div>
                                            <select id="job-performer_id" class="form-control" name="job-performer_id">
                                                <option value=""></option>
                                                @foreach($users_all as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="help-block"></div>
                                    </div>        </div>
                                <div class="col-md-3">
                                    <div class="form-group field-vehicle-mileage">
                                        <label class="control-label" for="vehicle-mileage">Пробіг</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-route"></i></span>
                                            </div>
                                            <input type="text" id="vehicle-mileage" class="form-control" name="Vehicle[mileage]">
                                        </div>
                                        <div class="help-block"></div>
                                    </div>        </div>
                                <div class="col-md-3">
                                    <div class="form-group field-vehicle-mileage_type">
                                        <label class="control-label" for="vehicle-mileage_type">Тип прібігу</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fas fa-exchange-alt"></i></span>
                                            </div>
                                            <select id="vehicle-mileage_type" class="form-control"
                                                    name="Vehicle[mileage_type]">
                                                <option value="1">Пробіг</option>
                                                <option value="2">Мотогодини</option>
                                            </select>
                                        </div>
                                        <div class="help-block"></div>
                                    </div>        </div>
                            </div>


                            <div class="task-wrapper">
                                <div class="task_line">
                                    <span class="line"></span>
                                    <span class="title">Робота</span>
                                </div>

                                <div class="list">
                                    <div class="form-group field-task-name required">

                                        {{--<form action="{{ route('create_job_input_fields') }}" method="POST">--}}

                                            @if ($errors->any())
                                                <div class="alert alert-danger" role="alert">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <table class="table table-bordered" id="dynamicAddRemove">
                                                <tr>
                                                    <th>Найменування</th>
                                                    <th>Дія</th>
                                                </tr>
                                                <tr>
                                                    {{--<td>
                                                        <input type="text" required oninvalid="this.setCustomValidity('Заповніть це поле')" oninput="setCustomValidity('')" name="addMoreInputFields[0][subject]" placeholder="Введіть назву" class="form-control " />
                                                    </td>--}}
                                                    <td>
                                                        <select id="task_0" required oninvalid="this.setCustomValidity('Поле не може бути пустим')" oninput="setCustomValidity('')" class="task_inp task form-control" name="taskFields[0][name]">
                                                            <option></option>
                                                        </select>
                                                    </td>
                                                    <td style="width: 65px;"><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary"><i class="fa fa-plus"></i></button></td>
                                                </tr>
                                            </table>
                                            {{--<button type="submit" class="btn btn-outline-success btn-block">Save</button>--}}
                                        {{--</form>--}}

                                        <div class="help-block"></div>
                                    </div>        </div>

                                <div class="task_line">
                                    <span class="line"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group field-job-addition">
                                        <label class="control-label" for="job-addition"><i class="fas fa-car-crash"></i> Пошкодження та несправності (якщо такі присутні):</label>
                                        <textarea id="job-addition" class="form-control" name="Job_addition" rows="6"></textarea>

                                        <div class="help-block"></div>
                                    </div>        </div>
                                <div class="col-md-6">

                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Додати</button>    </div>

                        {{--</form>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>--}}

    <style>
        .breadcrumbs {
            /*padding: 8px 15px;*/
            padding: 0;
            margin-bottom: 20px;
            list-style: none;
            background-color: #f5f5f5;
            border-radius: 4px;
        }

        .task-wrapper > .task_line > .title {
            position: relative;
            z-index: 2;
            font-size: 25px;
            background: url(/img/bg.png);
            text-shadow: 1px 1px 0 #fff;
            padding: 0 12px 0 10px;
        }

        .task-wrapper > .task_line > .line {
            display: inline-block;
            border-top: 2px dashed rgba(0,0,0,0.24);
            height: 2px;
            width: 100%;
            position: absolute;
            left: 0;
            top: 17px;
        }

        .task-wrapper > .task_line {
            text-align: center;
            position: relative;
            height: 30px;
            margin-bottom: 5px;
        }
    </style>
{{--повідомлення--}}
@if (Session::has('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        })

        Toast.fire({
            icon: 'success',
            title: '{{ Session::get("success") }}'
        })
    </script>
    {{--<div class="alert alert-success text-center">
        <p>{{ Session::get('success') }}</p>
    </div>--}}
@endif

@if (Session::has('ClientChange'))
   <script>
       Swal.fire({
           title: 'Ви впевнені?',
           text: "{{ Session::get("ClientChange") }}",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Yes, delete it!'
       }).then((result) => {
           if (result.isConfirmed) {
               Swal.fire(
                   'Deleted!',
                   'Your file has been deleted.',
                   'success'
               )
           }
       })
   </script>
@endif

{{--<script>

    $(document).ready(function(){
        $('#formSubmit').click(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('create_job_input_fields') }}",
                method: 'post',
                data: {
                    id: $('#id').val(),
                    user_name: $('#user_name').val(),
                    user_email: $('#user_email').val(),
                },

                success: function(result){
                    if(result.errors)
                    {
                        $('.alert-danger').html('');

                        $.each(result.errors, function(key, value){
                            Swal.fire(
                                'Ошибка!',
                                '',
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

                        Swal.fire(
                            'Отличная работа!',
                            'Изменения сохранени!',
                            'success'
                        ).then(function () {
                            window.location.href= '{{asset('my/user_settings')}}';
                        });
                    }
                }
            });
        });
    });
</script>--}}


{{--multiinput--}}

<script type="text/javascript">
    var i = 0;
    $("#dynamic-ar").click(function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td><select id="task_'+i+'" class="task_inp task form-control" name="taskFields['+i+'][name]"><option></option></select></td><td><button type="button" class="btn btn-outline-danger remove-input-field"><i class="fas fa-trash-alt"></i></button></td></tr>'
        );
        /* оновити пошук при додаванні */
        $('.task').select2({
            minimumInputLength: 3,
            maximumInputLength: 100,
            placeholder: "Оберіть послугу",
            ajax: {
                url: "{{route('find_jobs')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    console.log(response)
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
        --i;
    });
</script>




<script src="{{asset('js/jquery.inputmask.min.js')}}"></script>
<script>
    $(function () {

        $('[data-mask]').inputmask()
    });
</script>


<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            tags: true,
            minimumInputLength: 3,
            maximumInputLength: 100,
            placeholder: "Оберіть клієнта",
            allowClear: true
        });

        $('.vehicle-frame_number').select2({
            tags: true,
            minimumInputLength: 1,
            maximumInputLength: 17,
            placeholder: "Оберіть Vin номер",
            allowClear: true
        });

        $('.brand').select2({
            tags: true,
            minimumInputLength: 3,
            maximumInputLength: 20,
            placeholder: "Оберіть бренд",
            allowClear: true
        });

        $('.model').select2({
            tags: true,
            minimumInputLength: 2,
            maximumInputLength: 15,
            placeholder: "Оберіть модель",
            allowClear: true
        });
    });
</script>

{{--select model--}}
    <script>
        $(document).ready(function() {
            $('#brand').on('change', function() {
                var stateID = $(this).val();
                if(stateID) {
                    $.ajax({
                        url: '/find_model/'+stateID,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data) {
                            if(data){
                                $('#model').empty();
                                $('#model').focus;
                                $('#model').append('<option value="">-- Select vin --</option>');
                                $.each(data, function(key, value){
                                    $('select[name="model"]').append('<option value="'+ key +'">' + value.name+ '</option>');
                                });
                            }else{
                                $('#model').empty();
                            }
                        }
                    });
                }else{
                    $('#model').empty();
                }
            });
        });
    </script>
{{--техніка клієнта--}}
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').on('change', function() {
            var stateID = $(this).val();
            if(stateID) {
                $.ajax({
                    url: '/find_vehicle_client/'+stateID,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data) {
                        if(data){
                            $('.vehicle-frame_number').select2({
                                tags: true,
                                maximumInputLength: 17,
                                placeholder: "Оберіть Vin номер",
                                allowClear: true,
                            });
                            $('#vehicle-frame_number').empty();
                            $('#vehicle-frame_number').focus;
                            $('#vehicle-frame_number').append('<option value="">-- Select model --</option>');
                            $.each(data, function (key, value) {
                                $('select[name="vehicle-frame_number"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }else{
                            $('#vehicle-frame_number').empty();
                        }
                    }
                });
            }else{
                $('#vehicle-frame_number').empty();
            }
        });


        $('.vehicle-frame_number').on('change', function() {
            var stateID = $(this).val();
            if(stateID) {
                $.ajax({
                    url: '/find_vehicle_client_brand_model/'+stateID,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data) {
                        if(data){
                            $('#brand').empty();
                            $('#brand').focus;
                            $('#brand').append('<option value="">-- Select model --</option>');
                            $.each(data, function(key, value){
                                $('#brand').empty();
                                $('#brand').focus;
                                $('select[name="brand"]').append('<option value="'+ value.id +'">' +value.name+ '</option>');

                                $('#model').empty();
                                $('#model').focus;
                                $('select[name="model"]').append('<option value="'+ value.model_id +'">' +value.model+ '</option>');

                            });
                        }else{
                            $('#brand').empty();
                        }
                    }
                });
            }else{
                $('#brand').empty();
            }
        });
    });
</script>


<!-- Script -->
<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

        $( "#Client" ).select2({
            tags: true,
            minimumInputLength: 3,
            maximumInputLength: 100,
            placeholder: "Оберіть клієнта",
            allowClear: true,
            ajax: {
                url: "{{route('find_client')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    /*console.log(response['phone'])
                    for(let key in response) {
                        console.log(key + ":", response[key]);
                    }*/
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });

        $('.task').select2({
            minimumInputLength: 3,
            maximumInputLength: 100,
            placeholder: "Оберіть послугу",
            ajax: {
                url: "{{route('find_jobs')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });

        $('.brand').select2({
            minimumInputLength: 2,
            maximumInputLength: 100,
            placeholder: "Оберіть бренд",
            ajax: {
                url: "{{route('find_brand')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });

        $('#vehicle-frame_number').on('select2:select', function (e) {
            console.log(e)
            var data = e.params.data;
            console.log(data)

        });

        $('#Client').on('select2:select', function (e) {
            var data = e.params.data;
            if (data.phone)
            {
                document.querySelector('#client-phone_number').value = data.phone;
            }
        });
    });
</script>

@endsection
