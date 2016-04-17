<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Config;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instalação do Tenda form';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $this->info(posix_getuid()); //0 é root
        // if($this->option('force')){
        //     $this->info('com força');
        // }
        $c = Config::find('Questionario');
        if (!$c || $this->option('force')) {
            if(!$c){
                $c = new Config();
                $c->_id = 'Questionario';
            }
            $c->config = [
                'camera' => false,
                'disclaimer' => [
                    'active' => false,
                    'text' => ''
                ],
                'opening_url' => 'img/opening.png'
            ];
            $c->save();
            echo "Configuração padrão salva.\n";
        }
        $c = Config::find('Camera');
        if (!$c || $this->option('force')) {
            if(!$c){
                $c = new Config();
                $c->_id = 'Camera';
            }
            $c->hpad = 241;
            $c->vpad = 261;
            $c->rfactor = 65;
            $c->frame_path = public_path('img/frame.png');
            $c->save();
            echo "Configuração de camera salva.\n";
        }
    }
}
