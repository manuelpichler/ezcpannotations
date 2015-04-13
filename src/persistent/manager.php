<?php
/**
 * ezcpoPersistentCodeManager
 *
 * @package PersistentObject
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcpoPersistentCodeManager extends ezcPersistentCodeManager 
{
    /**
     * Holds the path to the directory where the definitions are stored.
     *
     * @type string
     * @var string $dir
     */
    private $dir;
    
    /**
     * If this is <tt>true</tt> the definition gets generated from the annotations
     * and is not cached.
     * 
     * @type boolean
     * @var boolean $debug
     */
    private $debug = false;

    /**
     * Constructs a new code manager that will look for persistent object definitions in the directory $dir.
     *
     * @param string $dir
     * @param boolean $debug
     */
    public function __construct( $dir, $debug = false )
    {
        parent::__construct( $dir );
        
        // append trailing / to $dir if it does not exist.
        if ( substr( $dir, strlen( $dir ) - 1, 1) != '/' )
        {
            $dir .= '/';
        }
        $this->dir = $dir;

        $this->debug = $debug;
    }

    /**
     * Returns the definition of the persistent object with the class $class.
     *
     * @throws ezcPersistentDefinitionNotFoundException if no such definition can be found.
     * @param string $class
     * @return ezcPersistentDefinition
     */
    public function fetchDefinition( $class )
    {
        // Build definition file name
        $path = $this->dir . strtolower( $class ) . '.php';
        
        // Create reflection class instance
	    $reflection = new ezcpoReflectionClass( $class );

	    // Check file time
	    if ( $this->debug || !file_exists( $path ) || filemtime( $path ) < filemtime( $reflection->getFileName() ) )
	    {
	        // Load definition generator
	        $generator = new ezcpoPersistentObjectGenerator( $reflection );
	        
	        // Generate new definition
	        $generator->generate( $path ); 
	    }
        
	    return parent::fetchDefinition( $class );
    }
}