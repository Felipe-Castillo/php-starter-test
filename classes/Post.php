<?php
class Post
{
	
	private static function post_request($data=[],$url)
	{
	$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	// execute!
	$response = curl_exec($ch);
	curl_close($ch);
	
	return json_decode($response,true);
		
	}
	private static function get_request()
	{
		$ch = curl_init();
		curl_setopt_array($ch, array(
		CURLOPT_URL => 'https://api.dev.graphs.social/v4/graphs?containers_ids=5c6f0eff3039354935b3553a',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => false,
		CURLOPT_FOLLOWLOCATION => true
		));
		$output = curl_exec($ch);
	$query=json_decode($output,true);
	return $query;
	}


	private static function delete_request($url, $arr=[])
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$result = json_decode($result);
curl_close($ch);
return $result;
}

private static function put_request($url,$arr=[])
{
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS,$arr);
$response = curl_exec($ch);
$result = json_decode($response);
curl_close($ch);
return $result;
}

	public static function insert($post)
	{
		$access_token=$_SESSION["access_token"];
		$data=array("access_token"=>$access_token,"entity"=>"post","container_id"=>"5c6f1b403039354a6d865be2","title"=>$post["title"],"description"=>$post["description"]);
		$result=self::post_request($data,'https://api.dev.graphs.social/v4/graphs');
		//at this point we have created a new post so we need to reload  the cache
	   $query=self::get_request();
	   file_put_contents("cache/list.js", serialize($query));
		return $result;
	}
	public static function get()
	{
		
					
						if (file_exists("cache/list.js"))
						{
							
						$query = unserialize(file_get_contents("cache/list.js"));
							
						}
						else
							{
	//lets create the first cache file
							
							$query=self::get_request();
						file_put_contents("cache/list.js", serialize($query));
							}
							$query = unserialize(file_get_contents("cache/list.js"));
						return $query;
	}


	public static function update($arr)
	{

	$access_token=$_SESSION["access_token"];
	$data=array("access_token"=>$access_token,"id"=>$arr['id'],"title"=>$arr['title'],"description"=>$arr['description']);
	$result=self::put_request('https://api.dev.graphs.social/v4/graphs/',$data);
	//at this point we have updated a  post so we need to reload  the cache

	$query=self::get_request();
	file_put_contents("cache/list.js", serialize($query));

	return $result;	

	}
	public static function find($id)
	{
			$ch = curl_init();
						curl_setopt_array($ch, array(
						CURLOPT_URL => 'https://api.dev.graphs.social/v4/graphs?containers_ids=5c6f0eff3039354935b3553a&entities_ids='.$id,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_POST => false,
						CURLOPT_FOLLOWLOCATION => true
						));
						$output = curl_exec($ch);
						$query=json_decode($output,true);
						return $query;
	}


	public static function delete($id)
	{
		$access_token=$_SESSION["access_token"];
		$data=array("access_token"=>$access_token,"id"=>$id);
		$result=self::delete_request('https://api.dev.graphs.social/v4/graphs/',$data);
	
		$query=self::get_request();
	    file_put_contents("cache/list.js", serialize($query));
		return $result;
	}


public function redirect($url) {
header("Location: $url");
}
	
}