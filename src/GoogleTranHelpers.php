<?php

namespace GoogleTran\Translate;

class GoogleTranHelpers {

	const MAX_LEVEL = 5;

	public function from_array($array)
	{
	     foreach(get_object_vars($this) as $attrName => $attrValue)
	        $this->{$attrName} = $array[$attrName];
	}


    public function arrayToObject($a, $level=0)
    {
        if(!is_array($a)) {
            throw new InvalidArgumentException(sprintf('Type %s cannot be cast, array expected', gettype($a)));
        }

        if($level > self::MAX_LEVEL) {
            throw new OverflowException(sprintf('%s stack overflow: %d exceeds max recursion level', __METHOD__, $level));
        }

        $o = new \stdClass();
        foreach($a as $key => $value) {
            if(is_array($value)) { // convert value recursively
                $value = $this->arrayToObject($value, $level+1);
            }
            $o->{$key} = $value;
        }
        return $o;
    }
	
}