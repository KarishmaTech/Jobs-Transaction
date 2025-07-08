<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
</head>
<body>
    <h2>Student Registration</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color: red;">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('student.register') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="First Name" required><br><br>
      
        <input type="email" name="email" placeholder="Email" required><br><br>
      
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required><br><br>
        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="{{ route('student.login.form') }}">Login here</a></p>
</body>
</html>
