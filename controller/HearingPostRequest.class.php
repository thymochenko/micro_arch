<?php

class HearingPostRequest {

    protected $transaction;

    public function __construct()
	{
        Transaction::open();
        $this->transaction = Transaction::get();
    }

    public function observerPost()
	{
        if (isset($_POST)){
            foreach ($_POST as $k => $value_contex)
			{
			    if(!is_array($value_contex))
				{
				     $context[$k] = htmlspecialchars(strip_tags(addslashes($value_contex)));
			    	$action_prefix[$k] = $context[$k];
				    if($context[$k]=='insert')
				    {
                        $context[$k] = Helper::upperPrimaryLetter($context[$k],null);
                        $action_prefix[$k] = Helper::upperPrimaryLetter($action_prefix[$k],null);
				    }
                }
			}
               
            if(isset($context['insert']))
			{    
			    
                if($this->transaction)
				{
                    $class = $action_prefix['insert'] . 'Action';
                    $obj = new $class;
					
                    $obj->store($context['insert']);
                }
				
                $this->transaction = null;
            }
            if(isset($context['update']))
			{
                if ($this->transaction)
				{
                    $class = $action_prefix['update'] . 'Action';
                    $obj = new $class;
                    $obj->update($context['update']);
                }
                $this->transaction = null;
            }
            if (isset($context['delete']))
			{
                if ($this->transaction)
				{
                    $class = $action_prefix['delete'] . 'Action';
                    $obj = new $class;
                    $obj->destroy($context['delete']);
                }
                $this->transaction = null;
            }
            //ajax request and events callback
            if($this->transaction and isset($context)) {
                foreach ($context as $k => $cont) {
                    if (class_exists($cont)) {
                        $obj = new $cont;
                        $obj->{"$k"}();
                    }
                }

                $this->transaction = null;
                return true;
            }
        }
    }
}

?>