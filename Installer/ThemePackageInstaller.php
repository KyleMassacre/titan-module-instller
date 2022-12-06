<?php

namespace Titan\Core\Installer;

use Illuminate\Support\Facades\Config;
use Composer\Package\PackageInterface;
use Titan\Core\Installer\Contracts\BasePackageInstaller;
use Titan\Core\Installer\Exceptions\InstallerException;

class ThemePackageInstaller extends BasePackageInstaller
{

    protected string $packageType = "theme";

    protected function getDefaultInstallPath()
    {
        return "themes";
    }

    /**
     * @throws \Titan\Core\Installer\Exceptions\InstallerException
     */
    protected function getPackageName(PackageInterface $package): array|string
    {
        $name = $package->getPrettyName();
        $split = explode("/", $name);

        if (count($split) !== 2) {
            throw InstallerException::fromInvalidPackage($name, $this->packageType);
        }

        $splitNameToUse = explode("-", $split[1]);

        if (count($splitNameToUse) < 2) {
            throw InstallerException::fromInvalidPackage($name, $this->packageType);
        }

        if (array_pop($splitNameToUse) !== $this->packageType) {
            throw InstallerException::fromInvalidPackage($name, $this->packageType);
        }
        return implode('', array_map('strtolower', $splitNameToUse));
    }
}
