<?php
$token = '15_nxyMJDDvxLYNWdGztrC6tnymioDv6QHqErGm41IDQNosW2hTGgzsQW3uT8AuhWEOcNA9RS06wQaQg1hJ82meJfz1i2nYHstBBZPHH15cu_BofqUqEvU9yIiV2_lJwowCFCtEPugiXblh-IEeICVdAGAQKD';
$arr = array(
	'scene'=>'3cb7878a12dea593c4f59c87b475b31e'
);

$url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$token;

$curl = curl_init();
//设置抓取的url
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
curl_setopt($curl, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
//设置post方式提交
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json" )); 
curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($arr));
//执行命令
$data = curl_exec($curl);
//关闭URL请求
curl_close($curl);



$filename="fei.png";///要生成的图片名字 
  
  
$file = fopen("./".$filename,"w");//打开文件准备写入 
fwrite($file,$data);//写入 
fclose($file);//关闭 
  
$filePath = './'.$filename; 
  
//图片是否存在 
if(!file_exists($filePath)) 
{ 
  echo 'createFail'; 
  exit(); 
}
echo 'ok';
