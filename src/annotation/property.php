<?php
/**
 * ezcpoAnnotationProperty
 *
 * @package Annotation
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcpoAnnotationProperty extends ezcpoAnnotationBase 
{
    /**
     * The properties for a persistent annotation.
     *
     * @type array<string>
     * @var array $properties
     */
    protected $properties = array(
        "name"    =>  "",
        "column"  =>  "",
        "type"    =>  "",
        "id"      =>  false
    );

    /**
     * Visitor method.
     *
     * @param ezcpoAnnotationVisitor $visitor
     */
    public function visit( ezcpoAnnotationVisitor $visitor )
    {
        $visitor->visitAnnotationProperty( $this );
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
            case "name":
            case "column":
            case "type":
                $this->properties[$name] = $value;
                break;
                
            case "id":
                $this->properties[$name] = ( $value === "true" );
                break;

            default:
                parent::__set( $name, $value );
                break;
        }
    }
}