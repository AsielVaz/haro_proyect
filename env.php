<?php

/**
 * Carga una sola vez el archivo .env ubicado en la raíz del proyecto.
 * No depende de Composer y funciona tanto desde web como desde CLI/cron.
 */
function haroCargarEnv(): array
{
    static $variables = null;

    if (is_array($variables)) {
        return $variables;
    }

    $ruta = __DIR__ . DIRECTORY_SEPARATOR . '.env';
    if (!is_readable($ruta)) {
        throw new RuntimeException('No se encontró el archivo .env en la raíz del proyecto.');
    }

    $variables = [];
    $lineas = file($ruta, FILE_IGNORE_NEW_LINES);
    if ($lineas === false) {
        throw new RuntimeException('No se pudo leer el archivo .env del proyecto.');
    }

    foreach ($lineas as $numero => $linea) {
        $linea = trim($linea);
        $linea = ltrim($linea, "\xEF\xBB\xBF");

        if ($linea === '' || str_starts_with($linea, '#') || str_starts_with($linea, ';')) {
            continue;
        }

        if (str_starts_with($linea, 'export ')) {
            $linea = trim(substr($linea, 7));
        }

        if (!str_contains($linea, '=')) {
            throw new RuntimeException('Línea inválida en .env: ' . ($numero + 1));
        }

        [$clave, $valor] = array_map('trim', explode('=', $linea, 2));
        if (!preg_match('/^[A-Z_][A-Z0-9_]*$/i', $clave)) {
            throw new RuntimeException('Nombre de variable inválido en .env: ' . ($numero + 1));
        }

        $longitud = strlen($valor);
        if ($longitud >= 2) {
            $primero = $valor[0];
            $ultimo = $valor[$longitud - 1];
            if (($primero === '"' && $ultimo === '"') || ($primero === "'" && $ultimo === "'")) {
                $valor = substr($valor, 1, -1);
            }
        }

        $variables[$clave] = $valor;
        $_ENV[$clave] = $valor;
        $_SERVER[$clave] = $valor;
        putenv($clave . '=' . $valor);
    }

    return $variables;
}

function haroEnv(string $clave, ?string $predeterminado = null): string
{
    $variables = haroCargarEnv();
    if (array_key_exists($clave, $variables)) {
        return $variables[$clave];
    }
    if ($predeterminado !== null) {
        return $predeterminado;
    }

    throw new RuntimeException("Falta la variable obligatoria $clave en el archivo .env.");
}

