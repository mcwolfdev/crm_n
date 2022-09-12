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

                        <form action="{{ route('create_job_input_fields') }}" method="post" enctype="multipart/form-data">
                            {{--<input type="hidden" name="_csrf" value="JHqK8d90WYuRtb6Mhc3N0X0hcEVwXuiZvobtgFmgBYxXO_-QrS1g4dqC7eHngIWDRBIyNzQssOuPwITtFM5NtQ==">--}}
                            @csrf
                            <div class="row client-info">
                                <div class="col-md-8">
                                    <div class="form-group field-client-full_name required">
                                        <label class="control-label" for="client-full_name">ПІБ Клієнта</label>
                                        @foreach($client_all as $c)
                                            {{--{{$c->getVehicle()->where('client_id', 3)}}--}}
                                            @foreach($c->getVehicle()->where('client_id', 3) as $cc)
                                                {{$cc->vehicle_id}}
                                            @endforeach
                                        @endforeach


                                        <select class="js-example-basic-single form-control" id="Client"
                                                name="Client" onchange="clientfunc(this);">
                                            <option></option>
                                            @foreach($client_all as $client)
                                                <option data-phone="{{$client->phone}}"
                                                        data-frame="LJLTCK"
                                                        data-brand="BRP"
                                                        data-model="Outlander MAX XTP 1000"
                                                        value="{{$client->id}}">{{$client->name}}</option>
                                            @endforeach

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
                                            <input type="text" id="client-phone_number" name="client-phone_number" class="form-control" data-inputmask='"mask": "+380 (99) 999-99-99"' data-mask>
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
                                                name="vehicle-frame_number">
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
                                        <select class="brand form-control" id="brand" name="brand">
                                            <option></option>
                                            @foreach($brands_all as $brand)
                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                            @endforeach

                                        </select>

                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group field-model-name required">
                                        <label class="control-label" for="model-name">Модель</label>
                                        <select class="model form-control" id="model" name="model">
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
                                <div class="task">
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
                                            @if (Session::has('success'))
                                                <div class="alert alert-success text-center">
                                                    <p>{{ Session::get('success') }}</p>
                                                </div>
                                            @endif
                                            <table class="table table-bordered" id="dynamicAddRemove">
                                                <tr>
                                                    <th>Найменування</th>
                                                    <th>Дія</th>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" required oninvalid="this.setCustomValidity('Заповніть це поле')" oninput="setCustomValidity('')" name="addMoreInputFields[0][subject]" placeholder="Введіть назву" class="form-control " />
                                                    </td>
                                                    <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary"><i class="fa fa-plus"></i></button></td>
                                                </tr>
                                            </table>
                                            {{--<button type="submit" class="btn btn-outline-success btn-block">Save</button>--}}
                                        {{--</form>--}}

                                        <div class="help-block"></div>
                                    </div>        </div>

                                <div class="task">
                                    <span class="line"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group field-job-addition">
                                        <label class="control-label" for="job-addition"><i class="fas fa-car-crash"></i> Пошкодження та несправності (якщо такі присутні):</label>
                                        <textarea id="job-addition" class="form-control" name="Job[addition]" rows="6"></textarea>

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



    <style>
        .breadcrumbs {
            /*padding: 8px 15px;*/
            padding: 0;
            margin-bottom: 20px;
            list-style: none;
            background-color: #f5f5f5;
            border-radius: 4px;
        }

        .task-wrapper > .task > .title {
            position: relative;
            z-index: 2;
            font-size: 25px;
            background: url(/img/bg.png);
            text-shadow: 1px 1px 0 #fff;
            padding: 0 12px 0 10px;
        }

        .task-wrapper > .task > .line {
            display: inline-block;
            border-top: 2px dashed rgba(0,0,0,0.24);
            height: 2px;
            width: 100%;
            position: absolute;
            left: 0;
            top: 17px;
        }

        .task-wrapper > .task {
            text-align: center;
            position: relative;
            height: 30px;
            margin-bottom: 5px;
        }
    </style>

{{--multiinput--}}

<script type="text/javascript">
    var i = 0;
    $("#dynamic-ar").click(function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td><input type="text" name="addMoreInputFields[' + i +
            '][subject]" placeholder="Введіть назву" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field"><i class="fas fa-trash-alt"></i></button></td></tr>'
        );
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>




<script src="{{asset('js/jquery.inputmask.min.js')}}"></script>
<script>
    $(function () {

        $('[data-mask]').inputmask()
    });
</script>

<script>
    function clientfunc(btn) {
        /*console.log('phone');
        phone = $(btn).data('url');
        console.log(phone);*/

            let element = document.getElementById("Client");
            let phone = element.options[element.selectedIndex].getAttribute("data-phone");
            let frame = element.options[element.selectedIndex].getAttribute("data-frame");
            let brand = element.options[element.selectedIndex].getAttribute("data-brand");
            let model = element.options[element.selectedIndex].getAttribute("data-model");

        $('#client-phone_number').val(phone);

        $('#vehicle-frame_number').empty();
        $('#vehicle-frame_number').focus;
        $('select[name="vehicle-frame_number"]').append('<option>' +frame+ '</option>');

        $('#brand').empty();
        $('#brand').focus;
        $('select[name="brand"]').append('<option>' +brand+ '</option>');

        $('#model').empty();
        $('#model').focus;
        $('select[name="model"]').append('<option>' +model+ '</option>');


    }

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
                            console.log(data);
                            if(data){
                                $('#model').empty();
                                $('#model').focus;
                                $('#model').append('<option value="">-- Select model --</option>');
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

{{--<!-- Script -->
<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

        $( "#selClient" ).select2({
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
                    for(let key in response) {
                        console.log(key + ":", response[key]);
                    }
                    $('#client-phone_number').val(response);
                    /*console.log(response)
                    for (const key in response) {
                        console.log(key); // выводит ключи в объекте
                    }*/
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });

    });
</script>--}}
@endsection
