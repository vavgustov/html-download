<?php namespace HtmlDownload;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadLinksCommand extends Command {

    /**
     * Configuration.
     */
    public function configure()
    {
        $this->setName('download-links')
            ->setDescription('Download HTML pages from config/settings.php using Guzzle.');
    }

    /**
     * Execute command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $settings = require __DIR__ . "/../config/settings.php";

        foreach ($settings['download'] as $download) {            
            $folder = $settings['directory']['folder'] . "/" . $download['folder'];            
            $file_name = $folder . "/" . date('m_d_y-H_i_s') . ".html";
            
            $filesystem = new Filesystem();
            if (!$filesystem->exists($file_name)) {                           
                $filesystem->mkdir($folder, $settings['directory']['mode']);

                // download html
                $client = new Client();
                $response = $client->get($download['url'])->getBody();
                file_put_contents($file_name, $response);
            }
        }
    }

}