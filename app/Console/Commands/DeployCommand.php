<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class DeployCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command automatically deployed project';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $directory = 'storage/certs';
        $privateKey = $directory.'/jwt-rsa-4096-private.pem';
        $publicKey = $directory.'/jwt-rsa-4096-public.pem';

        Artisan::call('migrate');
        Artisan::call('db:seed');
        Artisan::call('l5-swagger:generate');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0775, true);
        }

        if (!File::exists($privateKey)) {
            $command1 = ['openssl', 'genpkey', '-algorithm', 'RSA', '-out', $privateKey, '-pkeyopt', 'rsa_keygen_bits:4096'];
            $process1 = new \Symfony\Component\Process\Process($command1);
            $process1->run();
        }
        else{
            $this->info('private.pem already exists.');
        }

        if (!File::exists($publicKey)) {
            $command2 = ['openssl', 'rsa', '-pubout', '-in', $privateKey, '-out', $publicKey];
            $process2 = new \Symfony\Component\Process\Process($command2);
            $process2->run();
        }
        else{
            $this->info('public.pem already exists.');
        }

        $this->info('Project successfully deployed!');
        return 0;
    }

}
