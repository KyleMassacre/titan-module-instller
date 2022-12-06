<?php

namespace Titan\Core\Installer;

use Titan\Core\Installer\Contracts\BasePackageInstaller;

class ModulePackageInstaller extends BasePackageInstaller
{
    protected string $packageType = "module";

    protected function getDefaultInstallPath()
    {
        return "Modules";
    }
}
