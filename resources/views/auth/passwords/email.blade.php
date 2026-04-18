<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ URL::to('assets/css/bootstrap-datetimepicker.min.cs') }}s">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
</head>

<style>
    body {
        background: linear-gradient(35deg, #f4823c, #07da9763);

    }
</style>

<body>
    <br><br><br>
    <br><br><br>
    <br><br><br>
    <br><br><br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style=" border: 2px solid black; border-radius: 20px">
                    <div class="card-header">{{ __('Mot de passe Oublier') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="" action="">
                            @csrf

                            <div class="row mb-3">


                                <div class="col-12 col-sm-6">
                                    <div class="form-group local-forms">
                                        <strong style="font-size: 18px; color: black;">Entrer votre E-mail<span
                                                class="login-danger">*</span></strong>
                                        <input type="email" class="form-control" name="e-mail"
                                            placeholder="E-mail" required autocomplete="email" autofocus>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group local-forms">
                                        <strong style="font-size: 18px; color: black;">Ancien Mot de passe<span
                                                class="login-danger">*</span></strong>
                                        <input type="text" class="form-control" name="mdp"
                                            placeholder="" required autocomplete="text" autofocus>
                                    </div>
                                </div>


                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Envoyer') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
