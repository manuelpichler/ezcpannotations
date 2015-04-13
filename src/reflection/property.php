<?php
/**
 * ezcpoReflectionProperty
 *
 * @package Reflection
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcpoReflectionProperty extends ReflectionProperty implements ezcpoReflectionAnnotated, ezcpoReflectionNode
{
    /**
     * This <tt>ezcpoReflectionAnnotations</tt> contains all annotations.
     *
     * @type ezcpoReflectionAnnotations
     * @var ezcpoReflectionAnnotations $annotations
     */
    protected $annotations = null;

    /**
     *
     * @param string $className
     * @param string $propertyName
     */
    public function __construct( $className, $propertyName )
    {
        parent::__construct( $className, $propertyName );

        // Create an annotation collection
        $this->annotations = new ezcpoReflectionAnnotations( $this );
    }
    
    /**
     * Visitor method.
     *
     * @param ezcpoReflectionVisitor $visitor
     */
    public function visit( ezcpoReflectionVisitor $visitor )
    {
        $visitor->visitReflectionProperty( $this );
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

    /**
     * Lazy load method for class annotations.
     *
     * @return array
     * @see ezcpoReflectionClass::$annotations
     */
    protected function loadAnnotations()
    {
        // Check for previous load
        if ( $this->annotations !== null )
        {
            return $this->annotations;
        }
         
        // Create annotation parser
        $parser = new ezcpoReflectionParser( $this->getDocComment() );
         
        // Parse annotations
        $this->annotations = $parser->parse( $this );
         
        // Return annotations
        return $this->annotations;
    }
}