
<style>
    .container-register {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        font-family: 'Segoe UI', sans-serif;
    }

    .card-register {
        display: flex;
        width: 800px;
        height: 600px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-radius: 15px;
        overflow: hidden;
    }

    .left-side {
        background: #fff;
        padding: 40px;
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

    .form-control {
        margin-bottom: 15px;
        padding: 10px;
        width: 100%;
        border: none;
        background-color: #eee;
    }

    .register-btn {
        background-color: #00c853;
        color: white;
        border: none;
        padding: 10px;
        width: 100%;
        border-radius: 30px;
        font-weight: bold;
    }

    .login-btn {
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

<div class="container-register">
    <div class="card-register">
        <!-- Left: Register Form -->
        <div class="left-side">
            <h3 class="mb-4">Register</h3>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ old('name') }}" required>

                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>

                <input type="text" name="address" class="form-control" placeholder="Address" value="{{ old('address') }}" required>

                <input type="text" name="phone_numeber" class="form-control" placeholder="Phone Number" value="{{ old('phone_number') }}" required>

                <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}" required>

                <input type="password" name="password" class="form-control" placeholder="Password" required>

                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>

                <button type="submit" class="register-btn">REGISTER</button>
            </form>
        </div>

        <!-- Right: Welcome Message -->
        <div class="right-side">
            <h2>Selamat Datang!</h2>
            <p>Sudah punya akun? Silakan login dan mulai gunakan layanan kami</p>
            <a href="{{ route('login') }}" class="login-btn">SIGN IN</a>
        </div>
    </div>
</div>