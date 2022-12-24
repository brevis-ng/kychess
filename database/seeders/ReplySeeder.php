<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('replies')->insert([
            ['content' => '您好，老板！同ip多账号不符合该项活动优惠要求。谢谢！【开元棋牌269.cc】', 'created_at' => now(), 'updated_at' => now()],
            ['content' => '您好，老板！感谢您的耐心等待哦，您申请的优惠活动已经通过了呢，彩金已经为您派送成功了哦，请您登录会员账号查收一下呢，谢谢！', 'created_at' => now(), 'updated_at' => now()],
            ['content' => '您好，老板！并未查询到您连赢哦，请您仔细核对一下，谢谢！【开元棋牌269.cc】', 'created_at' => now(), 'updated_at' => now()],
            ['content' => '您好，老板！经查询，美东当日您并未娱乐视讯游戏，请您仔细核对，谢谢！【开元棋牌269.cc】', 'created_at' => now(), 'updated_at' => now()],
            ['content' => '您好，老板！经查询，您同台多注，不符合活动要求哦，谢谢！【开元棋牌269.cc】', 'created_at' => now(), 'updated_at' => now()],
            ['content' => '您好，老板！经查询，您在真人视讯连赢中出现和局哦~根据我司真人视讯第三惠活动规则：如参加活动过程中出现和局退回本金情况，连赢局数将重新计算，不允许同一账户同一牌局同时作多项投注，故您不符合此项优惠哦~谢谢！【开元棋牌269.cc】', 'created_at' => now(), 'updated_at' => now()],
            ['content' => '您好，老板！我司【真人视讯第三惠】活动规定：需要您完成指定连赢局数，即可申请对应彩金，您当前连赢局数为：7请您完成连赢8局后再次联系我们哦，谢谢！【开元棋牌269.cc】', 'created_at' => now(), 'updated_at' => now()],
            ['content' => '老板，您好你未下载开元棋牌269的app,没能达到要求，请您下载app在来申请，谢谢！', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
