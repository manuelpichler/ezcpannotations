<?php
/**
 * ezcpoReflectionAnnotations
 *
 * @package Reflection
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcpoReflectionAnnotations
{
    /**
     * The context reflection object.
     * 
     * @type ezcpoReflectionAnnotated
     * @var ezcpoReflectionAnnotated $annotated
     */
    private $annotated = null;
    
    /**
     * All annotations in this collection.
     * 
     * @type array<ezcpoAnnotationBase>
     * @var array $annotations
     */
    private $annotations = null;
    
    /**
     * Constructor
     *
     * @param ezcpoReflectionAnnotated $annotated
     */
    public function __construct( ezcpoReflectionAnnotated $annotated )
    {
        $this->annotated = $annotated;
    }

    public function hasAnnotation( $name )
    {
        // Lazy load annotations
        $this->loadAnnotations();
         
        foreach ( $this->annotations as $annotation )
        {
            if ( $annotation->annotationName === $name )
            {
                return true;
            }
        }
        return false;
    }

    public function getAnnotation( $name )
    {
        foreach ( $this->annotations as $annotation )
        {
            if ( $annotation->annotationName === $name )
            {
                return $annotation;
            }
        }
        return null;
    }

    public function getAnnotations( $annotationName = null )
    {
        // Lazy load all annotations
	    $annotations = $this->loadAnnotations();
	    
	    // Check for given filter
	    if ( $annotationName === null )
	    {
	        return $annotations;
	    }
	    
	    $filtered = array();
	    
	    // Filter all annotations
	    foreach ( $annotations as $annotation )
	    {
	        // Compare names
	        if ( $annotation->annotationName === $annotationName )
	        {
	            $filtered[] = $annotation;
	        }
	    }
	    // Return result
	    return $filtered;
    }

    /**
     * Lazy load method for class annotations.
     *
     * @return array
     * @see ezcpoReflectionAnnotations::$annotations
     */
    protected function loadAnnotations()
    {
        // Check for previous load
        if ( $this->annotations !== null )
        {
            return $this->annotations;
        }
         
        // Create annotation parser
        $parser = new ezcpoReflectionParser( $this->annotated->getDocComment() );
         
        // Parse annotations
        $this->annotations = $parser->parse( $this->annotated );
         
        // Return annotations
        return $this->annotations;
    }
}