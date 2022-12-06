<?php

namespace Titan\Core\Installer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Illuminate\Support\Facades\Log;
use Titan\Core\Installer\Contracts\BasePackageInstaller;

class ModuleInstallerPlugin implements PluginInterface
{

    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new ModulePackageInstaller($io, $composer);

        $composer->getInstallationManager()->addInstaller($installer);

    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        $installer = new ModulePackageInstaller($io, $composer);

        $composer->getInstallationManager()->removeInstaller($installer);
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        $installer = new ModulePackageInstaller($io, $composer);

        $composer->getInstallationManager()->removeInstaller($installer);
    }
}
