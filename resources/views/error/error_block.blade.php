@extends('layouts.app')

@section('content')


<div class="container">
    <div class="bg-image"></div>

    <div class="bg-text">
        <h1><i class="fas fa-times-circle"></i> Помилка</h1>
        <p>Ви не можете переглянути цю інформацію!</p>
    </div>
    <script>
/*        Swal.fire({
            icon: 'error',
            title: 'Помилка',
            showConfirmButton: false,
            timer: 1500
        })*/
let timerInterval
Swal.fire({
    icon: 'error',
    title: 'Помилка',
    html: '<p>Ви не можете переглянути цю інформацію!</p>',
    timer: 2500,
    timerProgressBar: false,
    showConfirmButton: false,
    didOpen: () => {

    },
    willClose: () => {
        clearInterval(timerInterval)
    }
}).then((result) => {
    /* Read more about handling dismissals below */
    if (result.dismiss === Swal.DismissReason.timer) {
        window.history.back ();
    }
})
    </script>
</div>

    <style>
        body, html {
            height: 100%;
        }

        * {
            box-sizing: border-box;
        }

        .bg-image {
            /* The image used */
            background-image: url("photographer.jpg");

            /* Add the blur effect */
            filter: blur(8px);
            -webkit-filter: blur(8px);

            /* Full height */
            height: 100%;

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        /* Position text in the middle of the page/image */
        .bg-text {
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(238, 69, 69, 0.4); /* Black w/opacity/see-through */
            color: white;
            font-weight: bold;
            border: 3px solid #f1f1f1;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            width: 80%;
            padding: 20px;
            text-align: center;
        }
    </style>

@endsection
