<?php

/**
 *
 * @author Martin Belobrad, martin@belobrad.cz
 * @copyright Copyright (c) 2008-2011 Martin Belobrad
 */
class Sc_Controller_Action_Helper_FlashMessenger
    extends Zend_Controller_Action_Helper_Abstract {

    /**
     * Singleton instance
     * @var Sc_Controller_Action_Helper_FlashMessenger
     */
    public static $instance;

	/**
	 * Translation class
	 * @var class Zend_Translator
	 */
	protected $_translator = null;

	/**
	 * FlashMessenger for messages
	 * @var class Zend_Controller_Action_Helper_FlashMessenger
	 */
	protected $_msgs = null;

	/**
	 * Messages
	 * @var array
	 */
	protected $_msgs_cache = array();

	/**
	 * FlashMessanger for errors
	 * @var class Zend_Controller_Action_Helper_FlashMessenger
	 */
	protected $_errs = null;

	/**
	 * Errors
	 * @var array
	 */
	protected $_errs_cache = array();

	/**
	 * Constructor
	 * @return void
	 */
	public function __construct()
	{
        // log
        $this->_log = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('log');

		// init messages messenger
		if (null == $this->_msgs)
		{
			$this->_msgs = new Zend_Controller_Action_Helper_FlashMessenger;
			$this->_msgs->setNamespace('admin_messages');
			$this->_msgs_cache = $this->_msgs->getMessages();
			$this->_msgs->clearMessages();
		}

		// init errors messenger
		if (null == $this->_errs)
		{
			$this->_errs = new Zend_Controller_Action_Helper_FlashMessenger;
			$this->_errs->setNamespace('admin_errors');
			$this->_errs_cache = $this->_errs->getMessages();
			$this->_errs->clearMessages();
		}

		// init Zend Translate
		if (null == $this->_translator && Zend_Registry::isRegistered('Zend_Translate'))
		{
			$this->_translator = Zend_Registry::get('Zend_Translate');
		}
	}

    /**
     * Return singleton instance
     * @return Sc_Controller_Action_Helper_FlashMessenger
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }

        return self::$instance;
    }

	/**
	 * Add message with autodetect type message (error or message)
	 * @param mixed $message String or Exception or Zend_Exception
	 * @param bool 	$hop	 Display message in next page load
	 * @param array $args	 Arguments for message string
	 * @return self
	 */
	public function addMessage($message, $hop=true, $args = array(), $disableTranslator = true)
	{
		if(is_object($message) && (!$message instanceof Exception))
		{
			return false;
		}

		if(is_object($message) && ($message instanceof Exception))
		{
			return $this->addError($message,$disableTranslator);
		}

        if (empty($message))
        {
            return null;
        }

		// translate
		$message = (($disableTranslator==false)?$this->_translate($message):$message);

		// construct message
        if (count($args) != 0)
        {
        	$message = vsprintf($message, $this->_escape_args($args));
        }

        // log
        $this->_log->info($message);

		// write
	    if ($hop == true)
        {
        	$this->_msgs->addMessage($message);
        }
        else
        {
        	$this->_msgs_cache[] = $message;
        }

        return $this;
	}

	/**
	 * Add error message
	 * @param mixed $message Exception, Zend_Exception or String
	 * @param bool  $hop 	 isplay message in next page load
	 * @return self
	 */
	public function addError($message, $hop=true, $disableTranslator=true)
	{
		// get values from exception
		$args = array();

		if($message instanceof Zend_Exception)
        {
        	$args = $this->_escape_args($message->getArgs());
        	$message = $message->getMessage();
        }
        elseif($message instanceof Exception)
		{
        	$message = $message->getMessage();
		}

        if (empty($message))
        {
            return null;
        }

		// translate
		$message = (($disableTranslator==false)?$this->_translate($message):$message);

		// construct message
        if (count($args) != 0)
        {
        	$message = vsprintf($message, $args);
        }

        // log
        $this->_log->warn($message);

        // write
        if ($hop == true)
        {
        	$this->_errs->addMessage($message);
        }
        else
        {
        	$this->_errs_cache[] = $message;
        }

        return $this;
	}

	/**
	 * Return errors and messages
	 * @return array
	 */
	public function getMessages()
	{
	    $array = array('messages' => $this->_msgs_cache,
                       'errors'   => $this->_errs_cache);
	    
		return $array;
	}

	/**
	 * Has messages?
	 * @return bool
	 */
	public function hasMessages()
	{
		return ($this->count()!=0);
	}

	/**
	 * Clear errors and messages
	 * @return bool
	 */
	public function clearMessages()
	{
		$this->_msgs_cache = array();
		$this->_errs_cache = array();

		if (!$this->_msgs->getMessages() || !$this->_errs->getMessages())
		{
			return false;
		}

		return true;
	}

	/**
	 * Count messages
	 * @return int
	 */
	public function count()
	{
		return (count($this->_msgs_cache)+count($this->_errs_cache));
	}

	/**
	 * Check Zend_Translator initialize
	 * @return bool
	 */
	public function isTranslatorInit()
	{
		return ($this->_translator!=null);
	}

	/**
	 * Translate string before vsprinf
	 * @param str $message Message for translation
	 * @return str
	 */
	protected function _translate($message)
	{
		if (null == $this->_translator)
		{
			return $message;
		}

		return $this->_translator->_($message);
	}

	/**
	 * Deep array escape
	 * @param array $args Arguments
	 * @return array
	 */
	protected function _escape_args($args)
	{
		if (count($args) == 0)
		{
			return false;
		}

		$view = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('view');;
        foreach ($args AS $key => $value)
        {
        	$args[$key] = $view->escape($value);
        }

        return $args;
	}
}
