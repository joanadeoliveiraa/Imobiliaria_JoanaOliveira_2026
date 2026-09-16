<?php

// Executar na linha de comandos: php base_de_dados/exportar.php
if (PHP_SAPI !== 'cli') {
    exit('Disponível apenas na linha de comandos.');
}

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$connection = Illuminate\Support\Facades\DB::connection();
$config = $connection->getConfig();
if (!in_array($config['driver'], ['mysql', 'mariadb'], true)) {
    throw new RuntimeException('Este exportador requer MySQL ou MariaDB.');
}

$destination = __DIR__.'/olive_properties.sql';
$temporary = $destination.'.tmp';
$command = [
    'mysqldump', '--single-transaction', '--quick', '--routines', '--events',
    '--triggers', '--hex-blob', '--no-tablespaces', '--set-gtid-purged=OFF',
    '--default-character-set=utf8mb4',
    '--host='.$config['host'], '--port='.($config['port'] ?? 3306),
    '--user='.$config['username'], '--result-file='.$temporary,
    $config['database'],
];
$environment = getenv();
$environment['MYSQL_PWD'] = $config['password'] ?? '';
$process = proc_open($command, [0 => STDIN, 1 => STDOUT, 2 => STDERR], $pipes, null, $environment);
if (!is_resource($process) || proc_close($process) !== 0) {
    if (is_file($temporary)) {
        unlink($temporary);
    }
    throw new RuntimeException('A exportação falhou. A cópia anterior foi preservada.');
}
if (!rename($temporary, $destination)) {
    throw new RuntimeException('Não foi possível guardar a exportação.');
}
echo 'Exportação concluída: '.$destination.PHP_EOL;
