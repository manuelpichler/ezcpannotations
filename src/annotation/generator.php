<?php
/**
 * ezcpoAnnotationGenerator
 *
 * @package Annotation
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcpoAnnotationGenerator extends ezcpoAnnotationBase
{
    /**
     * The properties for a one to many relation.
     *
     * @type array<string>
     * @var array $properties
     */
    protected $properties = array(
        "type"     =>  "",
        "param"    =>  "",
    );

    /**
     * Visitor method.
     *
     * @param ezcpoAnnotationVisitor $visitor
     */
    public function visit( ezcpoAnnotationVisitor $visitor )
    {
        $visitor->visitAnnotationGenerator( $this );
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
            case "type":
            case "param":
                $this->properties[$name] = $value;
                break;

            default:
                parent::__set( $name, $value );
                break;
        }
    }
}