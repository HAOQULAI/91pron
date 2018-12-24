<?php 
require 'detailPage.php';
use DiDom\Document;
use DiDom\Query;

function listPage($baseUrl)
{
	$header = "Accept-Language:zh-CN,zh;q=0.9\r\nUser-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko)Chrome/51.0.2704.106 Safari/537.36\r\nX-Forwarded-For:".random_ip()."\r\nreferer:http://91porn.com/index.php";
	
	$currentPage = 1;

	$maxPage = 2;	//自行更改页数
	$urllist = array();
	while ($currentPage <= $maxPage) {
		$url = $baseUrl."&page=".$currentPage;
		//echo "\n".$url."\n";
		try {
			$listPage = new Document($url, true, $header);

			$list = $listPage->find('//*[@class="listchannel"]/a[1]', Query::TYPE_XPATH);
          	
			foreach ($list as $k=>$item) {
				$title = $item->getAttribute('title');
              	$urllist[($currentPage-1)*19+$k][title]=$title;
				//echo "\n".$title."\n";
				$itemUrl = $item->getAttribute('href');
				//echo $itemUrl."\n";
				//singlePage($itemUrl, $title);
              	$header = "Accept-Language:zh-CN,zh;q=0.9\r\nUser-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko)Chrome/51.0.2704.106 Safari/537.36\r\nX-Forwarded-For:".random_ip()."\r\nreferer:".$itemUrl."\r\nContent-Type: multipart/form-data; session_language=cn_CN";
				$page = new Document($itemUrl, true, $header);
				$videoUrl = $page->find('source')[0]->getAttribute('src');
              	$urllist[($currentPage-1)*19+$k][Url]=$videoUrl;              	
			}
		} catch (Exception $e) {
			echo $e;
		}
		
		$currentPage += 1;
	}
	return $urllist;
}

//listPage("http://91porn.com/v.php?category=top&viewtype=basic");	//本月最热

$urllist1 = listPage("http://www.91porn.com/v.php?category=mf&viewtype=basic");//收藏最多

// listPage("http://91porn.com/v.php?category=md&viewtype=basic");		//本月讨论
?>
<?php
                	foreach ($urllist1 as $key => $value) {  ?>
			<h2><?php echo $value["title"]?></h2>
	                    <video id="my-video" controls style="width: 50%">
    <source src="<?php echo $value["Url"]?>" type="video/mp4" />
						</video>
                	<?php }	?>
          
               			 
	                  
                	
