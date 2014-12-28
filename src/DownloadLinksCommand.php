<?php

namespace HtmlDownload;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadLinksCommand extends Command {
    public function configure()
    {
        $this->setName('download-links')
            ->setDescription('Download HTML pages from config/settings.php using Guzzle.');
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
                $client = new Client();
                $response = $client->get($download['url'])->getBody();
                file_put_contents($file_name, $response);
            }
        }
    }
}