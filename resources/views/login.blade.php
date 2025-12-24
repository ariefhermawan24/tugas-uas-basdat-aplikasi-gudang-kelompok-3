<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>DriveGO - Auth</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../drivego/source/css/login.css">

<style>
body{
    background: linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)), url("/asset/nwh1.jpeg");
    background-size: cover;
    height: 100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    color:white;
    font-family:Arial, sans-serif;
}

.card-auth{
    position:relative; /* PENTING */
    background:rgba(30,30,30,.4);
    backdrop-filter:blur(12px);
    border-radius:16px;
    width:100%;
    max-width:420px;
    padding:30px;
    box-shadow:0 10px 30px rgba(0,0,0,.6);
}


/* radio hidden */
input[type=radio]{
    display:none;
}

/* FORM DEFAULT */
.form-login,
.form-register{
    display:none;
}

#login:checked ~ .form-login{
    display:block;
}

#register:checked ~ .form-register{
    display:block;
}

.form-control{
    background:#2e2e2e;
    border:1px solid #444;
    color:white;
}

.form-control:focus{
    background:#1e1e1e;
    color:white;
    box-shadow:0 0 6px rgba(0,123,255,.6);
}

.switch{
    color:#00bcd4;
    cursor:pointer;
    text-decoration:none;
}

.switch:hover{
    text-decoration:underline;
}

.btn-login{
    background:#92c7ff97;
    border:none;
}

.btn-register{
    background:#5e6364;
    border:none;
}

.close-btn{
    position:absolute;
    top:12px;
    right:16px;
    font-size:26px;
    color:white;
    text-decoration:none;
    opacity:0.7;
    transition:0.2s;
}

.close-btn:hover{
    opacity:1;
    color:#ff6b6b;
}

</style>
</head>

<body>

<div class="card-auth">

    <!-- RADIO CONTROLLER -->
    <input type="radio" name="auth" id="login" checked>
    <input type="radio" name="auth" id="register">
    <a href="/" class="close-btn">&times;</a>


    <!-- LOGIN -->
    <div class="form-login">
        <h4 class="text-center mb-3"> Login </h4>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" placeholder="Enter email">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" class="form-control" placeholder="Enter password">
        </div>

        <button class="btn btn-login w-100 mb-3">Login</button>

        <p class="text-center">
            Belum punya akun?
            <label for="register" class="switch">Sign Up</label>
        </p>
    </div>

    <!-- REGISTER -->
    <div class="form-register">
        <h4 class="text-center mb-3">Create Account</h4>

         <div class="mb-3">
            <label>Nama Perusahaan</label>
            <input type="text" class="form-control" placeholder="Full name">
        </div>

    <div class="mb-3">
        <label class="form-label">Jenis Perusahaan</label>
            <select class="form-select bg-dark text-white border-secondary">
                <option selected disabled>-- Jenis Perusahaan --</option>
                <option>elektronik</option>
                <option>Texstil</option>
                <option>Konstruksi</option>
                <option></option>
                <option></option>
                <option>Van</option>
                <option>Taxi</option>
                <option>Ambulans</option>
                <option>Mobil Listrik</option>
                <option>Sepeda Motor Listrik</option>
                <option>Other / Lainnya</option>
            </select>
    </div>
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control" placeholder="Full name">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" placeholder="Email">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" class="form-control" placeholder="Password">
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" class="form-control" placeholder="Confirm Password">
        </div>

        <button class="btn btn-register w-100 mb-3">Sign Up</button>

        <p class="text-center">
            Sudah punya akun?
            <label for="login" class="switch">Login</label>
        </p>
    </div>

</div>

</body>
</html>
