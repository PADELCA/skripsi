<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
   content="width=device-width, initial-scale=1">

<title>

```
Login Apotik Riski
```

</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{

    background:
    linear-gradient(
        135deg,
        #2563eb,
        #10b981
    );

    height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;
}

.login-card{

    width:420px;

    background:white;

    padding:40px;

    border-radius:25px;

    box-shadow:
    0 10px 30px rgba(0,0,0,.2);
}

.logo{

    text-align:center;

    margin-bottom:25px;
}

.logo h2{

    font-weight:700;

    color:#2563eb;
}

.logo p{

    color:#666;
}

</style>

</head>

<body>

<div class="login-card">

```
<div class="logo">

    <h2>

        💊 APOTIK LIMAS

    </h2>

    <p>

        AI Forecasting System

    </p>

</div>

<form
    method="POST"
    action="{{ route('login') }}">

    @csrf

    <div class="mb-3">

        <label>

            Email

        </label>

        <input
            type="email"
            name="email"
            class="form-control"
            required>

    </div>

    <div class="mb-3">

        <label>

            Password

        </label>

        <input
            type="password"
            name="password"
            class="form-control"
            required>

    </div>

    <button
        type="submit"
        class="btn btn-primary w-100">

        Login

    </button>

</form>
```

</div>

</body>

</html>
