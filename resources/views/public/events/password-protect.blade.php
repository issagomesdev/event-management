<!DOCTYPE html>
<html>
<head>
    <title>Proteção por Senha</title>
</head>
<body>

    @if (session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif
    
    <form method="GET" action="{{ url()->current() }}" style="display: flex; justify-content: center; flex-direction: column; align-items: center;">

        <div class="field" style="margin-bottom: 1em">
            <label for="password">User:</label>
            <input type="text" name="user" id="user" required>
        </div>

        <div class="field" style="margin-bottom: 1em">
            <label for="password">Senha:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">Prosseguir</button>
    </form>
</body>
</html>
