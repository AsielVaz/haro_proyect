<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'env.php';

class Conector
{
    private string $servername;
    private string $database;
    private string $username;
    private string $password;
    private int $port;
    private string $charset;
    private ?mysqli $connection = null;

    public function __construct()
    {
        $this->servername = haroEnv('DB_HOST');
        $this->database = haroEnv('DB_DATABASE');
        $this->username = haroEnv('DB_USERNAME');
        $this->password = haroEnv('DB_PASSWORD');
        $this->port = (int) haroEnv('DB_PORT', '3306');
        $this->charset = haroEnv('DB_CHARSET', 'utf8mb4');

        if ($this->port < 1 || $this->port > 65535) {
            throw new RuntimeException('DB_PORT no contiene un puerto válido.');
        }
    }

    private function conectar(): mysqli
    {
        if ($this->connection instanceof mysqli) {
            return $this->connection;
        }

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $this->connection = new mysqli(
                $this->servername,
                $this->username,
                $this->password,
                $this->database,
                $this->port
            );
            $this->connection->set_charset($this->charset);
        } catch (mysqli_sql_exception $exception) {
            error_log('Error de conexión MySQL: ' . $exception->getMessage());
            throw new RuntimeException('No se pudo conectar a la base de datos.', 0, $exception);
        }

        return $this->connection;
    }

    public function ejecutar(string $query): mysqli_result|bool
    {
        try {
            return $this->conectar()->query($query);
        } catch (mysqli_sql_exception $exception) {
            error_log('Error de consulta MySQL: ' . $exception->getMessage());
            throw new RuntimeException('No se pudo ejecutar la consulta.', 0, $exception);
        }
    }

    public function ultimoIdInsertado(): int
    {
        return $this->conectar()->insert_id;
    }

    protected function escapar(string $value): string
    {
        return $this->conectar()->real_escape_string($value);
    }

    public function __destruct()
    {
        if ($this->connection instanceof mysqli) {
            $this->connection->close();
        }
    }
}
