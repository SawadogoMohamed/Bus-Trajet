<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Authentification - Sotraco</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  
  <style>
    /* Couleurs Sotraco : Bleu #004aad, Orange #ff6600 */

    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

    * {
      box-sizing: border-box;
      margin: 0; padding: 0;
      font-family: 'Montserrat', sans-serif;
    }

    body {
      background: #066b2e;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      
    }

    .container {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      max-width: 400px;
      width: 100%;
      padding: 40px 30px;
      text-align: center;
    }

    .logo img {
      width: 150px;
      margin-bottom: 25px;
    }

    .login-form .title {
      font-size: 28px;
      font-weight: 700;
      color: #004aad;
      margin-bottom: 30px;
      letter-spacing: 1.5px;
    }

    .form-control {
      width: 100%;
      padding: 12px 15px;
      font-size: 16px;
      border: 2px solid #ddd;
      border-radius: 8px;
      margin-bottom: 20px;
      transition: 0.3s;
    }

    .form-control:focus {
      border-color: #f4e000;
      outline: none;
      box-shadow: 0 0 8px rgba(255, 102, 0, 0.7);
    }

    .btn-submit {
      background-color: #f4e000;
      border: none;
      color: white;
      font-weight: 700;
      padding: 14px 0;
      font-size: 18px;
      width: 100%;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn-submit:hover {
      background-color: #066b2e;
    }

    /* Message d'erreur */
    .invalid-feedback {
      color: #d93025;
      font-weight: 600;
      margin-bottom: 15px;
      display: block;
      text-align: left;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="logo">
      <img src="/images/logo_sotraco.jpeg" alt="Logo Sotraco" />
    </div>

    <form action="{{ route('login') }}" method="post" class="login-form">
     
      @csrf

      @error('email')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span><br />
      @enderror
      <input id="email" type="email" placeholder="E-mail" class="form-control @error('email') is-invalid @enderror"
        name="email" value="{{ old('email') }}" required autocomplete="off" autofocus /><br />

      <input id="password" type="password" placeholder="Mot de passe"
        class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off" /><br />
      @error('password')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span><br />
      @enderror
      <button type="submit" class="btn-submit">Valider</button>

      <br />
    </form>
  </div>
</body>

</html>
