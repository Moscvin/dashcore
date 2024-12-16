@extends('core.layouts.auth')

@section('content')
    <div class="container-fluid spark-screen">
        <div class="flex-center position-ref full-height">
            <div class="box-body">
                <div class="callout callout-danger">
                    <h4> Attenzione</h4>

                    <p>La pagina non esiste oppure non hai l'autorizzazione per accedere a questa pagina.</p>

                </div> <a href="#" onclick="window.history.back()" class="btn btn-primary">ritorna</a>
            </div>
        </div>
    </div>
    <style>
        html, body {
            background-color: #ecf0f5;
            color: #636b6f;            
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
@endsection
