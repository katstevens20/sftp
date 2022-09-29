<?php

namespace tests\infra\storage;

use coyote\alertdatex\infra\storage\SftpStorageManager;
use PHPUnit\Framework\TestCase;

class SftpStorageManagerTest extends TestCase
{
    const FILE_NAME = 'atestfile.txt';
    const PATH_NAME = '/upload/';


    public function testSftpUploadFile()
    {
        $isFileUploaded = false;
        try {
            $ftpStorage = new SftpStorageManager('sftp', 'foo', 'ssh_host_ed25519_key');

            $isFileUploaded = $ftpStorage->store('./' . self::FILE_NAME, self::PATH_NAME . self::FILE_NAME);

        } catch (\Exception $e) {
            exit('>> Err: ' . $e->getMessage());
        }
        $this->assertTrue($isFileUploaded);
    }


    public function testSftpListFolder()
    {
        $result = [];
        try {
            $ftpStorage = new SftpStorageManager('sftp', 'foo', 'ssh_host_ed25519_key');

            $result = $ftpStorage->listFolder(self::PATH_NAME);
        } catch (\Exception $e) {
            exit('>> Err: ' . $e->getMessage());
        }
        $this->assertGreaterThan(1, $result);
    }
}