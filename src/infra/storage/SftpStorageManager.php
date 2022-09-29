<?php


namespace coyote\alertdatex\infra\storage;

use coyote\alertdatex\domain\SshKeyInterface;
use coyote\alertdatex\domain\StorageManagerInterface;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SFTP;

class SftpStorageManager implements StorageManagerInterface
{
    private $key;
    private $host;
    private $user;
    private $port;

    private $sftp;



    public function __construct(string $host, string $user, string $keyFileName, $port = 22)
    {
        $this->key = PublicKeyLoader::load(file_get_contents($keyFileName), false);
        $this->host = $host;
        $this->user = $user;
        $this->port = $port;

        echo "\n>> Connecting to $host";
        $this->sftp = $this->connect();
        echo "\n>> login $user";
        $this->login();
    }

    private function connect() {
        return new SFTP($this->host, $this->port);
    }

    private function login(): bool
    {
        $this->sftp->login($this->user, $this->key);
        if (!$this->sftp->isConnected()) {
            throw new \Exception('Login Failed');
        }
        return true;
    }


    public function store(string $filePathOrigin, string $filePathDestination): bool
    {
        echo "\n>> storing $filePathOrigin >> $filePathDestination";
        return $this->sftp->put($filePathDestination, $filePathOrigin, SFTP::SOURCE_LOCAL_FILE);
    }

    public function listFolder(string $folderPath): array
    {
        echo "\n>> listing '$folderPath'";
        return $this->sftp->nlist($folderPath);
    }

}