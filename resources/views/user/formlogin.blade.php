
<h1>Login Siswa</h1>
@if($errors->any()) <div style="color:red;">{{ $errors->first() }}</div> @endif
<form method="POST" action="{{ route("login.submit") }}">
    @csrf
    <input type="text" name="username" placeholder="NISN">
    <input type="password" name="password" placeholder="Password (NISN)">
    <button type="submit">Login</button>
</form>

