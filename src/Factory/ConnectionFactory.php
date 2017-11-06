<?php
namespace Gungnir\DataSource\Factory;

class ConnectionFactory
{
    /**
     * @param string $dsn
     * @param string|null $username
     * @param string|null $password
     * @param array|null $options
     *
     * @return null|\PDO
     */
    public function makePdoConnection(
        string $dsn,
        string $username = null,
        string $password = null,
        array  $options  = null
    ): ?\PDO
    {
        $configuration = [$dsn];

        if ($username) $configuration[] = $username;
        if ($password) $configuration[] = $password;
        if ($options)  $configuration[] = $options;

        return new \PDO(...$configuration);
    }
}