<?php
/**
 * ezcpoAnnotationPersistent
 *
 * @package Annotation
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcpoAnnotationPersistent extends ezcpoAnnotationBase 
{
    /**
     * The properties for a persistent annotation.
     *
     * @type array<string>
     * @var array $properties
     */
    protected $properties = array(
        "table"  =>  "",
        "name"   =>  "",
    );

    /**
     * Visitor method.
     *
     * @param ezcpoAnnotationVisitor $visitor
     */
    public function visit( ezcpoAnnotationVisitor $visitor )
    {
        $visitor->visitAnnotationPersistent( $this );
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
        switch ( $name )
        {
            case "table":
            case "name":
                $this->properties[$name] = $value;
                break;
            
            default:
                parent::__set( $name, $value );
                break;
        }
    }
}