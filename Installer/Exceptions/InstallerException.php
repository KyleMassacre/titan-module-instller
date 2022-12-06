<?php

namespace Titan\Core\Installer\Exceptions;

class InstallerException extends \Exception
{
    public static function fromInvalidPackage(string $invalidPackageName, string $packageType): self
    {
        return new self(
            "Ensure your package's name ({$invalidPackageName}) is in the format <vendor>/<name>-<{$packageType}>"
        );
    }
}
