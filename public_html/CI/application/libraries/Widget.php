<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Widget Plugin 
 * 
 * Install this file as application/plugins/widget_pi.php
 * 
 * @version:     0.1
 * $copyright     Copyright (c) Wiredesignz 2009-03-24
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
class Widget
{
	public function __construct()
	{
        $this->_assign_libraries();
    }
    
    function run($name)
    {        
        $args = func_get_args();
		
		$_EXT	=	".php";
		
		$require_path	=	str_replace("//", "/", APPPATH.'/controllers/'.$name.$_EXT);
		
		
		if( file_exists($require_path) == false )
		{
			echo "NoFile : ".$require_path."<BR>";
		}//	end if
		
		require_once $require_path;
		
		$arrTemp	=	explode("/", $name);
		$name 		= $arrTemp[ count($arrTemp)-1 ];
        $name 		= ucfirst($name);
        
        $widget = new $name();
        return call_user_func_array(array(&$widget, 'run'), array_slice($args, 1));
    }
    
    function render($view, $data = array()) {
        extract($data);
        include APPPATH.'/views/widgets/'.$view.$_EXT;
    }

    function load($object) {
        $this->$object =& load_class(ucfirst($object));
    }

    function _assign_libraries() {
        $ci =& get_instance();
        foreach (get_object_vars($ci) as $key => $object) {
            $this->$key =& $ci->$key;
        }
    }
} 