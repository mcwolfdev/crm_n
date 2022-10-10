@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <nav class="breadcrumbs">
                    <ol class="breadcrumb" style="--bs-breadcrumb-margin-bottom: 0;">
                        <li class="breadcrumb-item navbar-right"><a href="/">Головна</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Налаштування</li>
                    </ol>
                </nav>
            <h1>Налаштування</h1>

           <div class="card">
                <div class="card-header">
                    <a class="btn btn-success" href="#"><i class="fa fa-plus"></i></a>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true"><i class="fas fa-edit"></i> Основні</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false"><i class="fas fa-hammer"></i> Системні</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Contact</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false" disabled>Disabled</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <form action="#" method="post" class="needs-validation" novalidate>
                                <input type="hidden" name="user_id" value="#">
                                @csrf
                                <div class="card-body">
                                    <h4>Вартість нормагодини</h4>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                        </div>
                                        <input type="text" name="hourly_rate" class="form-control" placeholder="Ім'я" value="#" required>
                                    </div>
                                    <h4>Курс USD</h4>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        </div>
                                        <input type="text" name="currency_usd" class="form-control" placeholder="Курс долара" value="#" required>
                                    </div>
                                    <h4>Курс EUR</h4>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">€</span>
                                        </div>
                                        <input type="text" name="currency_eur" class="form-control" placeholder="Курс євро" value="#" required>
                                    </div>

                                    <button class="btn btn-success" type="submit"><i class="far fa-save"></i> Зберегти</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            <form action="#" method="post" class="needs-validation" novalidate>
                                <input type="hidden" name="user_id" value="#">
                                @csrf
                                <div class="card-body">

                                    <h4>Сесія користувача (хв.)</h4>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <select class="form-control" name="user_session" required>
                                            <option></option>
                                            <option value="3">3 хв.</option>
                                            <option value="5">5 хв.</option>
                                            <option value="10">10 хв.</option>
                                        </select>
                                    </div>

                                    <h4>Очікування розриву сесії (сек.)</h4>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <select class="form-control" name="disconnecting_user_session" required>
                                            <option></option>
                                            <option value="5">5 сек.</option>
                                            <option value="10">10 сек.</option>
                                            <option value="15">15 сек.</option>
                                        </select>
                                    </div>

                                    <button class="btn btn-success" type="submit"><i class="far fa-save"></i> Зберегти</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                            3...
                        </div>
                        <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">
                            4...
                        </div>
                    </div>
                </div>





                </div>
            </div>
        </div>
    </div>
</div>

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

@endsection
