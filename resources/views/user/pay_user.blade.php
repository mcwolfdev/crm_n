@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <nav class="breadcrumbs">
                    <ol class="breadcrumb" style="--bs-breadcrumb-margin-bottom: 0;">
                        <li class="breadcrumb-item navbar-right"><a href="/">Головна</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Оплата</li>
                    </ol>
                </nav>
            <h1>Оплата [{{$user->name}}]</h1>

            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success" href="#"><i class="fa fa-plus"></i> Додати користувача</a>
                    <input type="date">
                </div>

                <table id="pay" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>ПІБ Клієнта</th>
                        <th>Телефон</th>
                        <th>VIN номер</th>
                        <th>Т.З.</th>
                        <th>Сума</th>
                        <th>Оплачено</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($jobs as $job)
                        <tr>
                            <td>{{$job->id}}</td>
                            <td>{{$job->getClientFullName()}}</td>
                            <td>{{$job->getClientPhoneNumber()}}</td>
                            <td>{{$job->Vehicle->frame_number}}</td>
                            <td>{{$job->Vehicle->Moodel->Brand->name}} - {{$job->Vehicle->Moodel->name}}</td>
                            <td>{{number_format($job->getPerformerPrice(),2,'.', ' ')}} грн.</td>
                            <td><input type="checkbox">{{$job->isAllJobsHasPerformerPrice() ? '' : ' <span style="color:red; font-weight: bold">!</span>'}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    $(function () {
        $("#pay").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "searching": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],

        }).buttons().container().appendTo('#pay_wrapper .col-md-6:eq(0)');

        $('#pay tbody').on('click', 'tr', function () {
            $(this).toggleClass('selected');
            console.log((this).toggleClass('selected'))
        });
    });
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
