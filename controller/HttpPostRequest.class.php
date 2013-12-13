<?php 
class HearingPostRequest
{
	protected $transaction;
	
	public function __construct()
	{
	    Transaction::open();
		$this->transaction = Transaction::get();
	}
	
	public function observerPost()
	{
		if (isset($_POST) and $context=HttpObjectInstance::getValues('post'))
		{    
			foreach($context as $k=>$value_contex)
			{    
				$context[$k]=htmlspecialchars(strip_tags(addslashes($value_contex)));
				
				if (isset($context['insert'])):
			    
				    if($this->transaction)
				    {
				        $obj=new $context['insert'];
				        $obj->store($context['insert'] . 'Record');
				    }
				
				$this->transaction=null;
				
				return true;
				
			elseif(@$context['update']): 
			    
				if($this->transaction)
				{
				    $obj=new $context['update'];
				    $obj->update($context['update'] . 'Record');
				}
				
				$this->transaction=null;
				
				return true;
				
			elseif($context['delete']):
			    
				if($this->transaction)
				{
				    $obj=new $context['delete'];
				    $obj->destroy($context['delete'] . 'Record');
				}
				
				$this->transaction=null;
				
				return true;
				
			elseif($context['default'] and $context['method']):
			    
				
				if($this->transaction)
				{
				    $obj=new $context['default'];
				    $obj->{"{$context['method']}"}($context['default'] . 'Record');
				}
				$this->transaction=null;
				
			return true;
			else:
				return true;
		    endif;
		    }
		}
	}
}
?>