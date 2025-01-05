<?php

// Formulir Pendaftaran Pengguna
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
</head>
<body>
    <h1>Form Pendaftaran</h1>

    <form action="store" method="POST">
        <?php echo csrf_field(); ?>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>

        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" required>
        <br>

        <label for="kelas">Kelas:</label>
        <input type="text" id="kelas" name="kelas" required>
        <br>

        <label for="jurusan">Jurusan:</label>
        <input type="text" id="jurusan" name="jurusan" required>
        <br>

        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="siswa">Siswa</option>
            <option value="admin">Admin</option>
            <option value="guru">Guru</option>
            <option value="sekretaris">Sekretaris</option>
        </select>
        <br>

        <button type="submit">Daftar</button>
    </form>
</body>
</html>
