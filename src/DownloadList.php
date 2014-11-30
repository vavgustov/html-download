<?php

namespace HtmlDownload;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadList extends Command {
    public function configure()
    {
        $this->setName('download-links')
            ->setDescription('Download HTML pages from config/settings.php using curl.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $settings = require __DIR__ . "/../config/settings.php";

        foreach ($settings['download'] as $download) {
            // prepare file system
            $filesystem = new Filesystem();
            $folder = $settings['directory']['folder'] . "/" . $download['folder'];
            $filesystem->mkdir($folder, $settings['directory']['mode']);
            $file_name = $folder . "/" . date('m_d_y') . ".html";

            if (!$filesystem->exists($file_name)) {
                $command = "curl -o {$file_name} {$download['url']}";
                shell_exec($command);
            }
        }
    }
}