<?php

namespace Titan\Core\Installer\Contracts;

use Composer\Installer\BinaryInstaller;
use Composer\Installer\LibraryInstaller;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\PartialComposer;
use Composer\Util\Filesystem;
use Illuminate\Support\Facades\Config;
use Titan\Core\Installer\Exceptions\InstallerException;

abstract class BasePackageInstaller extends LibraryInstaller
{

    /**
     * @var string $type
     */
    protected string $packageType;

    /**
     * @var string $installDirectoryKey
     */
    protected string $installDirectoryKey = "install-dir";

    protected function getBaseInstallationPath()
    {
        if ($this->composer && $this->composer->getPackage()) {
            $extra = $this->composer->getPackage()->getExtra();

            if (array_key_exists($this->installDirectoryKey, $extra)) {
                return $extra[$this->installDirectoryKey];
            }
        }

        return $this->getDefaultInstallPath();
    }

    public function supports($packageType): bool
    {
        return $packageType === 'titan-'.$this->packageType;
    }

    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        return $this->getBaseInstallationPath() . '/' . $this->getPackageName($package);
    }

    /**
     * @throws \Titan\Core\Installer\Exceptions\InstallerException
     */
    protected function getPackageName(PackageInterface $package): array|string
    {
        $name = $package->getPrettyName();
        $split = explode("/", $name);
        $vendor = strtolower($split[0]);

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
        return $vendor."/".implode('', array_map('strtolower', $splitNameToUse));
    }

    protected abstract function getDefaultInstallPath();
}
