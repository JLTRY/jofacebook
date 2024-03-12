<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgButtonFbkArticle extends JPlugin {

	
	function onDisplay($name)
	{
		$js =  "function sampleFbkArticleClick(editor,id) {
			txt = prompt('Please enter ID of article','123');
			if (!txt) return;
			jInsertEditorText('{fbkarticle id='+id+';article='+txt+'}', editor);
		}";
		$params = $this->params;
		
		$id = $params->get('id','?');
		
		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($js);
		
		$button = new JObject;
		$button->modal = false;
		$button->class = 'btn';
		$button->link = '#';
		$button->text = JText::_('Insert Facebook article');
		$button->name = 'fbk';
		$button->onclick = 'sampleFbkArticleClick(\''.$name. '\',' . $id . '); return false;';
		
		return $button;
	}
}
