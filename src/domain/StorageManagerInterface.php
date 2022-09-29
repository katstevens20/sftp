<?php

namespace coyote\alertdatex\domain;

interface StorageManagerInterface {
    public function store(string $filePathOrigin, string $filePathDestination): bool;
    public function listFolder(string $folderPath): array;
}