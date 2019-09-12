<?php

namespace App\Console\Commands;

use App\Console\Commands\model\CollectConstellationModel;
use Illuminate\Console\Command;

class CollectConstellation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'collect:constellation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取星座信息';

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
        $model=new CollectConstellationModel();
        $model->save();
    }
}
