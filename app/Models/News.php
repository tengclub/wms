<?php
namespace App\Models;

class News extends SysModel
{
	protected $table = 'news';
	public static function getLabels()
	{
		return [
			'id'=>'主键自增',
			'type_id'=>'分类',
			'type_id2'=>'分类2',
			'flag'=>'自定义属性',
			'channel_id'=>'频道',
			'status'=>'状态',
			'click'=>'点击量',
			'money'=>'需要金额',
			'title'=>'标题',
			'short_title'=>'简略标题',
			'color'=>'标题颜色',
			'writer'=>'作者',
			'source'=>'来源',
			'lit_pic'=>'缩略图',
			'pubdate'=>'发布日期',
			'member_user'=>'会员ID',
			'keywords'=>'关键字',
			'scores'=>'分数',
			'good_post'=>'好评',
			'bad_post'=>'差评',
			'vote_id'=>'评论ID',
			'is_not_post'=>'是否允许评论',
			'description'=>'描述',
			'file_name'=>'文件名',
			'tack_id'=>'类型（内容、连接）',
			'weight'=>'权重',
			'lit_pic2'=>'缩略图2',
			'content'=>'内容',
			'create_time'=>'创建时间',
			'create_user'=>'创建人',
			'update_time'=>'更新时间',
			'update_user'=>'修改人',
			'templet_file'=>'模板',
		];
	}
}
