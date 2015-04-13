<?php
/**
 * ezcpoAnnotationBase
 *
 * @package Annotation
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
abstract class ezcpoAnnotationBase
{

    /**
     * Annotation properties.
     * 
     * @type array<mixed>
     * @var array $properties
     */
    protected $properties = array();
    
    /**
     * Constructor
     *
     * @param ezcpoReflectionAnnotated $annotatedObject The context reflection object.
     * @param string $annotationName The implementation name. 
     */
    public final function __construct( ezcpoReflectionAnnotated $annotatedObject, $annotationName )
    {
        $this->properties["annotatedObject"] = $annotatedObject;
        $this->properties["annotationName"]  = $annotationName;
        
        // Call template method
	    $this->init();
    }
    
    /**
     * Returns the value of the requested property.
     * 
     * @param string $name
     * @return string
     * @throws ezcBasePropertyNotFoundException
     */
    public function __get( $name )
    {
        if ( !array_key_exists( $name, $this->properties ) )
        {
            throw new ezcBasePropertyNotFoundException( $name );
        }
        return $this->properties[$name];
    }
    
    /**
     * Sets the property value.
     * 
     * @param string $name
     * @param string $value
     * @throws ezcBasePropertyPermissionException
     */
    public function __set( $name, $value )
    {
        // Build full property name
	    $fullName = get_class( $this ) . "::{$name}";
        
	    throw new ezcBasePropertyPermissionException( $fullName, ezcBasePropertyPermissionException::READ );
    }

    /**
     * This template method allows custom init code in the annotation classes.
     *
     * @return void
     */
    protected function init()
    {
        // Nothing to do here
    }
    
    /**
     * Visitor method.
     * 
     * @param ezcpoAnnotationVisitor $visitor
     */
    public abstract function visit( ezcpoAnnotationVisitor $visitor );
}