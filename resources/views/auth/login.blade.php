<style>
    .container-login {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        font-family: 'Segoe UI', sans-serif;
    }

    .card-login {
        display: flex;
        width: 800px;
        height: 500px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-radius: 15px;
        overflow: hidden;
    }

    .left-side {
        background: #fff;
        padding: 50px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .right-side {
        background: linear-gradient(to right, #00c853, #00e676);
        color: white;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 30px;
    }

    .social-icons {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .social-icons a {
        border: 1px solid #ccc;
        border-radius: 50%;
        padding: 10px;
        margin: 0 5px;
        text-decoration: none;
        color: #000;
    }

    .form-control {
        margin-bottom: 15px;
        padding: 10px;
        width: 100%;
        border: none;
        background-color: #eee;
    }

    .sign-in-btn {
        background-color: #00c853;
        color: white;
        border: none;
        padding: 10px;
        width: 100%;
        border-radius: 30px;
        font-weight: bold;
    }

    .sign-up-btn {
        background-color: transparent;
        border: 2px solid white;
        padding: 10px 25px;
        border-radius: 30px;
        color: white;
        text-transform: uppercase;
        font-weight: bold;
        margin-top: 20px;
        text-decoration: none;
    }
</style>
@if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-login">
    <div class="card-login">
        <!-- Left: Sign In -->
        <div class="left-side">
            <h2>Sign in</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <input type="text" name="username" placeholder="Email or Username" class="form-control" required autofocus>
                <input type="password" name="password" placeholder="Password" class="form-control" required>

                <button type="submit" class="sign-in-btn">SIGN IN</button>
            </form>
        </div>

        <!-- Right: Sign Up -->
        <div class="right-side">
            <h2>Halo, Teman!</h2>
            <p>Daftarkan diri anda dan mulai gunakan layanan kami segera</p>
            <a href="{{ route('register') }}" class="sign-up-btn">SIGN UP</a>
        </div>
    </div>
</div>