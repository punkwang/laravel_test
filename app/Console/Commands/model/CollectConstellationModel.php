<?php


namespace App\Console\Commands\model;


use App\Models\Constellation;
use App\Models\ConstellationItem;
use GuzzleHttp\Client;

class CollectConstellationModel
{
    private $_http;



    protected function _httpGet($url){
        $response=$this->_http->request('GET',$url);
        return $response->getBody();
    }

    public function __construct()
    {
        $this->_http=new Client([
            'headers'=>[
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36',
            ]
        ]);
    }

    protected function _getInfo($id){
        $html=$this->_httpGet("http://astro.click108.com.tw/daily_{$id}.php?iAstro={$id}");
        preg_match('/\?iAcDay=(.*?)&/is',$html,$matches);
        $date=$matches[1];
        preg_match('/<div class="TODAY_CONTENT">(.*?)<\/div>/is',$html,$matches);
        $html=$matches[1];
        $titles=[
            '整體運勢',
            '愛情運勢',
            '事業運勢',
            '財運運勢'
        ];
        $infoItems=[];
        foreach ($titles as $title){
            preg_match("/{$title}(.*?)：/",$html,$matches);
            $score=mb_strpos($matches[1],'☆');
            if($score===false){
                $score=5;
            }

            preg_match("/{$title}.*?：<\/span><\/p><p>(.*?)<\/p>/",$html,$matches);
            $detail=$matches[1];
            $infoItems[]=[
                'title'=>trim($title),
                'score'=>$score,
                'detail'=>trim($detail),
                'date'=>trim($date)
            ];
        }
        return $infoItems;
    }

    protected function _getItems(){
        $html=$this->_httpGet('http://astro.click108.com.tw/');
        preg_match_all('/<li class="STAR_[0-9]+">.*?href=".*?daily_([0-9]+)\.php.*?">(.*?)<\/a><\/li>/',$html,$matchs);
        $items=[];
        foreach ($matchs[1] as $k=>$v){
            $items[]=[
                'id'=>trim($v),
                'title'=>trim($matchs[2][$k]),
                'info'=>$this->_getInfo($v)
            ];
        }

        return $items;
    }


    public function all(){
        return $this->_getItems();
    }

    public function save(){
        $data=$this->all();

        if(empty($data)) return;

        foreach ($data as $one){
            $constellation=Constellation::query()->where('title',$one['title'])->first();
            if(!$constellation){
                $constellation=new Constellation();
                $constellation->title=$one['title'];
                $constellation->save();
            }
            if(empty($one['info'])){
                continue;
            }

            foreach ($one['info'] as $item){
                $constellationItem=ConstellationItem::query()
                    ->where('constellation_id',$constellation->id)
                    ->where('title',$item['title'])
                    ->where('dated',strtotime($item['date']))
                    ->first();
                if(!$constellationItem){
                    $constellationItem=new ConstellationItem();
                    $constellationItem->constellation_id=$constellation->id;
                    $constellationItem->title=$item['title'];
                    $constellationItem->dated=strtotime($item['date']);
                    $constellationItem->detail=$item['detail'];
                    $constellationItem->score=$item['score'];
                    $constellationItem->save();
                }
            }
        }
    }
}
