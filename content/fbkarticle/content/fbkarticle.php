<?php
/**
 * 
* @copyright Copyright (C) 2012 Jean-Luc TRYOEN. All rights reserved.
* @license GNU/GPL
*
* Version 1.0
*
*/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );
define('PF_REGEX_FBK_PATTERN', "#{fbkarticle (.*?)}#s");
define('PF_REGEX_FBKLIKE_PATTERN', "#{fbklike}#s");

/**
* FacebookArticle Content Plugin
*
*/
class plgContentFbkArticle extends JPlugin
{

	/**
	* Constructor
	*
	* @param object $subject The object to observe
	* @param object $params The object that holds the plugin parameters
	*/
	function __construct( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}

	/**
	* Example prepare content method in Joomla 1.5
	*
	* Method is called by the view
	*
	* @param object The article object. Note $article->text is also available
	* @param object The article params
	* @param int The 'page' number
	*/
	function onPrepareContent( &$article, &$params, $limitstart )
	{
		return $this->OnPrepareRow($article);	
	}

 	/**
	* Example prepare content method in Joomla 1.6/1.7/2.5
	*
	* Method is called by the view
	*
	* @param object The article object. Note $article->text is also available
	* @param object The article params
	*/   
	function onContentPrepare($context, &$row, &$params, $page = 0)
	{
		return $this->OnPrepareRow($row);
	}
	
	function onPrepareRow(&$row) 
	{  
		//Escape fast
        if (!$this->params->get('enabled', 1)) {
            return true;
        }
 		if ( strpos( $row->text, '{fbk' ) === false ) {
            return true;
		}
		preg_match_all(PF_REGEX_FBK_PATTERN, $row->text, $matches);
		// Number of plugins
		$count = count($matches[0]);
		 // plugin only processes if there are any instances of the plugin in the text
		if ($count) {
			
			$document = JFactory::getDocument();
			for ($i = 0; $i < $count; $i++)
			{
				$_result = array();
				if (@$matches[1][$i]) {
					$inline_params = $matches[1][$i];										
					$pairs = explode(';', trim($inline_params));
					foreach ($pairs as $pair) {
						$pos = strpos($pair, "=");
						$key = substr($pair, 0, $pos);
						$value = substr($pair, $pos + 1);							
						$_result[$key] = $value;
					}
					$p_content = $this->fbkarticle($_result);
					$row->text = str_replace("{fbkarticle " . $matches[1][$i] . "}", $p_content, $row->text);
				}					
			}			
		}
		preg_match_all(PF_REGEX_FBKLIKE_PATTERN, $row->text, $matches);
		// Number of plugins
		$count = count($matches[0]);
		 // plugin only processes if there are any instances of the plugin in the text
		if ($count) {
			$document = JFactory::getDocument();
			for ($i = 0; $i < $count; $i++)
			{
				$p_content = $this->fbklike();
				$row->text = str_replace($matches[0][$i],$p_content, $row->text);
			}
		}	
		return true;                
	}
    
    
    
 	/**
	* Function to insert FacebookArticle world
	*
	* Method is called by the onContentPrepare or onPrepareContent
	*
	* @param string The text string to find and replace
	*/       
	function fbkarticle( $_params )
	{
		$content = "";		
		if (is_array( $_params )== false)
		{
			return  "errorf:" . print_r($_params, true);
		}
		$document = JFactory::getDocument();
		$document->addScript(JUri::root() . '/plugins/content/fbkarticle/facebook.js');		
		$content = sprintf('<div class="fb-post" data-href="https://www.facebook.com/permalink.php?story_fbid=%s&amp;id=%s" 
						data-show-text="true">&nbsp;</div>',
						$_params['article'],
						$_params['id']);		
		return $content;			
	}
	
	/**
	* Function to insert FacebookLike
	*
	* Method is called by the onContentPrepare or onPrepareContent
	*
	* @param string The text string to find and replace
	*/       
	function fbklike()
	{		
		$document = JFactory::getDocument();
		$document->addScript(JUri::root() . '/plugins/content/fbkarticle/facebook.js');				
		$content = '<div class="fb-like" data-share="true" data-width="450" data-show-faces="true">&#160;</div>';
		return $content;			
	}
}
