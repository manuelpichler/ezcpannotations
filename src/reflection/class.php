<?php
/**
 * ezcpoReflectionClass
 *
 * @package Reflection
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcpoReflectionClass extends ReflectionClass implements ezcpoReflectionAnnotated, ezcpoReflectionNode
{    
    /**
     * This <tt>ezcpoReflectionAnnotations</tt> contains all class annotations.
     * 
     * @type ezcpoReflectionAnnotations
     * @var ezcpoReflectionAnnotations $annotations
     */
    protected $annotations = null;
    
    /**
     * This <tt>array</tt> contains the custom reflection properties. 
     *
     * @type array<ezcpoReflectionProperty>
     * @var array $reflectionProperties
     */
    protected $reflectionProperties = null;
    
    /**
     * This <tt>array</tt> contains a index to property name mapping.
     * 
     * @type array<integer>
     * @var array $propertyNames
     */
    protected $propertyNames = null;
	
	/**
	 * 
	 * @param string $className
	 */
	public function __construct( $className )
	{
		parent::__construct( $className );
		
		// Create an annotation collection
	    $this->annotations = new ezcpoReflectionAnnotations( $this );
	}
	
	/**
	 * Returns a <tt>ezcpoReflectionProperty</tt> instance for the given
	 * <tt>$propertyName</tt>. 
	 *
	 * @param string $propertyName
	 * @return ezcpoReflectionProperty
	 * @throws ReflectionException
	 */
	public function getProperty( $propertyName )
	{
	    // Lazy load properties
	    $this->loadProperties();
	    
	    // Check for property existence
	    if ( isset( $this->propertyNames[$propertyName] ) )
	    {
	        return $this->reflectionProperties[$this->propertyNames[$propertyName]];
	    }
	    
	    throw new ReflectionException( "Property {$propertyName} does not exist" );
	}
	
	public function getProperties( $filter = null )
	{
	    // Lazy load properties
	    $this->loadProperties();
	    
	    return $this->reflectionProperties;
	}
	
	public function hasAnnotation( $name )
	{
	    return $this->annotations->hasAnnotation( $name );
	}
	
	public function getAnnotation( $name )
	{
	    return $this->annotations->getAnnotation( $name );
	}
	
	public function getAnnotations( $annotationName = null )
	{
	    return $this->annotations->getAnnotations( $annotationName );
	}
	
	public function visit( ezcpoReflectionVisitor $visitor )
	{
	    $visitor->visitReflectionClass( $this );
	}
	
	/**
	 * Lazy load method for custom reflection property implementation. 
	 *
	 * @return void
	 * @see ezcpoReflectionClass::$properties
	 */
	protected function loadProperties()
	{
	    // Check for previous load
	    if ( $this->reflectionProperties !== null )
	    {
	        return;
	    }
	    
	    // Init properties arrays
	    $this->reflectionProperties = array();
	    $this->propertyNames        = array();
	    
	    // Ask parent class for all object properties
	    foreach ( parent::getProperties() as $index => $property )
	    {
	        // Get property name
	        $propertyName = $property->getName();
	        
	        // Store custom implementation
	        $this->reflectionProperties[$index] = new ezcpoReflectionProperty( $this->getName(), $propertyName );
	        
	        // Store name to index pair
	        $this->propertyNames[$propertyName] = $index;
	    }
	}
	
}