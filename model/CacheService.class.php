<?php
class CacheService
{
    protected $time,$dir,$id,$entity,$sth,$param,$data,$result;
	
    public function __construct($cacheTime, $cacheDir, $cacheId, $entity, $sth){
	    $this->time = $cacheTime;
		$this->dir = $cacheDir;
		$this->id = $cacheId;
		$this->entity = $entity;
		$this->sth = $sth;
		
		$this->param = array('cacheDir' => $this->dir, 'lifeTime' => $this->time);
		
		$this->cache = new Cache_Lite($this->param);
	}

    public function setData(){
	    $data = $this->cache->get($this->id);
		$this->data = unserialize($data);
		if(isset($this->data)){
		    return true;
		}
		else{
		    return false;
		}
	}
	
	public function getData(){
	    if($this->setData()){
		    return $this->data;
		}
	}

    public function fetch()
	{
	    if(class_exists($this->entity))
		{
			while($row = $this->sth->fetchObject($this->entity))
			{
				$res[] = $row;
				$this->result[] = $row;
				#$serialize_r = serialize($res);
				#$this->cache->save($serialize_r, $this->id);
			}
		
			return $this;
		}
		else
		{
			while($row = $this->sth->fetchObject('stdClass'))
			{
				$res[] = $row;
				$this->result[] = $row;
				#$serialize_r = serialize($res);
				#$this->cache->save($serialize_r, $this->id);
			}
		
			return $this;
		}
	}

    public function returnObject()
	{
	    return $this->result;
	}    
}
/**
*
 self::$cache = new Cache_Lite(array('cacheDir' => LzConfigCache::cachePath(), 'lifeTime' => $time));
            $id = LzConfigCache::cacheLoadMethodId('load');
            
            if ($data = self::$cache->get($id)) {
                $this->results = unserialize($data);
                return $this->results;
            } else {
                while ($row = $sth->fetchObject($sql->getEntity())) {
                    $this->results[] = $row;
                    $serializable_result = serialize($this->results);
                    self::$cache->save($serializable_result, $id);
                }
                return $this->results;
            }
*/
?>