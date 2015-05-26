<?php

use Phly\Mustache\Mustache;
use Phly\Mustache\Pragma\ImplicitIterator as ImplicitIteratorPragma;
use Phly\Mustache\Pragma\SubViews as SubViewsPragma;
use Phly\Mustache\Exception\InvalidTemplateException;

class CamelCaseTech_View extends Zend_View
{

    /**
     * The Mustache engine
     * @var \Phly\Mustache\Mustache
     */
    protected $_mustache;

    /**
     * The mustache cache
     * @var Zend_Cache
     */
    protected $_cache = null;

    /**
     * The data in this view
     * @var array
     */
    public $_data = array();

    /**
     * Variable to avoid setting up view variables multiple times (in render function)
     * @var boolean
     */
    protected $_viewSetUp = false;

    /**
     * Creates a new Mustache view
     */
    public function __construct($config = array())
    {
        parent::__construct($config);

        $this->_mustache = new \Phly\Mustache\Mustache;
        $this->_mustache->setRenderer(new \Phly\Mustache\Renderer());

        $this->_mustache->getRenderer()->addPragma(new ImplicitIteratorPragma());
        $this->_mustache->getRenderer()->addPragma(new SubViewsPragma($this->_mustache));

        $this->_mustache->setSuffix('.phtml');
    }

    /* (non-PHPdoc)
     * @see Zend_View_Interface::getEngine()
     */
    public function getEngine()
    {
        return $this->_mustache;
    }
    
    public function assignVar($key, $val)
    {
        return $this->_data[$key] = $val;
    }

    /* (non-PHPdoc)
     * @see Zend_View_Interface::__get()
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->_data)) {
            return $this->_data[$key];
        }
    }

    /* (non-PHPdoc)
     * @see Zend_View_Interface::__set()
     */
    public function __set($key, $val)
    {
        // Needed for Zend compatibility
        $this->$key = $val;

        return $this->_data[$key] = $val;
    }

    /* (non-PHPdoc)
     * @see Zend_View_Interface::__isset()
     */
    public function __isset($key)
    {
        return isset($this->_data[$key]);
    }

    /* (non-PHPdoc)
     * @see Zend_View_Interface::__unset()
     */
    public function __unset($key)
    {
        unset($this->_data[$key]);
    }
    
    /* (non-PHPdoc)
     * @see Zend_View_Interface::render()
     */
    public function render($name)
    {
		// Load up cache and set view variables if they haven't already been
		// set.  Note that this means that subsequent calls to render() will
		// not pick up and changes to script paths!
		$this->_viewSetup();
		
		try {
			// remove ".phtml" (view renderer adds this)
			return $this->_mustache->render(substr($name, 0, -6), $this->getVars());
		} catch (\Phly\Mustache\Exception\InvalidTemplateException $e) { 
			$trace = $e->getTrace();
			$file = $trace[0]['args'][1];
			$e = new Zend_View_Exception(sprintf(
				"Could not locate Mustache view file '%s' called from '%s' (search path = %s)",
				$file,
				$name,
				join(":", $this->_mustache->getTemplatePath())
			));
			$e->setView($this);
		} catch (\Phly\Mustache\Exception\InvalidTokensException $e) {
			$trace = $e->getTrace();
			$file = $trace[2]['args'][0];
			$e = new Zend_View_Exception(sprintf(
				"Problem parsing Mustache view file '%s' called from '%s' (search path = %s)",
				$file,
				$name,
				join(":", $this->_mustache->getTemplatePath())
			));
			$e->setView($this);
		}
		throw $e;
    }
    
    /**
     * Load up cache and set view variables if they haven't already been set. 
     */
    private function _viewSetup()
    {
        if (!$this->_viewSetUp) {            
            $this->_loadCache();

            foreach ($this->getScriptPaths() as $key => $path) {
                if (file_exists($path)) {
                    $this->_mustache->setTemplatePath($path);
                }
            }

            $this->_viewSetUp = true;
        }
    }

    /**
     * Sets the Mustache cache
     * @param Zend_Cache_Core $cache
     */
    public function setCache($cache)
    {
        $this->_cache = $cache;
    }

    protected function _loadCache()
    {
        if ($this->_cache instanceof Zend_Cache_Core) {
            $cache = new CamelCaseTech_View_Cache($this->_cache);
            $this->_mustache->restoreTokens($cache);
        }
    }

}