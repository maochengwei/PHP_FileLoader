<?php
class FileLoader
{
	private $key_index_arr = array(0);
	private $subkey_index_arr = array(2);
	private $multi_key_chr = '_';
	private $columns_arr = array(1);
	private $delimiter = "\t";
	/**
	 * @param array $keys    ��ȡ�ļ��е�Ҫ��Ϊkey����
	 * @param array $columns ��ȡ�ļ���ָ������
	 */
	public function __construct($keys=array(),$columns=array())
	{
		if(is_array($keys) && count($keys) > 0)
		{
			$this->key_index_arr = $keys;
		}
		if(is_array($columns) && count($columns) > 0)
        {
                $this->columns_arr = $columns;
        }
	}
	public function set($name,$val)
	{
		$this->$name = $val;
	}
	
	/**
	 * ���ַ�������ʽ����һ���ļ�
	 * @param string $filename
	 * @param bool $allLine
	 * @return boolean|multitype:string 
	 */
	public function LoadFileToString($filename, $allLine=false)
	{
		if($filename == "" || !file_exists($filename) || !($fp = fopen($filename,"r")))
		{
			return false;
		}
		$hash = array();
		while(!feof($fp))
		{
			$line = trim(fgets($fp));
			if($line == "")
			{
				continue;
			}
			$tmp_arr = explode($this->delimiter,$line);
			$key = "";
			foreach($this->key_index_arr as $index)
			{
				$key .= $tmp_arr[$index].$this->multi_key_chr;
			}
			$key = trim($key,$this->multi_key_chr);
			if($allLine)
			{
				$value = $line;
			}
			else
			{
				$value= "";
				foreach($this->columns_arr as $index)
				{
					$value .= $tmp_arr[$index].$this->multi_key_chr;
				}
				$value = trim($value,$this->multi_key_chr);
			}
			if($value != "0")
			{
				$hash[$key] = $value;
			}
		}
		return $hash;
	}
	/**
	 * ���ļ����뵽һ��hash����
	 * @param string $filename
	 * @return array
	 */
	public function LoadFileToHash ($filename)
	{
		if ($filename == "" || ! file_exists($filename) || ! ($fp = fopen($filename, "r")))
		{
			return false;
		}
		$hash = array();
		while (! feof($fp))
		{
			$line = trim(fgets($fp));
			if ($line == "")
			{
				continue;
			}
			$tmp_arr = explode($this->delimiter, $line);
			
			$key = "";
			foreach ($this->key_index_arr as $index)
			{
				$key .= $tmp_arr[$index] . $this->multi_key_chr;
			}
			$key = trim($key, $this->multi_key_chr);
	
			$subkey = "";
			foreach ($this->key_index_arr as $index)
			{
				$subkey .= $tmp_arr[$index] . $this->multi_key_chr;
			}
			$subkey = trim($subkey, $this->multi_key_chr);
						
			$value = "";
			foreach ($this->columns_arr as $index)
			{
				$value .= $tmp_arr[$index] . $this->multi_key_chr;
			}
			$value = trim($value, $this->multi_key_chr);

			if ($value != "0")
			{
				$hash[$key][$subkey] = $value;
			}
		}
		return $hash;
	}
}
?>
