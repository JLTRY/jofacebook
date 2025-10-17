<?php
/**
* @copyright Copyright (C) 2025 Jean-Luc TRYOEN. All rights reserved.
*
* Version 1.0.0
*
* @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
* @link        https://www.jltryoen.fr
*/


namespace JLTRY\Plugin\Content\JOFbkPost\Extension;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\Event\SubscriberInterface;
use Joomla\CMS\Event\Content\ContentPrepareEvent;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Component\ComponentHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

define('PF_REGEX_FBK_ARTICLE_PATTERN', "#{fbkarticle (.*?)}#s");
define('PF_REGEX_FBK_POST_PATTERN', "#{fbkpost (.*?)}#s");
define('PF_REGEX_FBK_LIKE_PATTERN', "#{fbklike}#s");

/**
* JoFbArticle Content Plugin
*
*/
class JOFbkPost extends CMSPlugin implements SubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            'onContentPrepare'  => 'onPrepareRow'
        ];
    }

    function addScripts($appid){
        /** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
        $wa = Factory::getApplication()->getDocument()->getWebAssetManager();

        // Register custom item without json definition
        $wa->registerScript('facebook-jssdk', "plugins/content/jofbkpost/src/Extension/facebook-jssdk.js", [], [], []);
        // And use it later
        $wa->useScript('facebook-jssdk');
        $wa->addInlineScript('window.fbAsyncInit = function() {
                FB.init({
                  appId      : "'. $appid .'",
                  xfbml      : true,
                  version    : "v23.0"
            });};', ['position' => 'after'], [], ['facebook-jssdk']);
    }
    
    function onPrepareRow(ContentPrepareEvent $event)
    {  
        //Escape fast
        if (!$this->getApplication()->isClient('site')) {
            return;
        }

        if (!$this->params->get('enabled', 1)) {
            return true;
        }
        // use this format to get the arguments for both Joomla 4 and Joomla 5
        // In Joomla 4 a generic Event is passed
        // In Joomla 5 a concrete ContentPrepareEvent is passed
        [$context, $article, $params, $page] = array_values($event->getArguments());
        if ($context !== "com_content.article" && $context !== "com_content.featured") return;
        if (strpos( $article->text, '{fbk' ) === false) {
            return true;
        }
        $params = ComponentHelper::getParams('com_jofacebook');
        $appid = $params->get('appid');
        if($appid == -1) {
            $appid  = $this->params->get('appid', -1);
        }
        if ($appid == -1) {
            
            $this->getApplication()->enqueueMessage(Text::_('PLG_JO_FACEBOOK_UNKNOW_APPID'), 'error');
            return;
        }
        preg_match_all(PF_REGEX_FBK_ARTICLE_PATTERN, $article->text, $matches);
        // Number of plugins
        $count = count($matches[0]);
         // plugin only processes if there are any instances of the plugin in the text
        if ($count) {
            $document = Factory::getDocument();
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
                    $this->addScripts($appid);
                    $p_content = $this->fbkarticle($matches[0][$i], $_result);
                    $article->text = str_replace("{fbkarticle " . $matches[1][$i] . "}", $p_content, $article->text);
                }
            }
        }
        preg_match_all(PF_REGEX_FBK_POST_PATTERN, $article->text, $matches);
        // Number of plugins
        $count = count($matches[0]);
         // plugin only processes if there are any instances of the plugin in the text
        if ($count) {
            for ($i = 0; $i < $count; $i++)
            {
                $_result = array();
                if ($appid != -1) {
                    $_result['appid'] = $id;
                }
                if (@$matches[1][$i]) {
                    $inline_params = $matches[1][$i];
                    $pairs = explode(';', trim($inline_params));
                    foreach ($pairs as $pair) {
                        $pos = strpos($pair, "=");
                        $key = substr($pair, 0, $pos);
                        $value = substr($pair, $pos + 1);
                        $_result[$key] = $value;
                    }
                    $this->addScripts($appid);
                    $p_content = $this->fbkpost($matches[0][$i], $_result);
                    $article->text = str_replace("{fbkpost " . $matches[1][$i] . "}", $p_content, $article->text);
                }
            }
        }
        preg_match_all(PF_REGEX_FBK_LIKE_PATTERN, $article->text, $matches);
        // Number of plugins
        $count = count($matches[0]);
         // plugin only processes if there are any instances of the plugin in the text
        if ($count) {
            for ($i = 0; $i < $count; $i++)
            {
                $this->addScripts($appid);
                $_result = array();
                $p_content = $this->fbklike($matches[0][$i], $_result);
                $article->text = str_replace($matches[0][$i],$p_content, $article->text);
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
    function fbkarticle($text, $_params )
    {
        $content =  $text . "<br>". Text::_('PLG_JO_FACEBOOK_ARTICLE_SYNTAX');
        if (!is_array( $_params ) || !array_key_exists('id',$_params) || !array_key_exists('article',$_params))
        {
            $this->getApplication()->enqueueMessage($text . "<br>". Text::_('PLG_JO_FACEBOOK_ARTICLE_SYNTAX'), 'error');
        }
        else 
        {
            $content = sprintf('<div class="fb-post" data-href="https://www.facebook.com/permalink.php?story_fbid=%s&amp;id=%s" 
                            data-show-text="true">&nbsp;</div>',
                            $_params['article'],
                            $_params['id']);
        }
        return $content;
    }
    
     /**
    * Function to insert FacebookArticle world
    *
    * Method is called by the onContentPrepare or onPrepareContent
    *
    * @param string The text string to find and replace
    */
    function fbkpost($text, $_params)
    {
        $content = $text . "<br>". Text::_('PLG_JO_FACEBOOK_POST_SYNTAX');
        if (!is_array( $_params ) || !array_key_exists('profile',$_params) || !array_key_exists('post',$_params ))
        {
            $this->getApplication()->enqueueMessage($text . "<br>". Text::_('PLG_JO_FACEBOOK_POST_SYNTAX') . "<br>" . print_r($_params, true), 'error');
        }
        else {
            $content = sprintf('<div class="fb-post" data-href="https://www.facebook.com/%s/posts/%s" 
                        data-show-text="true">&nbsp;</div>',
                        $_params['profile'],
                        $_params['post']);
        }
        return $content;
    }

    /**
    * Function to insert FacebookLike
    *
    * Method is called by the onContentPrepare or onPrepareContent
    *
    * @param string The text string to find and replace
    */       
    function fbklike($text, $_params)
    {
        $content = '<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="" data-layout="" data-action="" data-size="" data-share="true"></div>';
        return $content;
    }
}
